<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orangtua;

class OrtuSiswaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil user yang sedang login
        $user = $request->user();

        // Cari ortu berdasarkan user_id
        $ortu = Orangtua::with('siswa')->where('id_user', $user->id)->first();

        if (!$ortu) {
            return response()->json([
                'status' => false,
                'message' => 'Data orang tua tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Daftar siswa berhasil diambil',
            'siswa' => $ortu->siswa
        ]);
    }
}