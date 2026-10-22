<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Models\Denda;
use App\Models\Kompensasi;
use App\Models\Mobil;
use App\Models\Rental;
use App\Models\Pembayaran;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        View::composer(['layouts.partials.admin-sidebar', 'layouts.partials.staff-sidebar'], function ($view) {
            $view->with([
                'totalMobils' => Mobil::count(),
                'pendingRentalsCount' => Rental::where('status', 'Menunggu')->count(),
                'pendingPaymentsCount' => Pembayaran::where('status', 'Menunggu')->count(),
                'pendingDendasCount' => Denda::where('status', 'belum bayar')->count(),
                'pendingKompensasisCount' => Kompensasi::where('status', 'diajukan')->count(),
            ]);
        });
    }
}
