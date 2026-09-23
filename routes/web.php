<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\DokumenMobilController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\FotoMobilController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KerusakanMobilController;
use App\Http\Controllers\KompensasiController;
use App\Http\Controllers\KuponController;
use App\Http\Controllers\ServisMobilController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MetodePembayaranController;
use App\Http\Controllers\Admin\LandingSettingController;
use App\Http\Controllers\CustomerRatingController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PemeriksaanKendaraanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\SupirController;
use App\Http\Controllers\TipeMobilController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Master data: khusus admin.
Route::middleware('admin')->group(function () {
Route::get('roles/data', [RoleController::class, 'data'])->name('roles.data');

Route::resource('roles', RoleController::class)
    ->except(['create', 'edit', 'show']);

Route::get('brands/data', [BrandController::class, 'data'])->name('brands.data');

Route::resource('brands', BrandController::class)
    ->except(['create', 'edit']);

Route::get('tipe_mobils/data', [TipeMobilController::class, 'data'])->name('tipe_mobils.data');

Route::resource('tipe_mobils', TipeMobilController::class)
    ->except(['create', 'edit', 'show']);

Route::get('cabangs/data', [CabangController::class, 'data'])->name('cabangs.data');

Route::resource('cabangs', CabangController::class)
    ->except(['create', 'edit', 'show']);

Route::get('/fasilitas/data', [FasilitasController::class, 'data'])
    ->name('fasilitas.data');

Route::resource('fasilitas', FasilitasController::class)
    ->except(['create', 'edit', 'show']);

Route::get('metode_pembayarans/data', [MetodePembayaranController::class, 'data'])->name('metode_pembayarans.data');

Route::resource('metode_pembayarans', MetodePembayaranController::class)
    ->except(['create', 'edit', 'show']);

Route::get('supirs/data', [SupirController::class, 'data'])->name('supirs.data');

Route::resource('supirs', SupirController::class)
    ->except(['create', 'edit', 'show']);

Route::get('/kupons/data', [KuponController::class, 'data'])
    ->name('kupons.data');

Route::resource('kupons', KuponController::class)
    ->except(['create', 'edit', 'show']);
}); // end admin master data

Route::resource('mobils', MobilController::class)
    ->except(['create', 'edit', 'show', 'update', 'destroy'])
    ->middleware('admin');

Route::get('/mobils/data', [MobilController::class, 'data'])
    ->middleware('admin')
    ->name('mobils.data');

Route::get('/mobils/{mobil}', [MobilController::class, 'show'])
    ->name('mobils.show');

Route::middleware('admin')->group(function () {
    Route::get('/mobils/{mobil}/edit', [MobilController::class, 'edit'])
        ->name('mobils.edit');

    Route::put('/mobils/{mobil}', [MobilController::class, 'update'])
        ->name('mobils.update');

    Route::delete('/mobils/{mobil}', [MobilController::class, 'destroy'])
        ->name('mobils.destroy');
});

// Master penunjang mobil: khusus admin.
Route::middleware('admin')->group(function () {
Route::get('kerusakan_mobils/data', [KerusakanMobilController::class, 'data'])->name('kerusakan_mobils.data');

Route::resource('kerusakan_mobils', KerusakanMobilController::class)
    ->except(['create', 'edit', 'show']);

Route::get('foto_mobils/data', [FotoMobilController::class, 'data'])->name('foto_mobils.data');

Route::resource('foto_mobils', FotoMobilController::class)
    ->except(['create', 'edit', 'show']);

Route::get('dokumen_mobils/data', [DokumenMobilController::class, 'data'])->name('dokumen_mobils.data');

Route::resource('dokumen_mobils', DokumenMobilController::class)
    ->except(['create', 'edit', 'show']);
}); // end admin master penunjang mobil

Route::get('dendas/data', [DendaController::class, 'data'])->name('dendas.data')->middleware('adminstaff');

Route::resource('dendas', DendaController::class)
    ->except(['create', 'edit', 'show'])
    ->middleware('adminstaff');

Route::middleware('adminstaff')->group(function () {
    Route::put('/dendas/{denda}/status', [DendaController::class, 'updateStatus'])
        ->name('dendas.updateStatus');
});

Route::get('kompensasis/data', [KompensasiController::class, 'data'])->name('kompensasis.data')->middleware('adminstaff');

Route::resource('kompensasis', KompensasiController::class)
    ->except(['create', 'edit', 'show'])
    ->middleware('adminstaff');

Route::get('servis_mobils/data', [ServisMobilController::class, 'data'])->name('servis_mobils.data')->middleware('adminstaff');

Route::resource('servis_mobils', ServisMobilController::class)
    ->middleware('adminstaff');

// Master konten: khusus admin.
Route::middleware('admin')->group(function () {
Route::resource('banners', BannerController::class)
    ->except(['create', 'edit', 'show']);

Route::get('banners/data', [BannerController::class, 'data'])->name('banners.data');

Route::get('faqs/data', [FaqController::class, 'data'])->name('faqs.data');

Route::resource('faqs', FaqController::class)
    ->except(['create', 'edit', 'show']);
}); // end admin master konten

Route::get('/', [HomeController::class, 'index'])
    ->middleware('guest')
    ->name('home');

