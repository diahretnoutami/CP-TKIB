<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tema;

class TemaController extends Controller
{
    public function index() {
        $data = tema::all();
        return view('admin.tema', compact('data'));
    }

    public function create() {
        return view('admin.temacreate');
    }

    public function store(Request $request) {
        Tema::create($request->all());
        return redirect()->route('tema.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function destroy($id_t) {
        tema::destroy($id_t);
        return redirect()->route('tema.index')->with('success', 'Data berhasil dihapus!');
    }

    public function edit($id_t){
    $data = tema::findOrFail($id_t);
    return view('admin.temaedit', compact('data'));
}

public function update(Request $request, $id_t){
    $data = tema::findOrFail($id_t);
    $data->update($request->only(['tema']));

    return redirect()->route('tema.index')->with('success', 'Data berhasil diperbarui.');
}
}