<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::all();
        return view('admin.semester', compact('semesters'));
    }

    // Form tambah semester
    public function create()
    {
        return view('admin.semestercreate');
    }

    // Simpan semester baru
    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required|integer|min:1|max:2', // 1 atau 2
        ]);

        Semester::create([
            'semester' => $request->semester,
            'aktif' => false, // default nonaktif
        ]);

        return redirect()->route('semester.index')->with('success', 'Semester berhasil ditambahkan.');
    }

    public function setAktif($id)
    {
        Semester::query()->update(['aktif' => false]); // set semua jadi nonaktif
        Semester::where('id', $id)->update(['aktif' => true]);

        return redirect()->back()->with('success', 'Semester aktif telah diperbarui.');
    }

    public function edit($id)
    {
        $semester = Semester::findOrFail($id);
        return view('admin.semesteredit', compact('semester'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'semester' => 'required|integer|min:1|max:2',
        ]);

        Semester::where('id', $id)->update([
            'semester' => $request->semester,
        ]);

        return redirect()->route('semester')->with('success', 'Semester berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Semester::destroy($id);
        return redirect()->route('semester.index')->with('success', 'Semester berhasil dihapus.');
    }
}