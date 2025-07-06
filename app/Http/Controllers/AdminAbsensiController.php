<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Absen;
use App\Models\TahunAjaran;
use App\Models\Alur;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\KelasSiswa;

class AdminAbsensiController extends Controller
{
    public function index()
    {
        $data = TahunAjaran::all();
        return view('admin.absen.tahunajaran', compact('data'));
    }

    public function kelas($id_ta)
    {
        $kelas = Kelas::where('id_ta', $id_ta)->with('guru')->get();
        $tahunAjaran = TahunAjaran::find($id_ta); // untuk ditampilkan di header
        return view('admin.absen.kelas', compact('kelas', 'id_ta', 'tahunAjaran'));
    }

    public function absen($id_ta, $id_kelas)
    {
        $kelas = Kelas::with('guru')->findOrFail($id_kelas);
        $tahunAjaran = TahunAjaran::findOrFail($id_ta);

        $data = DB::table('absen')
            ->join('kelas_siswa', 'absen.id_kelas_siswa', '=', 'kelas_siswa.id_kelas_siswa')
            ->where('kelas_siswa.id_kelas', $id_kelas)
            ->select(
                'absen.tanggal',
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN absen.status = 'H' THEN 1 ELSE 0 END) as hadir"),
                DB::raw("SUM(CASE WHEN absen.status = 'I' THEN 1 ELSE 0 END) as izin"),
                DB::raw("SUM(CASE WHEN absen.status = 'S' THEN 1 ELSE 0 END) as sakit"),
                DB::raw("SUM(CASE WHEN absen.status = 'A' THEN 1 ELSE 0 END) as alpha")
            )
            ->groupBy('absen.tanggal')
            ->orderBy('absen.tanggal', 'desc')
            ->get();
        return view('admin.absen.absen', compact('data', 'kelas', 'tahunAjaran', 'id_ta'));
    }

    public function detail($id_ta, $id_k, $tanggal)
    {
        // Ambil data kelas berdasarkan id_k
        $kelas = Kelas::findOrFail($id_k);

        // Ambil semua siswa di kelas ini (dari tabel kelas_siswa)
        $kelasSiswa = KelasSiswa::with('siswa')
            ->where('id_kelas', $id_k)
            ->get();

        // Ambil data absen untuk masing-masing siswa pada tanggal tersebut
        $absensi = Absen::whereIn('id_kelas_siswa', $kelasSiswa->pluck('id_kelas_siswa'))
            ->where('tanggal', $tanggal)
            ->get()
            ->keyBy('id_kelas_siswa');

        return view('admin.absen.detail', compact('kelas', 'kelasSiswa', 'absensi', 'id_ta', 'tanggal'));
    }
}