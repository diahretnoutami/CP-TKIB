<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $data = TahunAjaran::all();
        return view('admin.tahunajaran', compact('data'));
    }

    public function create()
    {
        return view('admin.tahunajarancreate');
    }

    public function store(Request $request)
    {
        TahunAjaran::create($request->all());
        return redirect()->route('tahunajaran.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function destroy($id_ta)
    {
        TahunAjaran::destroy($id_ta);
        return redirect()->route('tahunajaran.index')->with('success', 'Data berhasil dihapus!');
    }

    public function edit($id_ta)
    {
        $data = TahunAjaran::findOrFail($id_ta);
        return view('admin.tahunajaranedit', compact('data'));
    }

    public function update(Request $request, $id_ta)
    {
        $data = TahunAjaran::findOrFail($id_ta);
        $data->update($request->only(['tahunajaran']));

        return redirect()->route('tahunajaran.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function setAktif($id_ta)
    {
        TahunAjaran::query()->update(['is_active' => false]);
        TahunAjaran::where('id_ta', $id_ta)->update(['is_active' => true]);

        return redirect()->back()->with('success', 'Tahun ajaran aktif telah diperbarui.');
    }
}