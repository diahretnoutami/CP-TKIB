<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pertemuan;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class PertemuanController extends Controller
{
    public function index()
    {
        $ortu = Auth::user(); // pastikan auth:sanctum
        $pertemuan = Pertemuan::with(['siswa', 'guru'])
            ->where('id_ortu', $ortu->id_ortu)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['status' => true, 'data' => $pertemuan]);
    }

    // Tambah pertemuan baru
    public function store(Request $request)
    {
        $request->validate([
            'id_kelas_siswa' => 'required|exists:kelas_siswa,id_kelas_siswa',
            'id_guru' => 'required|exists:guru,id_guru',
            'noinduk' => 'required|exists:siswa,noinduk',
            'tglpengajuan' => 'required|date',
            'tglpertemuan' => 'required|date',
            'jampertemuan' => 'required',
            'deskripsi' => 'required|string',
        ]);

        $ortu = Auth::user();

        $pertemuan = Pertemuan::create([
            'id_kelas_siswa' => $request->id_kelas_siswa,
            'id_guru' => $request->id_guru,
            'id_ortu' => $ortu->id_ortu,
            'noinduk' => $request->noinduk,
            'tglpengajuan' => $request->tglpengajuan,
            'tglpertemuan' => $request->tglpertemuan,
            'jampertemuan' => $request->jampertemuan,
            'deskripsi' => $request->deskripsi,
            'status' => 'menunggu',
        ]);

        return response()->json(['status' => true, 'message' => 'Pertemuan berhasil diajukan', 'data' => $pertemuan]);
    }

    // Update pertemuan (hanya jika belum ditanggapi)
    public function update(Request $request, $id)
    {
        $pertemuan = Pertemuan::where('id_p', $id)->where('id_ortu', Auth::user()->id_ortu)->firstOrFail();

        if ($pertemuan->status !== 'menunggu') {
            return response()->json(['status' => false, 'message' => 'Pertemuan sudah ditanggapi, tidak bisa diubah'], 403);
        }

        $pertemuan->update($request->only(['tglpertemuan', 'jampertemuan', 'deskripsi']));

        return response()->json(['status' => true, 'message' => 'Pertemuan berhasil diperbarui', 'data' => $pertemuan]);
    }

    // Hapus pertemuan (jika belum ditanggapi)
    public function destroy($id)
    {
        $pertemuan = Pertemuan::where('id_p', $id)->where('id_ortu', Auth::user()->id_ortu)->firstOrFail();

        if ($pertemuan->status !== 'menunggu') {
            return response()->json(['status' => false, 'message' => 'Pertemuan sudah ditanggapi, tidak bisa dihapus'], 403);
        }

        $pertemuan->delete();

        return response()->json(['status' => true, 'message' => 'Pertemuan berhasil dihapus']);
    }
}