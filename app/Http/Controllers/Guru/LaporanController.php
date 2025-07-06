<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\TahunAjaran;
use App\Models\Siswa;
use App\Models\KelasSiswa;
use App\Models\Semester;
use App\Models\Laporan;
use App\Models\Guru; // Tidak digunakan langsung di sini, tapi dipertahankan
use App\Models\Cp; // Asumsi ini adalah model untuk tabel 'cps' Anda
use App\Models\DesLaporan;
use App\Models\Absen;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\HasilPh; // Tambahkan ini agar HasilPh::with() bisa digunakan tanpa error

class LaporanController extends Controller
{
    public function index()
    {
        // Ambil data guru yang login melalui relasi user
        $guru = Auth::user()->guru;

        $taAktif = TahunAjaran::where('is_active', true)->first();

        if (!$taAktif) {
            return redirect()->back()->with('error', 'Tidak ada tahun ajaran aktif yang ditemukan.');
        }

        $data = Siswa::whereHas('kelas', function ($query) use ($guru, $taAktif) {
            $query->where('id_guru', $guru->id_guru)
                ->where('id_ta', $taAktif->id_ta);
        })->where('status', 'A')
        ->with('kelasSiswaAktif')
        ->get();

         $idKelasSiswaAktifGuru = KelasSiswa::select('kelas_siswa.id_kelas_siswa')
            ->join('kelas', 'kelas.id_k', '=', 'kelas_siswa.id_kelas')
            ->where('kelas.id_guru', $guru->id_guru)
            ->where('kelas.id_ta', $taAktif->id_ta)
            ->pluck('kelas_siswa.id_kelas_siswa');
        $laporan = Laporan::whereIn('id_kelas_siswa', function ($query) use ($guru, $taAktif) {
            $query->select('kelas_siswa.id_kelas_siswa')
                ->from('kelas_siswa')
                ->join('kelas', 'kelas.id_k', '=', 'kelas_siswa.id_kelas')
                ->where('kelas.id_guru', $guru->id_guru)
                ->where('kelas.id_ta', $taAktif->id_ta);
        })->get()->keyBy('id_kelas_siswa');

        return view('guru.laporan', compact('data', 'laporan'));
    }

