<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use App\Models\Kompensasi;
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

        $pendingRentals = Rental::with(['user', 'mobil'])
            ->where('status', 'Menunggu')
            ->latest()
            ->take(5)
            ->get();

        $pendingRentalsCount = Rental::where('status', 'Menunggu')->count();

        $pendingPayments = Pembayaran::with('rental.user', 'rental.mobil')
            ->where('status', 'Menunggu')
            ->latest()
            ->take(5)
            ->get();

        $pendingPaymentsCount = Pembayaran::where('status', 'Menunggu')->count();

        $returnDueRentals = Rental::with(['user', 'mobil'])
            ->where('status', 'Disetujui')
            ->whereDate('tanggal_selesai', '<=', today())
            ->latest('tanggal_selesai')
            ->get();

        $unpaidDendasCount = Denda::where('status', 'belum bayar')->count();

        $claimedKompensasisCount = Kompensasi::where('status', 'diajukan')->count();

        $latestRentals = Rental::with(['user', 'mobil'])
            ->latest()
            ->take(5)
            ->get();

        return view('staff.dashboard', compact(
            'totalMobils',
            'mobilTersedia',
            'mobilDisewa',
            'mobilMaintenance',
            'totalUsers',
            'totalRental',
            'totalPembayaran',
            'mobils',
            'pendingRentals',
            'pendingRentalsCount',
            'pendingPayments',
            'pendingPaymentsCount',
            'returnDueRentals',
            'unpaidDendasCount',
            'claimedKompensasisCount',
            'latestRentals'
        ))->with('pageTitle', 'Dashboard');
    }
}