<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hasilpb;
use App\Models\KelasSiswa;
use App\Models\TahunAjaran;
use App\Models\Semester;
use App\Models\HasilPm;
use App\Models\Alur;
use Illuminate\Support\Facades\Auth;

class HasilPbController extends Controller
{
    public function index()
    {
        // Ambil data guru yang login melalui relasi user
        $guru = Auth::user()->guru;

        $taAktif = TahunAjaran::where('is_active', true)->first();

        $data = \App\Models\Siswa::whereHas('kelas', function ($query) use ($guru, $taAktif) {
            $query->where('id_guru', $guru->id_guru)
                ->where('id_ta', $taAktif->id_ta);
        })->where('status', 'A')->get();
        return view('guru.hpb', compact('data'));
    }

    public function pilihBulan($noinduk)
    {
        $kelasSiswa = KelasSiswa::with('siswa')->where('noinduk', $noinduk)->firstOrFail();

        $bulan = [1, 2, 3, 4];

        return view('guru.hpbbulan', compact('kelasSiswa', 'bulan'));
    }

    public function inputNilai($id_kelas_siswa, $bulan)
    {
        $mingguAwal = ($bulan - 1) * 4 + 1;
        $mingguAkhir = $mingguAwal + 3;

        $semesterAktif = Semester::where('aktif', true)->first();
        $kelasSiswa = KelasSiswa::with('siswa')->findOrFail($id_kelas_siswa);

        // Ambil hanya id_a (alur) yang muncul di hasilpm minggu-minggu ini
        $alurIDs = HasilPm::where('id_kelas_siswa', $id_kelas_siswa)
            ->whereBetween('minggu', [$mingguAwal, $mingguAkhir])
            ->pluck('id_a')
            ->unique();

        // Ambil data alur yang relevan
        $daftarAlur = Alur::with('capaian')
            ->where('semester', $semesterAktif->semester ?? 1)
            ->whereIn('id_a', $alurIDs)
            ->get();

        $nilaiPerAlur = [];

        foreach ($daftarAlur as $alur) {
            $nilaiMingguan = HasilPm::where('id_kelas_siswa', $id_kelas_siswa)
                ->where('id_a', $alur->id_a)
                ->whereBetween('minggu', [$mingguAwal, $mingguAkhir])
                ->pluck('hasil');

            $rata = $nilaiMingguan->count() > 0 ? round($nilaiMingguan->avg()) : 0;
            $rata = max(1, min($rata, 4));

            $keterangan = match (true) {
                $rata >= 4 => 'Berkembang Sangat Baik',
                $rata >= 3 => 'Berkembang Sesuai Harapan',
                $rata >= 2 => 'Mulai Berkembang',
                default    => 'Belum Berkembang'
            };

            $nilaiPerAlur[] = [
                'id_a' => $alur->id_a,
                'alur' => $alur->alurp,
                'rata' => $rata,
                'keterangan' => $keterangan,
            ];
        }

        return view('guru.hpbinput', compact('kelasSiswa', 'bulan', 'nilaiPerAlur'));
    }

    public function store(Request $request, $id_kelas_siswa, $bulan)
    {
        $mingguAwal = ($bulan - 1) * 4 + 1;
        $mingguAkhir = $mingguAwal + 3;

        $semesterAktif = Semester::where('aktif', true)->first();
        $daftarAlur = Alur::where('semester', $semesterAktif->semester ?? 1)->get();

        foreach ($request->id_a as $index => $id_a) {
            $rata = round($request->rata[$index]);
            $rata = max(1, min($rata, 4));

            HasilPb::updateOrCreate(
                [
                    'id_kelas_siswa' => $id_kelas_siswa,
                    'bulan' => $bulan,
                    'id_a' => $id_a,
                ],
                [
                    'id_kelas_siswa' => $id_kelas_siswa,
                    'bulan' => $bulan,
                    'id_a' => $id_a,
                    'hasil' => $rata,
                ]
            );
        }


        return redirect()->route('hpb.index')->with('success', 'Nilai bulanan berhasil disimpan.');
    }
}