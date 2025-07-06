<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absen;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AbsenController extends Controller
{
    public function index()
    {
        // Dapatkan guru yang sedang login
        $guruId = Auth::user()->guru->id_guru;

        $taAktif = TahunAjaran::where('is_active', true)->first();

        if (!$taAktif) {
            return view('guru.absen', [
                'data' => collect(),
                'kelas' => null,
                'message' => 'Tidak ada tahun ajaran aktif yang ditemukan. Data absensi tidak dapat ditampilkan.'
            ]);
        }

        // --- PERBAIKAN DI SINI: Panggil $kelas SEKALI dan filter dengan TA aktif ---
        $kelas = Kelas::where('id_guru', $guruId)
            ->where('id_ta', $taAktif->id_ta) // Filter berdasarkan tahun ajaran aktif
            ->first();

        if (!$kelas) {
            return view('guru.absen', ['data' => collect(), 'kelas' => null, 'message' => 'Anda tidak mengampu kelas apapun di tahun ajaran aktif ini.']);
        }

        $data = Absen::select(
            'tanggal',
            DB::raw('count(*) as total'),
            DB::raw("sum(case when status = 'H' then 1 else 0 end) as hadir"),
            DB::raw("sum(case when status = 'I' then 1 else 0 end) as izin"),
            DB::raw("sum(case when status = 'S' then 1 else 0 end) as sakit"),
            DB::raw("sum(case when status = 'A' then 1 else 0 end) as alpha")
        )
            ->whereHas('kelasSiswa.kelas', function ($query) use ($kelas, $taAktif) {
                // $kelas di sini sudah benar dari TA aktif
                $query->where('id_k', $kelas->id_k)
                    ->where('id_ta', $taAktif->id_ta); // Filter sudah benar di sini
            })
            ->groupBy('tanggal')
            ->orderByDesc('tanggal')
            ->get();

        return view('guru.absen', compact('data', 'kelas'));
    }

    public function create()
    {
        // Ambil guru yang sedang login
        $guruId = Auth::user()->guru->id_guru;

        $taAktif = TahunAjaran::where('is_active', true)->first();
        if (!$taAktif) {
            return redirect()->route('guru.absen')->with('error', 'Tidak ada tahun ajaran aktif untuk mengelola absensi.');
        }

        // Ambil kelas yang diajar guru ini UNTUK TAHUN AJARAN AKTIF
        $kelas = Kelas::where('id_guru', $guruId)
            ->where('id_ta', $taAktif->id_ta)
            ->first();

        if (!$kelas) {
            return redirect()->route('guru.absen')->with('error', 'Anda tidak mengampu kelas apapun di tahun ajaran aktif ini.');
        }

        // Ambil semua relasi kelas_siswa beserta data siswa-nya UNTUK KELAS DI TAHUN AJARAN AKTIF
        // Karena $kelas sudah difilter berdasarkan id_ta, cukup filter berdasarkan id_kelas saja.
        $kelasSiswa = KelasSiswa::with('siswa')
            ->where('id_kelas', $kelas->id_k)
            ->get();

        $tanggal = now()->format('Y-m-d');

        return view('guru.inputabsen', compact('kelasSiswa', 'tanggal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'absen' => 'required|array'
        ]);

        $tanggal = $request->tanggal;
        $dataAbsen = $request->absen; // format: [id_kelas_siswa => status]

        $taAktif = TahunAjaran::where('is_active', true)->first();
        if (!$taAktif) {
            return redirect()->back()->with('error', 'Tidak ada tahun ajaran aktif saat menyimpan absensi.');
        }

        // Validasi dan dapatkan id_kelas dari guru yang login di TA aktif
        $guruId = Auth::user()->guru->id_guru;
        $kelasGuruAktif = Kelas::where('id_guru', $guruId)
            ->where('id_ta', $taAktif->id_ta)
            ->first();

        if (!$kelasGuruAktif) {
            return redirect()->back()->with('error', 'Kelas tidak ditemukan untuk guru dan tahun ajaran aktif ini.');
        }
        $idKelasYangDiajarGuru = $kelasGuruAktif->id_k;


        foreach ($dataAbsen as $id_kelas_siswa => $status) {
            // Pastikan id_kelas_siswa yang dikirim dari form adalah milik kelas yang diajar guru di TA aktif
            $kelasSiswaValid = KelasSiswa::where('id_kelas_siswa', $id_kelas_siswa)
                ->where('id_kelas', $idKelasYangDiajarGuru)
                ->whereHas('kelas', function ($query) use ($taAktif) {
                    $query->where('id_ta', $taAktif->id_ta);
                })
                ->first();

            if (!$kelasSiswaValid) {
                Log::warning("AbsenController: id_kelas_siswa tidak valid atau tidak sesuai TA aktif: $id_kelas_siswa");
                continue;
            }

            Absen::updateOrCreate(
                [
                    'id_kelas_siswa' => $kelasSiswaValid->id_kelas_siswa,
                    'tanggal' => $tanggal
                ],
                [
                    'status' => $status
                ]
            );
        }

        return redirect()->route('guru.absen')->with('success', 'Absensi berhasil disimpan.');
    }

    public function detail($tanggal)
    {
        $guruId = Auth::user()->guru->id_guru;

        $taAktif = TahunAjaran::where('is_active', true)->first();
        if (!$taAktif) {
            return redirect()->route('guru.absen')->with('error', 'Tidak ada tahun ajaran aktif untuk melihat detail absensi.');
        }

        // Ambil kelas yang diajar guru ini UNTUK TAHUN AJARAN AKTIF
        $kelas = Kelas::where('id_guru', $guruId)
            ->where('id_ta', $taAktif->id_ta)
            ->first();

        if (!$kelas) {
            return redirect()->route('guru.absen')->with('error', 'Anda tidak mengampu kelas apapun di tahun ajaran aktif ini.');
        }

        // Ambil data kelas_siswa + relasi siswa UNTUK KELAS DI TAHUN AJARAN AKTIF
        $kelasSiswa = KelasSiswa::with('siswa')
            ->where('id_kelas', $kelas->id_k)
            ->get();

        // Ambil data absen untuk tanggal tertentu
        $absensi = Absen::whereDate('tanggal', $tanggal)
            ->whereIn('id_kelas_siswa', $kelasSiswa->pluck('id_kelas_siswa'))
            ->get()
            ->keyBy('id_kelas_siswa');

        return view('guru.absendetail', compact('kelasSiswa', 'tanggal', 'absensi'));
    }

    public function updateDetail(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'absen' => 'required|array',
            'absen.*' => 'in:H,S,I,A' // Validasi status yang diizinkan
        ]);

        $tanggal = $request->tanggal;
        $dataAbsen = $request->absen; // format: [id_kelas_siswa => status]

        $taAktif = TahunAjaran::where('is_active', true)->first();
        if (!$taAktif) {
            return redirect()->back()->with('error', 'Tidak ada tahun ajaran aktif saat memperbarui absensi.');
        }

        // Validasi dan dapatkan id_kelas dari guru yang login di TA aktif
        $guruId = Auth::user()->guru->id_guru;
        $kelasGuruAktif = Kelas::where('id_guru', $guruId)
            ->where('id_ta', $taAktif->id_ta)
            ->first();

        if (!$kelasGuruAktif) {
            return redirect()->back()->with('error', 'Kelas tidak ditemukan untuk guru dan tahun ajaran aktif ini.');
        }
        $idKelasYangDiajarGuru = $kelasGuruAktif->id_k;

        foreach ($dataAbsen as $id_kelas_siswa => $status) {
            // Pastikan id_kelas_siswa yang dikirim dari form adalah milik kelas yang diajar guru di TA aktif
            $kelasSiswaValid = KelasSiswa::where('id_kelas_siswa', $id_kelas_siswa)
                ->where('id_kelas', $idKelasYangDiajarGuru)
                ->whereHas('kelas', function ($query) use ($taAktif) {
                    $query->where('id_ta', $taAktif->id_ta);
                })
                ->first();

            if (!$kelasSiswaValid) {
                Log::warning("AbsenController@updateDetail: id_kelas_siswa tidak valid atau tidak sesuai TA aktif: $id_kelas_siswa untuk tanggal $tanggal");
                continue; // Lewati siswa ini jika tidak valid/tidak berhak diakses
            }

            // Update atau buat record absensi
            Absen::updateOrCreate(
                [
                    'id_kelas_siswa' => $kelasSiswaValid->id_kelas_siswa,
                    'tanggal' => $tanggal
                ],
                [
                    'status' => $status
                ]
            );
        }

        return redirect()->route('guru.absen')->with('success', 'Absensi tanggal ' . \Carbon\Carbon::parse($tanggal)->format('d-m-Y') . ' berhasil diperbarui.');
    }
}