Route::get('/dashboard', function () {
    return match (Auth::user()->roles_id) {
        1 => redirect()->route('admin.dashboard'),
        2 => redirect()->route('staff.dashboard'),
        default => redirect()->route('customer.dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware('admin')
    ->name('admin.dashboard');

Route::get('/staff/dashboard', [StaffDashboardController::class, 'index'])
    ->middleware('staff')
    ->name('staff.dashboard');
Route::middleware('staff')->group(function () {
    Route::get('/staff/mobils', [MobilController::class, 'index'])
        ->name('staff.mobils.index');

    Route::get('/staff/mobils/create', [MobilController::class, 'create'])->name('staff.mobils.create');

    Route::post('/staff/mobils', [MobilController::class, 'store'])
        ->name('staff.mobils.store');

    Route::get('/staff/mobils/{mobil}/edit', [MobilController::class, 'edit'])
        ->name('staff.mobils.edit');

    Route::put('/staff/mobils/{mobil}', [MobilController::class, 'update'])
        ->name('staff.mobils.update');

    Route::delete('/staff/mobils/{mobil}', [MobilController::class, 'destroy'])
        ->name('staff.mobils.destroy');

});

Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])
    ->middleware('customer')
    ->name('customer.dashboard');
Route::middleware('customer')->group(function () {
    Route::get('/customer/mobils/search', [CustomerDashboardController::class, 'search'])
        ->name('customer.mobils.search');

    Route::get('/customer/checkout/{mobil}', [RentalController::class, 'showCheckout'])
        ->name('rentals.checkout.show');
    Route::post('/customer/checkout/{mobil}', [RentalController::class, 'checkout'])
        ->name('rentals.checkout');
    Route::post('/customer/checkout/confirm/{mobil}', [RentalController::class, 'confirmCheckout'])
        ->name('rentals.checkout.confirm');

    Route::post('/customer/rental/{mobil}', [RentalController::class, 'store'])
        ->name('rentals.store');

    Route::get('/customer/pembayaran/{rental}', [PembayaranController::class, 'create'])
        ->name('pembayaran.create');

    Route::post('/customer/pembayaran/{rental}', [PembayaranController::class, 'store'])
        ->name('pembayaran.store');

    Route::get('/customer/kompensasi', [KompensasiController::class, 'customerIndex'])
        ->name('customer.kompensasi.index');

    Route::get('/customer/kompensasi/data', [KompensasiController::class, 'customerData'])
        ->name('customer.kompensasi.data');

    Route::get('/customer/kompensasi/create', [KompensasiController::class, 'customerCreate'])
        ->name('customer.kompensasi.create');

    Route::post('/customer/kompensasi', [KompensasiController::class, 'store'])
        ->name('customer.kompensasi.store');

    Route::post('/customer/dendas/{denda}/bayar', [DendaController::class, 'customerBayar'])
        ->name('customer.dendas.bayar');
});

Route::middleware('adminstaff')->group(function () {
    Route::get('/rentals', [RentalController::class, 'index'])
        ->name('rentals.index');

    Route::get('/rentals/data', [RentalController::class, 'data'])
        ->name('rentals.data');

    Route::get('/rentals/{rental}/detail', [RentalController::class, 'detail'])
        ->name('rentals.detail');

    Route::put('/rentals/{rental}/status', [RentalController::class, 'updateStatus'])
        ->name('rentals.updateStatus');

    Route::get('/pembayaran', [PembayaranController::class, 'index'])
        ->name('pembayarans.index');

    Route::get('/pembayaran/data', [PembayaranController::class, 'data'])
        ->name('pembayarans.data');

    Route::get('/pembayaran/{pembayaran}/detail', [PembayaranController::class, 'detail'])
        ->name('pembayarans.detail');

    Route::put('/pembayaran/{pembayaran}/status', [PembayaranController::class, 'updateStatus'])
        ->name('pembayarans.updateStatus');
});
Route::resource('users', UserController::class)
    ->except(['create', 'edit', 'show'])
    ->middleware('adminstaff');

Route::middleware('adminstaff')->group(function () {
    Route::get('/users/data', [UserController::class, 'data'])
        ->name('users.data');

    Route::get('/users/{user}/detail', [UserController::class, 'detail'])
        ->name('users.detail');
});

Route::middleware('adminstaff')->group(function () {
    Route::resource('pengembalian', PengembalianController::class)
        ->only(['index']);

    Route::resource('pemeriksaan-kendaraan', PemeriksaanKendaraanController::class)
        ->only(['index']);

    Route::get('/pemeriksaan-kendaraan/data', [PemeriksaanKendaraanController::class, 'data'])
        ->name('pemeriksaan-kendaraan.data');

    Route::post('/pemeriksaan-kendaraan', [PemeriksaanKendaraanController::class, 'store'])
        ->name('pemeriksaan-kendaraan.store');

    Route::put('/pemeriksaan-kendaraan/{pemeriksaan}', [PemeriksaanKendaraanController::class, 'update'])
        ->name('pemeriksaan-kendaraan.update');

    Route::delete('/pemeriksaan-kendaraan/{pemeriksaan}', [PemeriksaanKendaraanController::class, 'destroy'])
        ->name('pemeriksaan-kendaraan.destroy');
});

Route::middleware('adminstaff')->group(function () {

    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');
});

Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/customer/ratings/create/{rental}', [CustomerRatingController::class, 'create'])
        ->name('customer.ratings.create');

    Route::post('/customer/ratings/{rental}', [CustomerRatingController::class, 'store'])
        ->name('customer.ratings.store');
});

Route::middleware('admin')->group(function () {
    Route::get('/admin/landing-settings', [LandingSettingController::class, 'edit'])
        ->name('admin.landing-settings.edit');

    Route::put('/admin/landing-settings', [LandingSettingController::class, 'update'])
        ->name('admin.landing-settings.update');
});

require __DIR__.'/auth.php';
