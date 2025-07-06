<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alur; 

class AlurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:guru'); // kalau kamu pakai middleware role
    }

    public function index()
    {
        // Ambil data capaian belajar sesuai kebutuhan guru
        $data = Alur::all();

        // Tampilkan view khusus guru
        return view('guru.alur', compact('data'));
    }
}