<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\HasilPm;
use App\Models\PenilaianHarian;
use App\Models\HasilPh;
use App\Models\Alur;
use App\Models\DesLaporan;
use App\Models\Cp;

class AdminPmController extends Controller
{
    public function index()
    {
        $data = TahunAjaran::all();
        return view('admin.hpm.tahunajaran', compact('data'));
    }

    public function kelas($id_ta)
    {
        $kelas = Kelas::where('id_ta', $id_ta)->with('guru')->get();
        $tahunAjaran = TahunAjaran::find($id_ta);
        return view('admin.hpm.kelas', compact('kelas', 'id_ta', 'tahunAjaran'));
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
        return view('admin.hpm.siswa', compact('kelas', 'siswa', 'id_ta'));
    }

    public function minggu($id_kelas_siswa)
    {
        // Pastikan relasi alur.capaian ada di model HasilPm
        $hasilList = HasilPm::where('id_kelas_siswa', $id_kelas_siswa)
            ->with('alur.capaian')
            ->get()
            ->groupBy(function ($item) {
                return $item->minggu;
            });

        $kelasSiswa = KelasSiswa::with('siswa')->findOrFail($id_kelas_siswa);
        $siswa = $kelasSiswa->siswa;

        return view('admin.hpm.minggu', compact('hasilList', 'id_kelas_siswa', 'siswa'));
    }

    public function detail($id_kelas_siswa, $minggu)
    {
        $kelasSiswa = KelasSiswa::with('siswa')->findOrFail($id_kelas_siswa);

        $hasilPms = HasilPm::where('id_kelas_siswa', $id_kelas_siswa)
            ->where('minggu', $minggu)
            ->with('alur.capaian')
            ->get();

        if ($hasilPms->isEmpty()) {
            Log::info("AdminPmController: No HasilPm found for id_kelas_siswa: $id_kelas_siswa and minggu: $minggu");
            $nilaiPerAlur = collect([]);
            return view('admin.hpm.detail', compact(
                'minggu',
                'id_kelas_siswa',
                'kelasSiswa',
                'nilaiPerAlur'
            ));
        }

        $nilaiPerAlur = collect([]);

        foreach ($hasilPms as $itemPm) {
            $alur = $itemPm->alur;
            
            if (!$alur) {
                Log::warning("AdminPmController: Alur not found for HasilPm ID {$itemPm->id_hpm}. Skipping.");
                continue;
            }

            $originalHasilPm = $itemPm->hasil;
            
            // Log nilai asli
            Log::info('DEBUG: Original $itemPm->hasil: ' . var_export($originalHasilPm, true) . ' (Type: ' . gettype($originalHasilPm) . ')');

            // Konversi koma jadi titik, lalu pastikan jadi float
            $hasilNilaiFloat = (float)str_replace(',', '.', (string)$originalHasilPm);
            
            // Log nilai setelah konversi
            Log::info('DEBUG: $hasilNilaiFloat (after str_replace and float cast): ' . var_export($hasilNilaiFloat, true) . ' (Type: ' . gettype($hasilNilaiFloat) . ')');

            // --- KUNCI PERBAIKAN DI SINI: CAST KE (INT) SETELAH ROUND ---
            $roundedHasilNilai = (int)max(1, min(round($hasilNilaiFloat, 0, PHP_ROUND_HALF_UP), 4));

            // Log nilai setelah pembulatan dan batasan, dan setelah di-cast ke int
            Log::info('DEBUG: $roundedHasilNilai (after round and max/min and INT cast): ' . var_export($roundedHasilNilai, true) . ' (Type: ' . gettype($roundedHasilNilai) . ')');
            Log::info('-----------------------------------------');

            $keteranganFinal = '';

            // Sekarang perbandingan ini akan menggunakan integer, sehingga seharusnya bekerja
            if ($roundedHasilNilai === 1) {
                $keteranganFinal = 'Belum Berkembang';
            } elseif ($roundedHasilNilai === 2) {
                $keteranganFinal = 'Mulai Berkembang';
            } elseif ($roundedHasilNilai === 3) {
                $keteranganFinal = 'Berkembang Sesuai Harapan';
            } elseif ($roundedHasilNilai === 4) {
                $keteranganFinal = 'Berkembang Sangat Baik';
            } else {
                // Ini seharusnya tidak akan pernah tercapai jika logika max/min bekerja
                $keteranganFinal = '- (Logika Keterangan Gagal)';
            }

            $nilaiPerAlur->push((object)[
                'id_a' => $alur->id_a,
                'nomoralur' => $alur->nomor_alur ?? '-',
                'alurp' => $alur->alurp,
                'hasil' => $originalHasilPm,
                'keterangan' => $keteranganFinal,
            ]);
        }

        return view('admin.hpm.detail', compact(
            'minggu',
            'id_kelas_siswa',
            'kelasSiswa',
            'nilaiPerAlur'
        ));
    }
}