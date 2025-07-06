<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\HasilPh;
use App\Models\PenilaianHarian;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class HasilPhController extends Controller
{
    public function index()
    {
        // Ambil data guru yang login melalui relasi user
        $guru = Auth::user()->guru;

        $taAktif = \App\Models\TahunAjaran::where('is_active', true)->first();

        $data = \App\Models\Siswa::whereHas('kelas', function ($query) use ($guru, $taAktif) {
            $query->where('id_guru', $guru->id_guru)
                ->where('id_ta', $taAktif->id_ta);
        })->where('status', 'A')->get();
        return view('guru.hph', compact('data'));
    }

    public function pilihTgl($noinduk)
    {
        $kelasSiswa = KelasSiswa::where('noinduk', $noinduk)->first();
        $taAktif = \App\Models\TahunAjaran::where('is_active', true)->first();

        if (!$kelasSiswa) {
            return redirect()->route('hph.index')->with('error', 'Data kelas siswa tidak ditemukan.');
        }

        $data = PenilaianHarian::selectRaw('MIN(id_ph) as id_ph, tanggal')
            ->where('id_ta', $taAktif->id_ta) // ← tambahkan ini
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('guru.hphinputtgl', [
            'id_kelas_siswa' => $kelasSiswa->id_kelas_siswa,
            'noinduk' => $noinduk,
            'data' => $data,
            'kelasSiswa' => $kelasSiswa
        ]);
    }

    public function inputHarian($tanggal, $id_kelas_siswa)
    {
        $penilaianPoin = PenilaianHarian::with(['alur', 'tema'])
            ->where('tanggal', $tanggal)
            ->get();

        $kelasSiswa = KelasSiswa::with('siswa')->findOrFail($id_kelas_siswa);

        $existingNilai = HasilPh::where('id_kelas_siswa', $id_kelas_siswa)
            ->whereIn('id_ph', $penilaianPoin->pluck('id_ph'))
            ->pluck('hasil', 'id_ph'); // hasilnya: [id_ph => hasil]

        return view('guru.hphinput', compact('penilaianPoin', 'kelasSiswa', 'tanggal', 'existingNilai'));
    }

    public function storeHarian(Request $request)
    {
        $request->validate([
            'hasil' => 'required|array',
            'id_kelas_siswa' => 'required|integer|exists:kelas_siswa,id_kelas_siswa',
            'noinduk' => 'required|string|exists:siswa,noinduk',
            'dokumentasi.*' => 'nullable|image|max:2048'
        ]);

        foreach ($request->hasil as $id_ph => $nilai) {
            $path = null;

            if ($request->hasFile("dokumentasi.$id_ph")) {
                $file = $request->file("dokumentasi.$id_ph");
                $path = $file->store("dokumentasi_hph", 'public');
            }

            $data = ['hasil' => $nilai];
            if ($path) {
                $data['dokumentasi'] = $path;
            }

            $existing = HasilPh::where('id_kelas_siswa', $request->id_kelas_siswa)
                ->where('id_ph', $id_ph)
                ->first();

            if ($existing) {
                $existing->hasil = $nilai;

                if ($path) {
                    if ($existing->dokumentasi) {
                        Storage::disk('public')->delete($existing->dokumentasi);
                    }
                    $existing->dokumentasi = $path;
                }

                $existing->save();
            } else {
                HasilPh::create(array_merge([
                    'id_ph' => $id_ph,
                    'id_kelas_siswa' => $request->id_kelas_siswa
                ], $data));
            }
        }

        return redirect()->route('guru.hphinputtgl', $request->noinduk)->with('success', 'Nilai berhasil disimpan.');
    }
}