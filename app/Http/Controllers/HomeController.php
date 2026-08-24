<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $banners = DB::table('banners')
            ->where('status', 'aktif')
            ->orderBy('urutan')
            ->get();

        $mobils = Mobil::with(['brand', 'cabang', 'fotoMobils'])
            ->where('status', 'Tersedia')
            ->latest('id')
            ->limit(6)
            ->get();

        $brands = DB::table('brands')
            ->orderBy('name')
            ->get();

        $ratings = DB::table('ratings')
            ->join('users', 'ratings.customer_id', '=', 'users.id')
            ->select(
                'ratings.*',
                'users.name',
                'users.photo as foto_user'
            )
            ->latest('ratings.id')
            ->limit(6)
            ->get();

        $faqs = DB::table('faqs')
            ->orderBy('urutan')
            ->get();

        return view('home', compact(
            'banners',
            'mobils',
            'brands',
            'ratings',
            'faqs'
        ));
    }
}
