<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cp;

class CpController extends Controller
{
    public function index()
    {
        $data = cp::all();
        return view('admin.cp', compact('data'));
    }

    public function create()
    {
        $materis = Cp::select('materi')->distinct()->pluck('materi');
        $capaians = Cp::select('capaian')->distinct()->pluck('capaian');
        return view('admin.cpcreate', compact('materis', 'capaians'));
    }


    public function store(Request $request)
    {
        // Ambil nilai yang dipakai
        $materi = $request->is_new_materi ? $request->materi_baru : $request->materi_dropdown;
        $capaian = $request->is_new_capaian ? $request->capaian_baru : $request->capaian_dropdown;

        // Validasi sesuai hasil akhir
        $request->validate([
            'tujuan' => 'required|string',
            // Validasi dinamis:
            $request->is_new_materi ? 'materi_baru' : 'materi_dropdown' => 'required|string',
            $request->is_new_capaian ? 'capaian_baru' : 'capaian_dropdown' => 'required|string',
        ]);

        Cp::create([
            'materi' => $materi,
            'capaian' => $capaian,
            'tujuan' => $request->tujuan,
        ]);

        return redirect()->route('cp.index')->with('success', 'Data berhasil disimpan.');
    }




    public function destroy($id_c)
    {
        cp::destroy($id_c);
        return redirect()->route('cp.index')->with('success', 'Data berhasil dihapus!');
    }

    public function edit($id_c)
    {
        $data = cp::findOrFail($id_c);
        return view('admin.cpedit', compact('data'));
    }

    public function update(Request $request, $id_c)
    {
        $data = cp::findOrFail($id_c);
        $data->update($request->only(['materi', 'capaian', 'tujuan']));

        return redirect()->route('cp.index')->with('success', 'Data berhasil diperbarui.');
    }
}