    public function show($noinduk)
    {
        $siswa = Siswa::where('noinduk', $noinduk)->firstOrFail();

        $taAktif = TahunAjaran::where('is_active', true)->first();
        if (!$taAktif) {
            return redirect()->back()->with('error', 'Tidak ada tahun ajaran aktif yang ditemukan.');
        }

        // --- Perbaikan: Ambil KelasSiswa yang BENAR untuk siswa ini di TAHUN AJARAN AKTIF ---
        $kelasSiswa = KelasSiswa::with('kelas')
                                ->where('noinduk', $noinduk)
                                ->whereHas('kelas', function ($query) use ($taAktif) {
                                    $query->where('id_ta', $taAktif->id_ta); // Filter melalui tabel 'kelas'
                                })
                                ->firstOrFail();
        $idKelasSiswa = $kelasSiswa->id_kelas_siswa; // Gunakan ID ini untuk semua query selanjutnya

        $semesterAktif = Semester::where('aktif', 1)->first();

        // Ambil semua CP yang punya alur semester aktif
        $cps = \App\Models\Cp::whereIn('id_c', function ($q) use ($semesterAktif) {
            $q->select('id_c')->from('alur')->where('semester', $semesterAktif->semester);
        })->get();

        $uniqueCps = $cps->unique('materi')->values();

        // Ambil hasilpb (penilaian bulanan)
        $hasilPBs = \App\Models\Hasilpb::with('alur.capaian')
            ->where('id_kelas_siswa', $idKelasSiswa) // Gunakan id_kelas_siswa yang sudah difilter TA aktif
            ->get();

        $nilaiPerMateri = $hasilPBs
            ->filter(fn($item) => isset($item->alur->capaian->materi))
            ->groupBy(fn($item) => $item->alur->capaian->materi)
            ->map(fn($group) => round($group->avg('hasil')));

        $deskripsiList = DesLaporan::with('cp')
            ->get()
            ->filter(fn($item) => $item->cp && $item->cp->materi)
            ->groupBy(fn($item) => trim($item->cp->materi))
            ->map->keyBy('nilaiakhir');

        // Ambil laporan yang sudah tersimpan untuk id_kelas_siswa ini
        // Sesuai dengan struktur awal Anda yang mungkin menyimpan banyak baris per materi
        $laporanSebelumnya = Laporan::where('id_kelas_siswa', $idKelasSiswa) // Gunakan id_kelas_siswa yang sudah difilter TA aktif
            ->with('cp')
            ->get()
            ->groupBy(fn($item) => trim($item->cp->materi));

        // Ambil seluruh hasilph dengan dokumentasi
        $allHasilPh = \App\Models\HasilPh::with('penilaianharian.alur.capaian')
            ->where('id_kelas_siswa', $idKelasSiswa) // Gunakan id_kelas_siswa yang sudah difilter TA aktif
            ->whereNotNull('dokumentasi')
            ->where('dokumentasi', '!=', '')
            ->get();

        // Ambil id_hph yang sudah tersimpan di laporan
        // Ini akan mengambil semua id_hph yang tersimpan untuk id_kelas_siswa ini
        $idHphTerpilih = Laporan::where('id_kelas_siswa', $idKelasSiswa) // Gunakan id_kelas_siswa yang sudah difilter TA aktif
            ->whereNotNull('id_hph')
            ->pluck('id_hph')
            ->unique();

        // Dokumentasi yang dipilih dari laporan
        // Ini akan mengumpulkan semua dokumentasi yang sudah terdaftar di laporan
        $dokumentasiTerpilih = $allHasilPh
            ->filter(fn($hph) => $idHphTerpilih->contains($hph->id_hph))
            ->groupBy(fn($hph) => trim($hph->penilaianharian->alur->capaian->materi));

        // Semua dokumentasi hasilph
        $dokumentasiLengkap = $allHasilPh
            ->groupBy(fn($hph) => trim($hph->penilaianharian->alur->capaian->materi));

        return view('guru.laporanedit', compact(
            'siswa',
            'kelasSiswa',
            'uniqueCps',
            'nilaiPerMateri',
            'deskripsiList',
            'dokumentasiTerpilih',
            'dokumentasiLengkap',
            'laporanSebelumnya'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'noinduk' => 'required',
            'nilaiakhir' => 'required|array',
            'keterangan' => 'required|array',
        ]);

        $noinduk = $request->noinduk;

        $taAktif = TahunAjaran::where('is_active', true)->first();
        if (!$taAktif) {
            return redirect()->back()->with('error', 'Tidak ada tahun ajaran aktif saat menyimpan.');
        }

        // --- Perbaikan: Ambil KelasSiswa yang BENAR untuk siswa ini di TAHUN AJARAN AKTIF ---
        $kelasSiswa = KelasSiswa::where('noinduk', $noinduk)
                                ->whereHas('kelas', function ($query) use ($taAktif) {
                                    $query->where('id_ta', $taAktif->id_ta); // Filter melalui tabel 'kelas'
                                })
                                ->firstOrFail();
        $idKelasSiswa = $kelasSiswa->id_kelas_siswa; // Gunakan ID ini untuk semua query selanjutnya

        foreach ($request->nilaiakhir as $id_c => $nilai) {
            $cp = Cp::find($id_c);
            if (!$cp) continue;

            $materi = trim($cp->materi);

            // Perlu diperhatikan: id_hpb dan id_hph di tabel Laporan Anda
            // Asumsi id_hpb adalah representasi dari hasil PB per alur
            // Asumsi id_hph adalah ID dari satu dokumentasi yang terpilih
            $id_hpb = \App\Models\Hasilpb::whereHas('alur.capaian', function ($query) use ($materi) {
                $query->where('materi', $materi);
            })
                ->where('id_kelas_siswa', $idKelasSiswa) // Gunakan id_kelas_siswa yang sudah difilter TA aktif
                ->latest()
                ->value('id_hpb');

            $idHphList = $request->input("id_hph.$id_c", []);

            Laporan::where('id_kelas_siswa', $idKelasSiswa)
                ->where('id_c', $id_c)
                ->whereNotIn('id_hph', $idHphList ?: [null]) 
                ->delete();

            if (empty($idHphList)) {
                Laporan::updateOrCreate(
                    [
                        'id_kelas_siswa' => $idKelasSiswa, 
                        'id_c' => $cp->id_c,
                        'id_hph' => null,
                    ],
                    [
                        'id_hpb' => $id_hpb,
                        'nilaiakhir' => $nilai,
                        'keterangan' => $request->keterangan[$id_c] ?? '-',
                        'dokumentasi' => null,
                    ]
                );
            } else {

                foreach ($idHphList as $id_hph) {
                    $id_hph = intval($id_hph);
                    $hasilph = \App\Models\HasilPh::find($id_hph); 

                    Laporan::updateOrCreate(
                        [
                            'id_kelas_siswa' => $idKelasSiswa, // Gunakan id_kelas_siswa yang sudah difilter TA aktif
                            'id_c' => $cp->id_c,
                            'id_hph' => $id_hph, // id_hph akan terisi di sini
                        ],
                        [
                            'id_hpb' => $id_hpb, // Ini akan sama untuk semua baris laporan materi yang sama
                            'nilaiakhir' => $nilai, // Ini akan sama untuk semua baris laporan materi yang sama
                            'keterangan' => $request->keterangan[$id_c] ?? '-',
                            'dokumentasi' => $hasilph?->dokumentasi, // Ambil path dokumentasi dari HasilPh
                        ]
                    );
                }
            }
        }

        return redirect()->route('lap.index')->with('success', 'Laporan berhasil disimpan.');
    }

