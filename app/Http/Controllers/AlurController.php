<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alur;
use App\Models\Cp;
class AlurController extends Controller
{
    public function index() {
        $data = alur::with('capaian')->get();
        return view('admin.alur', compact('data'));
    }

    public function create() {
        $tujuans = Cp::all();
        return view('admin.alurcreate', compact('tujuans'));
    }

    public function store(Request $request) {

        $request->validate([
            'id_c' => 'required|exists:cps,id_c',
            'alurp' => 'required',
            'nomor_alur' => 'required',
            'semester' => 'required',
        ]);
    
        Alur::create([
            'id_c' => $request->id_c,
            'alurp' => $request->alurp,
            'nomor_alur' => $request->nomor_alur,
            'semester' => $request->semester,
        ]);
    
        return redirect()->route('alur.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function destroy($id_c) {
        alur::destroy($id_c);
        return redirect()->route('alur.index')->with('success', 'Data berhasil dihapus!');
    }

    public function edit($id_c){
    $data = alur::findOrFail($id_c);
    $tujuans = Cp::all(); //
    return view('admin.aluredit', compact('data', 'tujuans'));
}

public function update(Request $request, $id_a)
{
    $request->validate([
        'id_c' => 'required|exists:cps,id_c',
        'alur' => 'required',
        'nomor_alur' => 'required',
        'semester' => 'required',
    ]);

    $data = Alur::findOrFail($id_a);
    $data->update([
        'id_c' => $request->id_c,
        'alur' => $request->alur,
        'nomor_alur' => $request->nomor_alur,
        'semester' => $request->semester,
    ]);

    return redirect()->route('alur.index')->with('success', 'Data berhasil diperbarui.');
}




}