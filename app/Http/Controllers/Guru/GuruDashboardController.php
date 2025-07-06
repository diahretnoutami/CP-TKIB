<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuruDashboardController extends Controller
{
    public function index()
    {
        return view('guru.dashboard'); // Pastikan view ini juga ada
    }
}