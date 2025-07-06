<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\HasilPh;

class AdminPhController extends Controller
{
    public function index()
    {
        $data = TahunAjaran::all();
        return view('admin.hph.tahunajaran', compact('data'));
    }

    public function kelas($id_ta)
    {
        $kelas = Kelas::where('id_ta', $id_ta)->with('guru')->get();
        $tahunAjaran = TahunAjaran::find($id_ta); // untuk ditampilkan di header
        return view('admin.hph.kelas', compact('kelas', 'id_ta', 'tahunAjaran'));
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
        return view('admin.hph.siswa', compact('kelas', 'siswa', 'id_ta'));
    }

    public function tanggal($id_kelas_siswa)
    {
        $hasilList = HasilPh::where('id_kelas_siswa', $id_kelas_siswa)
            ->with('penilaianHarian.alur') // untuk ambil semester
            ->get()
            ->groupBy(function ($item) {
                return $item->penilaianHarian->tanggal;
            });

        // Ambil data siswa berdasarkan kelas_siswa
        $kelasSiswa = \App\Models\KelasSiswa::with('siswa')->findOrFail($id_kelas_siswa);
        $siswa = $kelasSiswa->siswa;

        return view('admin.hph.tanggal', compact('hasilList', 'id_kelas_siswa', 'siswa'));
    }

    public function detail($id_kelas_siswa, $tanggal)
    {
        $hasil = HasilPh::with([
            'penilaianHarian.alur.capaian',
            'penilaianHarian.tema'
        ])
            ->where('id_kelas_siswa', $id_kelas_siswa)
            ->whereHas('penilaianHarian', function ($query) use ($tanggal) {
                $query->where('tanggal', $tanggal);
            })
            ->get();

        $kelasSiswa = \App\Models\KelasSiswa::with('siswa')->findOrFail($id_kelas_siswa);
        $siswa = $kelasSiswa->siswa;

        return view('admin.hph.detail', compact('hasil', 'tanggal', 'siswa', 'id_kelas_siswa', 'kelasSiswa'));
    }

    public function updateDetail(Request $request, $id_kelas_siswa, $tanggal)
    {
        $data = $request->input('hasil'); // hasil[id_hph] => nilai

        foreach ($data as $id_hph => $nilai) {
            HasilPh::where('id_hph', $id_hph)->update(['hasil' => $nilai]);
        }

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }
}