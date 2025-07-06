<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $data = Guru::with('user')->get();
        return view('admin.guru', compact('data'));
    }

    public function create()
    {
        $usedUserIds = Guru::pluck('id_user')->map(fn($id) => (int) $id)->toArray();


        $users = User::where('role', 'guru') // tambahkan filter ini
            ->whereNotIn('id', $usedUserIds)
            ->get();
        return view('admin.gurucreate', compact('users'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id',
            'namaguru' => 'required',
            'tempatlahir' => 'required',
            'tanggallahir' => 'required|date',
            'jeniskelamin' => 'required|in:L,P',
            'tanggal_masuk' => 'required|date',
            'alamat' => 'required',
            'nohp' => 'required',
        ]);

        Guru::create($validated);

        return redirect()->route('guru.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function show($id_guru)
    {
        $guru = Guru::findOrFail($id_guru);
        return view('admin.gurudetail', compact('guru'));
    }

    public function destroy($id_guru)
    {
        Guru::destroy($id_guru);
        return redirect()->route('guru.index')->with('success', 'Data berhasil dihapus!');
    }

    public function edit($id_guru)
    {
        $data = Guru::findOrFail($id_guru);

        // Ambil semua user yang belum dipakai guru lain, tambahkan user yang sedang digunakan guru ini
        $usedUserIds = Guru::where('id_guru', '!=', $id_guru)->pluck('id_user')->toArray();
        $users = User::whereNotIn('id', $usedUserIds)->get();

        return view('admin.guruedit', compact('data', 'users'));
    }

    public function update(Request $request, $id_c)
    {
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id',
            'namaguru' => 'required',
            'tempatlahir' => 'required',
            'tanggallahir' => 'required|date',
            'jeniskelamin' => 'required|in:L,P',
            'tanggal_masuk' => 'required|date',
            'alamat' => 'required',
            'nohp' => 'required',
        ]);

        $data = Guru::findOrFail($id_c);
        $data->update($validated);

        return redirect()->route('guru.index')->with('success', 'Data berhasil diperbarui.');
    }
}