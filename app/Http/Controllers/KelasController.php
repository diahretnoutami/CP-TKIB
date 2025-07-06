<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\TahunAjaran;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Kelas::with('guru', 'tahunajaran')->get();
        return view('admin.kelas', compact('data'));
    }

    public function create()
    {
        $guru = Guru::all();
        $tahunAjaran = TahunAjaran::all();
        return view('admin.kelascreate', compact('guru', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ta' => 'required|exists:tahun_ajaran,id_ta',
            'id_guru' => 'required|exists:guru,id_guru',
            'nama_kelas' => 'required|string|max:255',
        ]);

        Kelas::create([
            'id_ta' => $request->id_ta,
            'id_guru' => $request->id_guru,
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil disimpan!');
    }

    public function edit(string $id_k)
    {
        $data = Kelas::find($id_k);
        $tahunAjaran = TahunAjaran::all();
        $guru = Guru::all();

        return view('admin.kelasedit', compact('data', 'tahunAjaran', 'guru'));
    }


    public function update(Request $request, string $id)
    {
        // Validasi data
        $request->validate([
            'id_ta' => 'required|exists:tahun_ajaran,id_ta',
            'id_guru' => 'required|exists:guru,id_guru',
            'nama_kelas' => 'required',
        ]);

        $kelas = Kelas::findOrFail($id);

        $kelas->update([
            'id_ta' => $request->id_ta,
            'id_guru' => $request->id_guru,
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui!');
    }

    public function destroy(string $id_k)
    {
        Kelas::destroy($id_k);
        return redirect()->route('kelas.index')->with('success', 'Data berhasil dihapus!');
    }

    public function kelolaSiswa($id_k)
    {
        $kelas = Kelas::findOrFail($id_k);

        // Ambil noinduk siswa yang sudah tergabung di kelas ini
        $siswaTerpilih = DB::table('kelas_siswa')
            ->where('id_kelas', $id_k)
            ->pluck('noinduk')
            ->toArray();

        // Ambil semua siswa yang statusnya aktif
        $semuaSiswa = Siswa::where('status', 'A')
            ->whereNotIn('noinduk', function ($query) {
                $query->select('noinduk')->from('kelas_siswa');
            })->get();

        $data = Siswa::whereIn('noinduk', function ($query) use ($id_k) {
            $query->select('noinduk')
                ->from('kelas_siswa')
                ->where('id_kelas', $id_k);
        })->get();
        return view('admin.kelassiswa', compact('kelas', 'semuaSiswa', 'siswaTerpilih', 'data'));
    }

    public function updateSiswa(Request $request, $id_k)
    {
        $kelas = Kelas::findOrFail($id_k);

        // Validasi opsional: pastikan 'siswa' array atau kosong
        $request->validate([
            'siswa' => 'nullable|array',
        ]);

        // Sinkronisasi siswa yang dipilih dengan tabel pivot
        // Jika tidak ada siswa dipilih, akan kosongkan kelas_siswa untuk kelas ini
        if ($request->filled('siswa')) {
            $kelas->siswa()->attach($request->siswa); // hanya menambahkan, tidak menghapus yang lama
        }

        return redirect()->route('kelas.index')->with('success', 'Anggota kelas berhasil diperbarui.');
    }

    public function hapusSiswa($id_k, $noinduk)
    {
        DB::table('kelas_siswa')
            ->where('id_kelas', $id_k)
            ->where('noinduk', $noinduk)
            ->delete();

        return redirect()->back()->with('success', 'Siswa berhasil dihapus dari kelas.');
    }
}