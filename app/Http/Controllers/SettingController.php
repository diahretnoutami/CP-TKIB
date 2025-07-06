<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function aktifkanPeriode(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_semester' => 'required|exists:semester,id',
            'id_tahunajaran' => 'required|exists:tahun_ajaran,id_ta',
        ]);

        // Nonaktifkan semua semester & tahun ajaran
        DB::table('semester')->update(['aktif' => 0]);
        DB::table('tahun_ajaran')->update(['is_active' => 0]);

        // Aktifkan yang dipilih
        DB::table('semester')->where('id', $request->id_semester)->update(['aktif' => 1]);
        DB::table('tahun_ajaran')->where('id_ta', $request->id_tahunajaran)->update(['is_active' => 1]);

        return back()->with('success', 'Semester dan Tahun Ajaran berhasil diaktifkan!');
    }
}