<?php

namespace App\Http\Controllers;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use Illuminate\Support\Facades\Log;
use App\Models\KelasSiswa;
use App\Models\Laporan;
use App\Models\Siswa;
use App\Models\DesLaporan;
use App\Models\Semester;
use Illuminate\Http\Request;

class AdminLaporanController extends Controller
{
    public function index()
    {
        $data = TahunAjaran::all();
        return view('admin.laporan.tahunajaran', compact('data'));
    }

     public function kelas($id_ta)
    {
        $kelas = Kelas::where('id_ta', $id_ta)->with('guru')->get();
        $tahunAjaran = TahunAjaran::find($id_ta); // untuk ditampilkan di header
        return view('admin.laporan.kelas', compact('kelas', 'id_ta', 'tahunAjaran'));
    }

    public function siswa($id_k)
    {
        Log::info("Memuat siswa untuk kelas ID: " . $id_k);
        $kelas = Kelas::findOrFail($id_k);
        $siswa = KelasSiswa::with('siswa')
            ->where('id_kelas', $id_k)
            ->get();
        Log::info("Jumlah siswa ditemukan: " . $siswa->count());
        $id_ta = $kelas->id_ta;
        return view('admin.laporan.siswa', compact('kelas', 'siswa', 'id_ta'));
    }

     public function detail($id_kelas_siswa) // <<< UBAH PARAMETER INI
    {
        // Cari data KelasSiswa berdasarkan id_kelas_siswa
        // Gunakan with('siswa') untuk langsung memuat data siswa terkait
        $kelasSiswa = KelasSiswa::with('siswa', 'kelas')->findOrFail($id_kelas_siswa); // <<< UBAH BARIS INI
        $siswa = $kelasSiswa->siswa; // Ambil objek siswa dari relasi kelasSiswa

        $semesterAktif = Semester::where('aktif', 1)->first();

        // Ambil semua CP yang punya alur semester aktif
        $cps = \App\Models\Cp::whereIn('id_c', function ($q) use ($semesterAktif) {
            $q->select('id_c')->from('alur')->where('semester', $semesterAktif->semester);
        })->get();

        $uniqueCps = $cps->unique('materi')->values();

        // Ambil hasilpb (penilaian bulanan)
        $hasilPBs = \App\Models\Hasilpb::with('alur.capaian')
            ->where('id_kelas_siswa', $kelasSiswa->id_kelas_siswa)
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

        $laporanSebelumnya = Laporan::where('id_kelas_siswa', $id_kelas_siswa) // <<< PASTIKAN INI PAKE id_kelas_siswa
            ->with('cp')
            ->get()
            ->groupBy(fn($item) => trim($item->cp->materi));

        // Ambil seluruh hasilph dengan dokumentasi
        $allHasilPh = \App\Models\HasilPh::with('penilaianharian.alur.capaian')
            ->where('id_kelas_siswa', $id_kelas_siswa) // <<< PASTIKAN INI PAKE id_kelas_siswa
            ->whereNotNull('dokumentasi')
            ->where('dokumentasi', '!=', '')
            ->get();

        // Ambil id_hph yang sudah tersimpan di laporan
        $idHphTerpilih = Laporan::where('id_kelas_siswa', $id_kelas_siswa) // <<< PASTIKAN INI PAKE id_kelas_siswa
            ->whereNotNull('id_hph')
            ->pluck('id_hph')
            ->unique();

        // Dokumentasi yang dipilih dari laporan
        $dokumentasiTerpilih = $allHasilPh
            ->filter(fn($hph) => $idHphTerpilih->contains($hph->id_hph))
            ->groupBy(fn($hph) => trim($hph->penilaianharian->alur->capaian->materi));

        // Semua dokumentasi hasilph
        $dokumentasiLengkap = $allHasilPh
            ->groupBy(fn($hph) => trim($hph->penilaianharian->alur->capaian->materi));

        return view('admin.laporan.detaillap', compact( // <<< PASTIKAN PATH VIEWNYA BENAR
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


}