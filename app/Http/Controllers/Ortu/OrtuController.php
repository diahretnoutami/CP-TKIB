<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use App\Models\Orangtua;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class OrtuController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        $user = Auth::user();

        if ($user->role !== 'ortu') {
            return response()->json([
                'status' => false,
                'message' => 'Akses ditolak, bukan orang tua'
            ], 403);
        }

        $ortu = Orangtua::where('id_user', $user->id)->first();

        // Hapus token lama (biar 1 token per user, opsional)
        $user->tokens()->delete();

        // Buat token baru
        $token = $user->createToken('ortu_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => $user,
            'ortu' => $ortu
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}