    public function ekspor($noinduk)
    {
        $taAktif = TahunAjaran::where('is_active', true)->first();
        if (!$taAktif) {
            return redirect()->back()->with('error', 'Tidak ada tahun ajaran aktif yang ditemukan.');
        }

        $siswa = Siswa::with(['orangtua', 'kelas' => function ($q) use ($taAktif) {
            $q->where('id_ta', $taAktif->id_ta);
        }])->where('noinduk', $noinduk)->firstOrFail();

        // Menggunakan filter id_ta untuk kelasSiswa di ekspor
        $kelasSiswa = KelasSiswa::where('noinduk', $noinduk)
            ->whereHas('kelas', function ($q) use ($taAktif) {
                $q->where('id_ta', $taAktif->id_ta);
            })->firstOrFail();

        // Ambil laporan yang sudah disimpan, dikelompokkan per materi
        $laporan = Laporan::with('cp') // relasi ke tabel cps
            ->where('id_kelas_siswa', $kelasSiswa->id_kelas_siswa)
            ->get()
            ->groupBy(fn($item) => trim($item->cp->materi));

        //absen
        $hadir = Absen::where('id_kelas_siswa', $kelasSiswa->id_kelas_siswa)->where('status', 'H')->count();
        $sakit = Absen::where('id_kelas_siswa', $kelasSiswa->id_kelas_siswa)->where('status', 'S')->count();
        $izin = Absen::where('id_kelas_siswa', $kelasSiswa->id_kelas_siswa)->where('status', 'I')->count();
        $alfa = Absen::where('id_kelas_siswa', $kelasSiswa->id_kelas_siswa)->where('status', 'A')->count();

        $tinggiBadan = $siswa->tinggibadan;
        $beratBadan = $siswa->beratbadan;
        $lingkarKpl = $siswa->lingkarkpl;

        $kepsek = Guru::where('jabatan', 'kepala_sekolah')->first();
        $waliKelas = Auth::user()->guru;

        // kirim ke view
        $pdf = Pdf::loadView('guru.lappdf', compact(
            'siswa',
            'laporan',
            'hadir',
            'sakit',
            'izin',
            'alfa',
            'tinggiBadan',
            'beratBadan',
            'lingkarKpl',
            'kepsek',
            'waliKelas'
        ));
        return $pdf->stream('laporan_' . $siswa->nama . '.pdf');
    }
}