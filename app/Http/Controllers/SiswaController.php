<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Orangtua;

class SiswaController extends Controller
{
    public function index()
    {
        $data = Siswa::with('orangtua')->get();
        return view('admin.siswa', compact('data'));
    }

    public function create()
    {
        $orangtua = Orangtua::all();
        return view('admin.siswacreate', compact('orangtua'));
    }

    public function store(Request $request)
    {
        // Cek apakah user input ortu baru
        if ($request->filled('is_new_ortu') == "1") {
            // Validasi data ortu
            $request->validate([
                'namaortu' => 'required|string',
                'pekerjaan' => 'required|string',
                'alamat' => 'required|string',
                'nohp' => 'required|string',
            ]);

            // Simpan data ortu ke tabel orangtua
            $ortu = new OrangTua();
            $ortu->namaortu = $request->namaortu;
            $ortu->pekerjaan = $request->pekerjaan;
            $ortu->alamat = $request->alamat;
            $ortu->nohp = $request->nohp;
            $ortu->save();

            // Simpan id ortu ke variabel
            $id_ortu = $ortu->id_ortu;
        } else {
            // Ambil dari dropdown
            $request->validate([
                'id_ortu' => 'required|exists:orangtua,id_ortu',
            ]);

            $id_ortu = $request->id_ortu;
        }

        // Validasi data siswa
        $request->validate([
            'noinduk' => 'required|unique:siswa,noinduk',
            'nama' => 'required',
            'tempatlahir' => 'required',
            'tgllahir' => 'required|date',
            'tinggibadan' => 'nullable|numeric',
            'beratbadan' => 'nullable|numeric',
            'lingkarkpl' => 'nullable|numeric',
            'jeniskelamin' => 'required|in:L,P',
        ]);

        // Simpan siswa
        Siswa::create([
            'noinduk' => $request->noinduk,
            'nama' => $request->nama,
            'tempatlahir' => $request->tempatlahir,
            'tgllahir' => $request->tgllahir,
            'tinggibadan' => $request->tinggibadan,
            'beratbadan' => $request->beratbadan,
            'lingkarkpl' => $request->lingkarkpl,
            'jeniskelamin' => $request->jeniskelamin,
            'id_ortu' => $id_ortu, // dari ortu baru atau dropdown
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil disimpan.');
    }

    public function edit($noinduk)
    {
        $siswa = Siswa::with('orangtua')->where('noinduk', $noinduk)->firstOrFail();
        $orangtua = Orangtua::all();
        return view('admin.siswaedit', compact('siswa', 'orangtua'));
    }

    public function update(Request $request, $noinduk)
    {
        $request->validate([
            'noinduk' => 'required',
            'nama' => 'required',
            'jeniskelamin' => 'required|in:L,P',
            'tempatlahir' => 'required',
            'tgllahir' => 'required|date',
            'tinggibadan' => 'nullable|numeric',
            'beratbadan' => 'nullable|numeric',
            'lingkarkpl' => 'nullable|numeric',
            'id_ortu' => 'nullable|exists:orangtua,id_ortu',
        ]);

        // Cek apakah tambah ortu baru
        if ($request->input('is_new_ortu') == "1") {
            $request->validate([
                'namaortu' => 'required',
            ]);

            $ortuBaru = OrangTua::create([
                'namaortu' => $request->namaortu,
                // Data lainnya bisa dikosongkan atau default
                'pekerjaan' => '-',
                'alamat' => '-',
                'nohp' => '-',
            ]);

            $id_ortu = $ortuBaru->id_ortu;
        } else {
            $id_ortu = $request->id_ortu;
        }

        // Update data siswa
        $siswa = Siswa::where('noinduk', $noinduk)->firstOrFail();
        $siswa->update([
            'noinduk' => $request->noinduk,
            'nama' => $request->nama,
            'jeniskelamin' => $request->jeniskelamin,
            'tempatlahir' => $request->tempatlahir,
            'tgllahir' => $request->tgllahir,
            'tinggibadan' => $request->tinggibadan,
            'beratbadan' => $request->beratbadan,
            'lingkarkpl' => $request->lingkarkpl,
            'id_ortu' => $id_ortu,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($noinduk)
    {
        // Cari siswa berdasarkan noinduk
        $siswa = Siswa::where('noinduk', $noinduk)->firstOrFail();

        // Hapus data siswa
        $siswa->delete();

        // Redirect kembali ke halaman index siswa dengan pesan sukses
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}