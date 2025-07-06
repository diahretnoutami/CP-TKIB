<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Siswa;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function previewLaporan($noinduk)
    {
        $tahunAjaran = TahunAjaran::where('is_active', 1)->first();
        $semester = Semester::where('aktif', 1)->first();
        $siswa = Siswa::with('kelasSiswaAktif')->where('noinduk', $noinduk)->first();

        if (!$siswa || !$siswa->kelasSiswaAktif || !$tahunAjaran || !$semester) {
            return response()->json(['message' => 'Data tidak lengkap'], 404);
        }

        $id_kelas_siswa = $siswa->kelasSiswaAktif->id_kelas_siswa;
        $id_ta = $tahunAjaran->id_ta;
        $semesterAktif = $semester->semester;

        $laporan = \App\Models\Laporan::with([
            'deskripsi',
            'hasilph.penilaianHarian.alur',
            'hasilph.penilaianHarian.tema',
        ])
            ->where('id_kelas_siswa', $id_kelas_siswa)
            ->whereHas('hasilph.penilaianHarian.alur', function ($q) use ($semesterAktif) {
                $q->where('semester', $semesterAktif);
            })
            ->whereHas('hasilph.penilaianHarian', function ($q) use ($id_ta) {
                $q->where('id_ta', $id_ta);
            })
            ->get();

        return response()->json([
            'status' => true,
            'laporan' => $laporan
        ]);
    }

    public function downloadLaporan($noinduk)
    {
        $tahunAjaran = TahunAjaran::where('is_active', 1)->first();
        $semester = Semester::where('aktif', 1)->first();
        $siswa = Siswa::with('kelasSiswaAktif')->where('noinduk', $noinduk)->first();

        if (!$siswa || !$siswa->kelasSiswaAktif || !$tahunAjaran || !$semester) {
            return response()->json(['message' => 'Data tidak lengkap'], 404);
        }

        $id_kelas_siswa = $siswa->kelasSiswaAktif->id_kelas_siswa;

        $laporan = Laporan::with(['deskripsi', 'alur.cps'])
            ->where('id_kelas_siswa', $id_kelas_siswa)
            ->whereHas('alur', function ($q) use ($semester) {
                $q->where('semester', $semester->semester);
            })
            ->whereHas('penilaianHarian', function ($q) use ($tahunAjaran) {
                $q->where('id_ta', $tahunAjaran->id_ta);
            })
            ->get();

        if ($laporan->isEmpty()) {
            return response()->json(['message' => 'Tidak ada laporan'], 404);
        }

        // Generate PDF
        $pdf = Pdf::loadView('laporan.pdf', [
            'siswa' => $siswa,
            'laporan' => $laporan,
            'semester' => $semester->semester,
            'tahunajaran' => $tahunAjaran->tahunajaran
        ]);

        return $pdf->download("laporan-{$siswa->nama}.pdf");
    }
}