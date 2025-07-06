<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenilaianMingguan;
use App\Models\Alur;

class PenilaianMingguanController extends Controller
{
    public function index()
    {
        $data = PenilaianMingguan::with('alur')->get();
        return view('admin.pm', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alur = Alur::all();
        return view('admin.pmcreate', compact('alur'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         
        $request->validate([
            'id_a' => 'required|exists:alur,id_a',
            'minggu' => 'required|string|max:255',
        ]);

        PenilaianMingguan::create([
            'id_a' => $request->id_a,
            'minggu' => $request->minggu,
        ]);
        return redirect()->route('pm.index')->with('success', 'Data berhasil ditambahkan!');
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
    public function edit(string $id_pm)
    {
        $data = PenilaianMingguan::findOrFail($id_pm);
        $alur = Alur::all();
        return view('admin.pmedit', compact('data', 'alur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_pm)
    {
        $request->validate([
            'id_a' => 'required|exists:alur,id_a',
            'minggu' => 'required|string|max:255',
        ]);

        $data = PenilaianMingguan::findOrFail($id_pm);
        $data->update([
            'id_a' => $request->id_a,
            'minggu' => $request->minggu,
        ]);
        return redirect()->route('pm.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_pm)
    {
        PenilaianMingguan::destroy($id_pm);
        return redirect()->route('pm.index')->with('success', 'Data berhasil dihapus!');
    }
}