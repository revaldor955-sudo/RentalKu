<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemeriksaanKendaraanController extends Controller
{
    public function index()
    {
        return view('pemeriksaan_kendaraan.index');
    }
}