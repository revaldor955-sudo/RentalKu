<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Models\Cabang;
use App\Models\Brand;
use App\Models\TipeMobil;
use App\Models\Fasilitas;
use App\Models\Kupon;
use App\Models\Banner;
use App\Models\Pembayaran;
use App\Models\Rental;
use App\Models\User;
use App\Support\LaporanData;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalMobils = Mobil::count();
        $mobilTersedia = Mobil::where('status', 'Tersedia')->count();
        $mobilDisewa = Mobil::where('status', 'Disewa')->count();
        $mobilMaintenance = Mobil::where('status', 'Maintenance')->count();
        $totalCabang = Cabang::count();
        $totalBrands = Brand::count();
        $totalTipeMobils = TipeMobil::count();
        $totalFasilitas = Fasilitas::count();
        $totalKupons = Kupon::count();
        $totalBanners = Banner::count();

        $pendingRentalsCount = Rental::where('status', 'Menunggu')->count();
        $pendingPaymentsCount = Pembayaran::where('status', 'Menunggu')->count();

        $dari   = now()->subDays(29)->toDateString();
        $sampai = now()->toDateString();

        $laporan = LaporanData::laporan($dari, $sampai);

        $mobils = Mobil::with([
            'brand',
            'tipeMobil',
            'cabang'
        ])
        ->latest()
        ->take(8)
        ->get();

        $users = User::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalMobils',
            'mobilTersedia',
            'mobilDisewa',
            'mobilMaintenance',
            'totalCabang',
            'totalBrands',
            'totalTipeMobils',
            'totalFasilitas',
            'totalKupons',
            'totalBanners',
            'pendingRentalsCount',
            'pendingPaymentsCount',
            'mobils',
            'users',
            'laporan',
            'dari',
            'sampai'
        ))->with('pageTitle', 'Dashboard');
    }
}
