<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenilaianHarian;
use App\Models\Alur;
use App\Models\Tema;
use App\Models\cp;
use App\Models\TahunAjaran;

class PenilaianHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PenilaianHarian::with('alur', 'tema')->get();
        return view('admin.ph', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alur = Alur::all();
        $tema = Tema::all();
        $tahunajaran = TahunAjaran::all();
        return view('admin.phcreate', compact('alur', 'tema', 'tahunajaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         
        $request->validate([
            'id_a' => 'required|exists:alur,id_a',
            'id_t' => 'required|exists:tema,id_t',
            'id_ta' => 'required|exists:tahun_ajaran,id_ta',
            'tanggal' => 'required|date',
            'minggu' => 'required|string|max:255',
            'kegiatan' => 'required|string|max:255',
        ]);

        PenilaianHarian::create([
            'id_a' => $request->id_a,
            'id_t' => $request->id_t,
            'id_ta' => $request->id_ta,
            'tanggal' => $request->tanggal,
            'minggu' => $request->minggu,
            'kegiatan' => $request->kegiatan,
        ]);
        return redirect()->route('ph.index')->with('success', 'Data berhasil ditambahkan!');
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
    public function edit(string $id_ph)
    {
        $data = PenilaianHarian::findOrFail($id_ph);
        $alur = Alur::all();
        $tema = Tema::all();
        $tahunajaran = TahunAjaran::all();
        return view('admin.phedit', compact('data', 'alur', 'tema', 'tahunajaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_ph)
    {
        $request->validate([
            'id_a' => 'required|exists:alur,id_a',
            'id_t' => 'required|exists:tema,id_t',
            'id_ta' => 'required|exists:tahun_ajaran,id_ta',
            'tanggal' => 'required|date',
            'minggu' => 'required|string|max:255',
            'kegiatan' => 'required|string|max:255',
        ]);

        $data = PenilaianHarian::findOrFail($id_ph);
        $data->update([
            'id_a' => $request->id_a,
            'id_t' => $request->id_t,
            'id_ta' => $request->id_ta,
            'tanggal' => $request->tanggal,
            'minggu' => $request->minggu,
            'kegiatan' => $request->kegiatan,
        ]);
        return redirect()->route('ph.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_ph)
    {
        PenilaianHarian::destroy($id_ph);
        return redirect()->route('ph')->with('success', 'Data berhasil dihapus!');
    }
}