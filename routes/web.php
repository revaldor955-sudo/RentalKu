<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\DokumenMobilController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\FotoMobilController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KerusakanMobilController;
use App\Http\Controllers\KuponController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MetodePembayaranController;
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

Route::resource('roles', RoleController::class)
    ->except(['create', 'edit', 'show']);

Route::resource('brands', BrandController::class)
    ->except(['create', 'edit', 'show']);

Route::resource('tipe_mobils', TipeMobilController::class)
    ->except(['create', 'edit', 'show']);

Route::resource('cabangs', CabangController::class)
    ->except(['create', 'edit', 'show']);

Route::resource('fasilitas', FasilitasController::class)
    ->except(['create', 'edit', 'show']);

Route::resource('metode_pembayarans', MetodePembayaranController::class)
    ->except(['create', 'edit', 'show']);

Route::resource('supirs', SupirController::class)
    ->except(['create', 'edit', 'show']);

Route::resource('kupons', KuponController::class)
    ->except(['create', 'edit', 'show']);

Route::resource('mobils', MobilController::class)
    ->except(['create', 'edit', 'show', 'update', 'destroy']);

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

Route::resource('kerusakan_mobils', KerusakanMobilController::class)
    ->except(['create', 'edit', 'show']);

Route::resource('foto_mobils', FotoMobilController::class)
    ->except(['create', 'edit', 'show']);

Route::resource('dokumen_mobils', DokumenMobilController::class)
    ->except(['create', 'edit', 'show']);

Route::resource('banners', BannerController::class)
    ->except(['create', 'edit', 'show']);

Route::resource('faqs', FaqController::class)
    ->except(['create', 'edit', 'show']);

Route::get('/', [HomeController::class, 'index'])
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
    Route::post('/customer/rental/{mobil}', [RentalController::class, 'store'])
        ->name('rentals.store');

    Route::get('/customer/pembayaran/{rental}', [PembayaranController::class, 'create'])
        ->name('pembayaran.create');

    Route::post('/customer/pembayaran/{rental}', [PembayaranController::class, 'store'])
        ->name('pembayaran.store');
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

Route::resource('pengembalian', PengembalianController::class)
    ->only(['index']);

Route::resource('pemeriksaan-kendaraan', PemeriksaanKendaraanController::class)
    ->only(['index']);
Route::get('/laporan', [LaporanController::class, 'index'])
    ->name('laporan.index');

require __DIR__.'/auth.php';
