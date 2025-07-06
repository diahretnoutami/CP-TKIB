<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use App\Models\PenilaianHarian;
use App\Models\Hasilpm;
use App\Models\Siswa;
use App\Models\Hasilpb;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function tanggalHarian($noinduk)
    {
        // Ambil data kelas siswa aktif dari noinduk
        $siswa = Siswa::with('kelasSiswaAktif')->where('noinduk', $noinduk)->first();

        if (!$siswa || !$siswa->kelasSiswaAktif) {
            return response()->json([
                'status' => false,
                'message' => 'Data kelas siswa tidak ditemukan'
            ], 404);
        }

        $id_ta = $siswa->kelasSiswaAktif->id_ta;

        // Ambil semua tanggal dari penilaian harian di tahun ajaran tersebut
        $tanggal = PenilaianHarian::where('id_ta', $id_ta)
            ->orderBy('tanggal', 'desc')
            ->pluck('tanggal')
            ->unique()
            ->values();

        return response()->json([
            'status' => true,
            'message' => 'Tanggal penilaian harian berhasil diambil',
            'tanggal' => $tanggal
        ]);
    }

    public function harianByTanggal($noinduk, $tanggal)
    {
        $siswa = \App\Models\Siswa::with('kelasSiswaAktif')->where('noinduk', $noinduk)->first();

        if (!$siswa || !$siswa->kelasSiswaAktif) {
            return response()->json([
                'status' => false,
                'message' => 'Data siswa atau kelas tidak ditemukan'
            ], 404);
        }

        $id_kelas_siswa = $siswa->kelasSiswaAktif->id_kelas_siswa;

        $hasilph = \App\Models\Hasilph::with(['penilaianHarian.alur', 'penilaianHarian.tema'])
            ->where('id_kelas_siswa', $id_kelas_siswa)
            ->whereHas('penilaianHarian', function ($q) use ($tanggal) {
                $q->where('tanggal', $tanggal);
            })
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data penilaian harian berhasil diambil',
            'data' => $hasilph
        ]);
    }

    public function mingguList($noinduk)
    {
        $siswa = \App\Models\Siswa::with('kelasSiswaAktif')->where('noinduk', $noinduk)->first();

        if (!$siswa || !$siswa->kelasSiswaAktif) {
            return response()->json([
                'status' => false,
                'message' => 'Data siswa tidak ditemukan'
            ], 404);
        }

        $id_kelas_siswa = $siswa->kelasSiswaAktif->id_kelas_siswa;

        $mingguList = \App\Models\Hasilpm::where('id_kelas_siswa', $id_kelas_siswa)
            ->pluck('minggu')
            ->unique()
            ->sort()
            ->values();

        return response()->json([
            'status' => true,
            'minggu' => $mingguList
        ]);
    }

    public function mingguanByMinggu($noinduk, $minggu)
    {
        $siswa = \App\Models\Siswa::with('kelasSiswaAktif')->where('noinduk', $noinduk)->first();

        if (!$siswa || !$siswa->kelasSiswaAktif) {
            return response()->json([
                'status' => false,
                'message' => 'Data siswa tidak ditemukan'
            ], 404);
        }

        $id_kelas_siswa = $siswa->kelasSiswaAktif->id_kelas_siswa;

        $hasilpm = \App\Models\Hasilpm::with('alur')
            ->where('id_kelas_siswa', $id_kelas_siswa)
            ->where('minggu', $minggu)
            ->get();

        return response()->json([
            'status' => true,
            'minggu' => $minggu,
            'penilaian' => $hasilpm
        ]);
    }

    public function listBulan($noinduk)
    {
        $siswa = Siswa::with('kelasSiswaAktif')->where('noinduk', $noinduk)->first();

        if (!$siswa || !$siswa->kelasSiswaAktif) {
            return response()->json([
                'status' => false,
                'message' => 'Data siswa atau kelas tidak ditemukan'
            ], 404);
        }

        $id_kelas_siswa = $siswa->kelasSiswaAktif->id_kelas_siswa;

        // Ambil semua bulan unik dari hasilpb
        $bulanList = Hasilpb::where('id_kelas_siswa', $id_kelas_siswa)
            ->pluck('bulan')
            ->unique()
            ->values();

        return response()->json([
            'status' => true,
            'message' => 'Daftar bulan penilaian bulanan berhasil diambil',
            'bulan' => $bulanList
        ]);
    }

    public function bulananByBulan($noinduk, $bulan)
    {
        $siswa = Siswa::with('kelasSiswaAktif')->where('noinduk', $noinduk)->first();

        if (!$siswa || !$siswa->kelasSiswaAktif) {
            return response()->json([
                'status' => false,
                'message' => 'Data siswa atau kelas tidak ditemukan'
            ], 404);
        }

        $id_kelas_siswa = $siswa->kelasSiswaAktif->id_kelas_siswa;

        $hasilpb = \App\Models\Hasilpb::with('alur')
            ->where('id_kelas_siswa', $id_kelas_siswa)
            ->where('bulan', $bulan)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data penilaian bulanan berhasil diambil',
            'data' => $hasilpb
        ]);
    }
}