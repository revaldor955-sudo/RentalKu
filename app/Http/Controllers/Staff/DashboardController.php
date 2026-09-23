<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Models\User;
use App\Models\Rental;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMobils = Mobil::count();

        $mobilTersedia = Mobil::where('status', 'Tersedia')->count();

        $mobilDisewa = Mobil::where('status', 'Disewa')->count();

        $mobilMaintenance = Mobil::where('status', 'Maintenance')->count();

        $totalUsers = User::count();

        $totalRental = Rental::count();

        $totalPembayaran = Pembayaran::count();

        $mobils = Mobil::latest()->take(5)->get();

        return view('staff.dashboard', compact('totalMobils', 'mobilTersedia', 'mobilDisewa', 'mobilMaintenance', 'totalUsers', 'totalRental', 'totalPembayaran', 'mobils'));
    }
}