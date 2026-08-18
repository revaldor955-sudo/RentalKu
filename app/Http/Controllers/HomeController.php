<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $banners = DB::table('banners')
            ->where('status', 'aktif')
            ->orderBy('urutan')
            ->get();

   $mobils = DB::table('mobils')
    ->join('brands', 'mobils.brand_id', '=', 'brands.id')
    ->join('tipe_mobils', 'mobils.tipe_mobil_id', '=', 'tipe_mobils.id')
    ->join('cabangs', 'mobils.cabang_id', '=', 'cabangs.id')
    ->where('mobils.status', 'tersedia')
    ->select(
        'mobils.*',
        'brands.name as nama_brand',
        'tipe_mobils.name as nama_tipe',
        'cabangs.name as nama_cabang'
    )
    ->latest('mobils.id')
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