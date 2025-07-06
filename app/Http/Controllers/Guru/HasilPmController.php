<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\HasilPm;
use App\Models\KelasSiswa;

class HasilPmController extends Controller
{
    // Menampilkan daftar siswa yang diajar oleh guru
    public function index()
    {
        $guru = Auth::user()->guru;

        $taAktif = \App\Models\TahunAjaran::where('is_active', true)->first();

        $data = \App\Models\Siswa::whereHas('kelas', function ($query) use ($guru, $taAktif) {
            $query->where('id_guru', $guru->id_guru)
                ->where('id_ta', $taAktif->id_ta);
        })->where('status', 'A')->get();

        return view('guru.hpm', compact('data'));
    }

    // Menampilkan pilihan minggu untuk siswa yang dipilih
    public function pilihMinggu($noinduk)
    {
        $kelasSiswa = KelasSiswa::where('noinduk', $noinduk)->firstOrFail();

        // Buat array minggu ke-1 sampai ke-16
        $minggu = range(1, 16);

        return view('guru.hpminputmgg', [
            'kelasSiswa' => $kelasSiswa,
            'minggu' => $minggu
        ]);
    }

    // Form input nilai mingguan
    public function inputNilai($id_kelas_siswa, $minggu)
    {
        $kelasSiswa = KelasSiswa::with('siswa')->findOrFail($id_kelas_siswa);

        $taAktif = \App\Models\TahunAjaran::where('is_active', true)->first();

        // Ambil semua id_ph dari minggu dan tahun ajaran aktif
        $ph = \App\Models\PenilaianHarian::where('minggu', $minggu)
            ->where('id_ta', $taAktif->id_ta)
            ->pluck('id_ph');

        // Ambil id_a (alur) yang memiliki hasilph dan penilaian_harian di minggu dan TA aktif
        $alurIDs = \App\Models\HasilPh::where('id_kelas_siswa', $id_kelas_siswa)
            ->whereIn('hasilph.id_ph', $ph)
            ->join('penilaian_harian', 'hasilph.id_ph', '=', 'penilaian_harian.id_ph')
            ->pluck('penilaian_harian.id_a')
            ->unique();

        // Ambil daftar alur yang relevan
        $daftarAlur = \App\Models\Alur::whereIn('id_a', $alurIDs)->get();

        // Hitung rata-rata hasil per alur
        $dataNilai = \App\Models\HasilPh::where('id_kelas_siswa', $id_kelas_siswa)
            ->whereIn('hasilph.id_ph', $ph)
            ->join('penilaian_harian', 'hasilph.id_ph', '=', 'penilaian_harian.id_ph')
            ->select('penilaian_harian.id_a', DB::raw('AVG(hasil) as rata'))
            ->groupBy('penilaian_harian.id_a')
            ->pluck('rata', 'penilaian_harian.id_a');

        $nilaiPerAlur = [];

        foreach ($daftarAlur as $alur) {
            $rata = isset($dataNilai[$alur->id_a]) ? round($dataNilai[$alur->id_a], 2) : 0;
            $rata = max(1, min($rata, 4)); // batasi antara 1-4

            if ($rata >= 4) {
                $keterangan = 'Berkembang Sangat Baik';
            } elseif ($rata >= 3) {
                $keterangan = 'Berkembang Sesuai Harapan';
            } elseif ($rata >= 2) {
                $keterangan = 'Mulai Berkembang';
            } else {
                $keterangan = 'Belum Berkembang';
            }

            $nilaiPerAlur[] = [
                'id_a' => $alur->id_a,
                'nomoralur' => $alur->nomor_alur ?? '-',
                'alur' => $alur->alurp,
                'rata' => $rata,
                'keterangan' => $keterangan,
            ];
        }

        return view('guru.hpminput', compact('kelasSiswa', 'minggu', 'nilaiPerAlur'));
    }




    // Simpan atau update nilai
    public function store(Request $request, $id_kelas_siswa, $minggu)
    {
        $request->validate([
            'id_a' => 'required|array',
            'rata' => 'required|array'
        ]);

        foreach ($request->id_a as $index => $id_a) {
            $rata = round($request->rata[$id_a]);
            $rata = max(1, min($rata, 4));

            HasilPm::updateOrCreate(
                [
                    'id_kelas_siswa' => $id_kelas_siswa,
                    'id_a' => $id_a,
                    'minggu' => $minggu,
                ],
                [
                    'hasil' => $rata
                ]
            );
        }

        return redirect()->route('hpm.index')->with('success', 'Nilai mingguan berhasil disimpan.');
    }
}