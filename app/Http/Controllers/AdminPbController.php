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
use App\Models\Alur;
use App\Models\DesLaporan;
use App\Models\Cp;
use App\Models\Hasilpb;

class AdminPbController extends Controller
{
    public function index()
    {
        $data = TahunAjaran::all();
        return view('admin.hpb.tahunajaran', compact('data'));
    }

    public function kelas($id_ta)
    {
        $kelas = Kelas::where('id_ta', $id_ta)->with('guru')->get();
        $tahunAjaran = TahunAjaran::find($id_ta);
        return view('admin.hpb.kelas', compact('kelas', 'id_ta', 'tahunAjaran'));
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
        return view('admin.hpb.siswa', compact('kelas', 'siswa', 'id_ta'));
    }

    public function bulan($id_kelas_siswa)
    {
        // Pastikan relasi alur.capaian ada di model HasilPm
        $hasilList = HasilPb::where('id_kelas_siswa', $id_kelas_siswa)
            ->with('alur.capaian')
            ->get()
            ->groupBy(function ($item) {
                return $item->bulan;
            });

        $kelasSiswa = KelasSiswa::with('siswa')->findOrFail($id_kelas_siswa);
        $siswa = $kelasSiswa->siswa;

        return view('admin.hpb.bulan', compact('hasilList', 'id_kelas_siswa', 'siswa'));
    }

   public function detail($id_kelas_siswa, $bulan) // Ubah parameter dari minggu ke bulan
    {
        $kelasSiswa = KelasSiswa::with('siswa')->findOrFail($id_kelas_siswa);

        $hasilPbs = HasilPb::where('id_kelas_siswa', $id_kelas_siswa) // Menggunakan HasilPb
            ->where('bulan', $bulan) // Filter berdasarkan bulan
            ->with('alur.capaian')
            ->get();

        if ($hasilPbs->isEmpty()) {
            Log::info("AdminPbController: No HasilPb found for id_kelas_siswa: $id_kelas_siswa and bulan: $bulan");
            $nilaiPerAlur = collect([]);
            return view('admin.hpb.detail', compact( // Ubah folder view ke hpb
                'bulan', // Ubah variabel minggu ke bulan
                'id_kelas_siswa',
                'kelasSiswa',
                'nilaiPerAlur'
            ));
        }

        $nilaiPerAlur = collect([]);

        foreach ($hasilPbs as $itemPb) { // Iterasi $hasilPbs, variabel $itemPb
            $alur = $itemPb->alur;
            
            if (!$alur) {
                Log::warning("AdminPbController: Alur not found for HasilPb ID {$itemPb->id_hpb}. Skipping."); // Log id_hpb
                continue;
            }

            $originalHasilPb = $itemPb->hasil; // Ambil hasil dari HasilPb
            
            // Log nilai asli
            Log::info('DEBUG PB: Original $itemPb->hasil: ' . var_export($originalHasilPb, true) . ' (Type: ' . gettype($originalHasilPb) . ')');

            // Konversi koma jadi titik, lalu pastikan jadi float
            $hasilNilaiFloat = (float)str_replace(',', '.', (string)$originalHasilPb);
            
            // Log nilai setelah konversi
            Log::info('DEBUG PB: $hasilNilaiFloat (after str_replace and float cast): ' . var_export($hasilNilaiFloat, true) . ' (Type: ' . gettype($hasilNilaiFloat) . ')');

            // Kunci perbaikan: Cast ke (int) setelah round untuk perbandingan ketat
            $roundedHasilNilai = (int)max(1, min(round($hasilNilaiFloat, 0, PHP_ROUND_HALF_UP), 4));

            // Log nilai setelah pembulatan dan batasan, dan setelah di-cast ke int
            Log::info('DEBUG PB: $roundedHasilNilai (after round and max/min and INT cast): ' . var_export($roundedHasilNilai, true) . ' (Type: ' . gettype($roundedHasilNilai) . ')');
            Log::info('-----------------------------------------');

            $keteranganFinal = '';

            // Logika keterangan berdasarkan nilai hasil (1, 2, 3, 4)
            if ($roundedHasilNilai === 1) {
                $keteranganFinal = 'Belum Berkembang';
            } elseif ($roundedHasilNilai === 2) {
                $keteranganFinal = 'Mulai Berkembang';
            } elseif ($roundedHasilNilai === 3) {
                $keteranganFinal = 'Berkembang Sesuai Harapan';
            } elseif ($roundedHasilNilai === 4) {
                $keteranganFinal = 'Berkembang Sangat Baik';
            } else {
                $keteranganFinal = '- (Logika Keterangan Gagal)';
            }

            $nilaiPerAlur->push((object)[
                'id_a' => $alur->id_a,
                'nomoralur' => $alur->nomor_alur ?? '-',
                'alurp' => $alur->alurp,
                'hasil' => $originalHasilPb, // Tampilkan nilai asli dari database
                'keterangan' => $keteranganFinal,
                'dokumentasi' => $itemPb->dokumentasi ?? null, // Tambahkan dokumentasi
            ]);
        }

        return view('admin.hpb.detail', compact( // Ubah folder view ke hpb
            'bulan', // Ubah variabel minggu ke bulan
            'id_kelas_siswa',
            'kelasSiswa',
            'nilaiPerAlur'
        ));
    }
    
}