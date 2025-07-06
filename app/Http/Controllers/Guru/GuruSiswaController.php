<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruSiswaController extends Controller
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

        return view('guru.siswa', compact('data'));
    }

    public function edit($noinduk)
    {
       $data = Siswa::where('noinduk', $noinduk)->firstOrFail();

        // Pastikan guru yang login berhak mengedit siswa ini
        $guru = Auth::user()->guru;
        $taAktif = \App\Models\TahunAjaran::where('is_active', true)->first();

        if (!$taAktif) {
            return redirect()->route('guru.siswa')->with('error', 'Tahun Ajaran aktif belum ditentukan.');
        }

        $isAuthorized = $data->kelas->where('id_guru', $guru->id_guru)->where('id_ta', $taAktif->id_ta)->isNotEmpty();

        if (!$isAuthorized) {
            return redirect()->route('guru.siswa')->with('error', 'Anda tidak memiliki akses untuk mengedit siswa ini.');
        }

        return view('guru.siswaedit', compact('data'));
    }

    public function update(Request $request, $noinduk)
    {
        // Validasi input
        $request->validate([
            // noinduk, nama, jeniskelamin, tempatlahir, tgllahir tidak boleh diedit oleh guru,
            // jadi tidak perlu divalidasi di sini jika inputnya readonly/disabled.
            // Kita hanya validasi field yang bisa diedit.
            'tinggibadan' => 'nullable|numeric|min:1',
            'beratbadan' => 'nullable|numeric|min:1',
            'lingkarkpl' => 'nullable|numeric|min:1',
        ]);

        // Cari siswa yang akan diupdate
        $siswa = Siswa::where('noinduk', $noinduk)->firstOrFail();

        // Pastikan guru yang login berhak mengedit siswa ini (cek lagi untuk keamanan)
        $guru = Auth::user()->guru;
        $taAktif = \App\Models\TahunAjaran::where('is_active', true)->first();

        if (!$taAktif) {
            return redirect()->route('guru.siswa')->with('error', 'Tahun Ajaran aktif belum ditentukan.');
        }

        $isAuthorized = $siswa->kelas->where('id_guru', $guru->id_guru)->where('id_ta', $taAktif->id_ta)->isNotEmpty();

        if (!$isAuthorized) {
            return redirect()->route('guru.siswa')->with('error', 'Anda tidak memiliki akses untuk mengupdate siswa ini.');
        }

        // Update hanya kolom yang diizinkan untuk guru
        $siswa->tinggibadan = $request->input('tinggibadan');
        $siswa->beratbadan = $request->input('beratbadan');
        $siswa->lingkarkpl = $request->input('lingkarkpl');
        $siswa->save();

        return redirect()->route('guru.siswa')->with('success', 'Data siswa berhasil diperbarui!');
    }
}