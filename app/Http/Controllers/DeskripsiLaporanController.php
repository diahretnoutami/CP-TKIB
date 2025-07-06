<?php

namespace App\Http\Controllers;

use App\Models\DesLaporan;
use App\Models\Cp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeskripsiLaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DesLaporan::with('cp')->get();
        return view('admin.deslaporan.deslap', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $materis = Cp::select('id_c', 'materi')->groupBy('materi', 'id_c')->get();
        return view('admin.deslaporan.deslapcreate', compact('materis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_c' => 'required|exists:cps,id_c',
            'nilaiakhir' => 'required',
            'keterangan' => 'required',
        ]);

        DesLaporan::create([
            'id_c' => $request->id_c,
            'nilaiakhir' => $request->nilaiakhir,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('deslap.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id_dl)
    {
        $data = DesLaporan::findOrFail($id_dl);
        $materis = Cp::all(); //
        return view('admin.deslaporan.deslapedit', compact('data', 'materis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_dl)
    {
        $request->validate([
            'id_c' => 'required|exists:cps,id_c',
            'nilaiakhir' => 'required',
            'keterangan' => 'required',
        ]);

        $data = DesLaporan::findOrFail($id_dl);
        $data->update([
            'id_c' => $request->id_c,
            'nilaiakhir' => $request->nilaiakhir,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('deslap.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_dl)
    {
        DesLaporan::destroy($id_dl);
        return redirect()->route('deslap.index')->with('success', 'Data berhasil dihapus!');
    }
}