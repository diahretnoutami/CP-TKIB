<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orangtua;

class OrangTuaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Orangtua::all();
        return view('admin.ortu', compact('data'));
    }

    public function create()
    {
        return view('admin.ortucreate');
    }

    public function store(Request $request)
    {
        Orangtua::create($request->all());
        return redirect()->route('ortu.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id_ortu)
    {
        $data = Orangtua::findOrFail($id_ortu);
        return view('admin.ortuedit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_ortu)
    {
        $data = Orangtua::findOrFail($id_ortu);
        $data->update($request->only(['namaortu', 'pekerjaan', 'nohp', 'alamat']));

        return redirect()->route('ortu.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_ortu)
    {
        Orangtua::destroy($id_ortu);
        return redirect()->route('ortu.index')->with('success', 'Data berhasil dihapus!');
    }
}