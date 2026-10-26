<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LandingSettingController;
use App\Http\Controllers\Admin\RatingController as AdminRatingController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\CustomerRatingController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\DokumenMobilController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\FotoMobilController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KerusakanMobilController;
use App\Http\Controllers\KompensasiController;
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
use App\Http\Controllers\ServisMobilController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\SupirController;
use App\Http\Controllers\TipeMobilController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| MASTER DATA
|--------------------------------------------------------------------------
| Admin saja — data referensi (role, brand, tipe, cabang, fasilitas,
| metode, supir, kupon) hanya boleh diubah Admin; Staff memakai lewat dropdown.
|--------------------------------------------------------------------------
*/

Route::middleware('admin')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */

    // Route::get('roles/data', [RoleController::class, 'data'])->name('roles.data');

    // Route::resource('roles', RoleController::class)->except(['create', 'edit', 'show']);

    /*
    |--------------------------------------------------------------------------
    | Brands
    |--------------------------------------------------------------------------
    */

    Route::get('brands/data', [BrandController::class, 'data'])->name('brands.data');

    Route::resource('brands', BrandController::class)->except(['create', 'edit']);

    /*
    |--------------------------------------------------------------------------
    | Tipe Mobil
    |--------------------------------------------------------------------------
    */

    Route::get('tipe_mobils/data', [TipeMobilController::class, 'data'])->name('tipe_mobils.data');

    Route::resource('tipe_mobils', TipeMobilController::class)->except(['create', 'edit', 'show']);

    /*
    |--------------------------------------------------------------------------
    | Cabang
    |--------------------------------------------------------------------------
    */

    Route::get('cabangs/data', [CabangController::class, 'data'])->name('cabangs.data');

    Route::resource('cabangs', CabangController::class)->except(['create', 'edit', 'show']);

    /*
    |--------------------------------------------------------------------------
    | Fasilitas
    |--------------------------------------------------------------------------
    */

    Route::get('/fasilitas/data', [FasilitasController::class, 'data'])->name('fasilitas.data');

    Route::resource('fasilitas', FasilitasController::class)->except(['create', 'edit', 'show']);

    /*
    |--------------------------------------------------------------------------
    | Metode Pembayaran
    |--------------------------------------------------------------------------
    */

    Route::get('metode_pembayarans/data', [MetodePembayaranController::class, 'data'])->name('metode_pembayarans.data');

    Route::resource('metode_pembayarans', MetodePembayaranController::class)->except(['create', 'edit', 'show']);

    /*
    |--------------------------------------------------------------------------
    | Supir
    |--------------------------------------------------------------------------
    */

    Route::get('supirs/data', [SupirController::class, 'data'])->name('supirs.data');

    Route::resource('supirs', SupirController::class)->except(['create', 'edit', 'show']);

    /*
    |--------------------------------------------------------------------------
    | Kupon
    |--------------------------------------------------------------------------
    */

    Route::get('/kupons/data', [KuponController::class, 'data'])->name('kupons.data');

    Route::resource('kupons', KuponController::class)->except(['create', 'edit', 'show']);
});

/*
|--------------------------------------------------------------------------
| MANAGEMENT MOBIL - ADMIN
|--------------------------------------------------------------------------
*/

Route::resource('mobils', MobilController::class)
    ->except(['create', 'edit', 'show', 'update', 'destroy'])
    ->middleware('admin');

Route::get('/mobils/data', [MobilController::class, 'data'])
    ->middleware('admin')
    ->name('mobils.data');

Route::get('/mobils/{mobil}', [MobilController::class, 'show'])->name('mobils.show');

Route::middleware('admin')->group(function () {
    Route::put('/mobils/{mobil}', [MobilController::class, 'update'])->name('mobils.update');

    Route::delete('/mobils/{mobil}', [MobilController::class, 'destroy'])->name('mobils.destroy');
});

/*
|--------------------------------------------------------------------------
| MASTER PENUNJANG MOBIL
|--------------------------------------------------------------------------
| Admin dan Staff
|--------------------------------------------------------------------------
*/

Route::middleware('adminstaff')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Kerusakan Mobil
    |--------------------------------------------------------------------------
    */

    Route::get('kerusakan_mobils/data', [KerusakanMobilController::class, 'data'])->name('kerusakan_mobils.data');

    Route::resource('kerusakan_mobils', KerusakanMobilController::class)->except(['create', 'edit', 'show']);

    /*
    |--------------------------------------------------------------------------
    | Foto Mobil
    |--------------------------------------------------------------------------
    */

    Route::get('foto_mobils/data', [FotoMobilController::class, 'data'])->name('foto_mobils.data');

    Route::resource('foto_mobils', FotoMobilController::class)->except(['create', 'edit', 'show']);

    /*
    |--------------------------------------------------------------------------
    | Dokumen Mobil
    |--------------------------------------------------------------------------
    */

    Route::get('dokumen_mobils/data', [DokumenMobilController::class, 'data'])->name('dokumen_mobils.data');

    Route::resource('dokumen_mobils', DokumenMobilController::class)->except(['create', 'edit', 'show']);
});

/*
|--------------------------------------------------------------------------
| DENDA
|--------------------------------------------------------------------------
| Admin dan Staff
|--------------------------------------------------------------------------
*/

Route::get('dendas/data', [DendaController::class, 'data'])
    ->name('dendas.data')
    ->middleware('adminstaff');

Route::resource('dendas', DendaController::class)
    ->except(['create', 'edit', 'show'])
    ->middleware('adminstaff');

Route::middleware('adminstaff')->group(function () {
    Route::put('/dendas/{denda}/status', [DendaController::class, 'updateStatus'])->name('dendas.updateStatus');
});

/*
|--------------------------------------------------------------------------
| KOMPENSASI
|--------------------------------------------------------------------------
| Admin dan Staff
|--------------------------------------------------------------------------
*/

Route::get('kompensasis/data', [KompensasiController::class, 'data'])
    ->name('kompensasis.data')
    ->middleware('adminstaff');

Route::resource('kompensasis', KompensasiController::class)
    ->except(['create', 'edit', 'show'])
    ->middleware('adminstaff');

/*
|--------------------------------------------------------------------------
| SERVIS MOBIL
|--------------------------------------------------------------------------
| Admin dan Staff
|--------------------------------------------------------------------------
*/

Route::get('servis_mobils/data', [ServisMobilController::class, 'data'])
    ->name('servis_mobils.data')
    ->middleware('adminstaff');

Route::resource('servis_mobils', ServisMobilController::class)
    ->except(['create', 'edit', 'show'])
    ->middleware('adminstaff');

/*
|--------------------------------------------------------------------------
| MASTER KONTEN
|--------------------------------------------------------------------------
| Admin saja — konten landing (banner, FAQ) dikelola bersama
| landing-settings yang sudah admin-only; Staff fokus operasional rental.
|--------------------------------------------------------------------------
*/

Route::middleware('admin')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | BANNER
    |--------------------------------------------------------------------------
    */

    Route::get('banners/data', [BannerController::class, 'data'])->name('banners.data');

    Route::resource('banners', BannerController::class)->except(['create', 'edit']);

    /*
    |--------------------------------------------------------------------------
    | FAQ
    |--------------------------------------------------------------------------
    */

    Route::get('faqs/data', [FaqController::class, 'data'])->name('faqs.data');

    Route::resource('faqs', FaqController::class)->except(['create', 'edit', 'show']);
});

/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->middleware('guest')
    ->name('home');

Route::get('/katalog', [HomeController::class, 'katalog'])
    ->middleware('guest')
    ->name('katalog.index');

Route::get('/katalog/data', [HomeController::class, 'katalogData'])
    ->middleware('guest')
    ->name('katalog.data');

/*
|--------------------------------------------------------------------------
| CONTACT
|--------------------------------------------------------------------------
*/

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| MANAGEMENT CONTACT / HUBUNGI KAMI
|--------------------------------------------------------------------------
| Admin saja
|--------------------------------------------------------------------------
*/

Route::middleware('admin')->group(function () {
    Route::get('/admin/contacts', [ContactController::class, 'index'])->name('contacts.index');

    Route::get('/admin/contacts/data', [ContactController::class, 'data'])->name('contacts.data');

    Route::get('/admin/contacts/{contact}/detail', [ContactController::class, 'detail'])->name('contacts.detail');

    Route::patch('/admin/contacts/{contact}/read', [ContactController::class, 'markAsRead'])->name('contacts.read');

    Route::post('/admin/contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');

    Route::delete('/admin/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return match (Auth::user()->roles_id) {
        1 => redirect()->route('admin.dashboard'),

        2 => redirect()->route('staff.dashboard'),

        default => redirect()->route('customer.dashboard'),
    };
})
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/profile/email', [ProfileController::class, 'editEmail'])->name('profile.email.edit');

    Route::patch('/profile/email', [ProfileController::class, 'updateEmail'])->name('profile.email.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware('admin')
    ->name('admin.dashboard');

/*
|--------------------------------------------------------------------------
| STAFF DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/staff/dashboard', [StaffDashboardController::class, 'index'])
    ->middleware('staff')
    ->name('staff.dashboard');

/*
|--------------------------------------------------------------------------
| STAFF MANAGEMENT MOBIL
|--------------------------------------------------------------------------
*/

Route::middleware('staff')->group(function () {
    Route::get('/staff/mobils', [MobilController::class, 'index'])->name('staff.mobils.index');

    Route::post('/staff/mobils', [MobilController::class, 'store'])->name('staff.mobils.store');

    Route::put('/staff/mobils/{mobil}', [MobilController::class, 'update'])->name('staff.mobils.update');

    Route::delete('/staff/mobils/{mobil}', [MobilController::class, 'destroy'])->name('staff.mobils.destroy');
});

/*
|--------------------------------------------------------------------------
| CUSTOMER DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])
    ->middleware('customer')
    ->name('customer.dashboard');

Route::get('/customer/riwayat', [CustomerDashboardController::class, 'riwayat'])
    ->middleware('customer')
    ->name('customer.riwayat');

/*
|--------------------------------------------------------------------------
| CUSTOMER
|--------------------------------------------------------------------------
*/

Route::middleware('customer')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Pencarian Mobil
    |--------------------------------------------------------------------------
    */

    Route::get('/customer/mobils/search', [CustomerDashboardController::class, 'search'])->name('customer.mobils.search');

    /*
    |--------------------------------------------------------------------------
    | Checkout
    |--------------------------------------------------------------------------
    */

    Route::get('/customer/checkout/{mobil}', [RentalController::class, 'showCheckout'])->name('rentals.checkout.show');

    Route::post('/customer/checkout/{mobil}', [RentalController::class, 'checkout'])->name('rentals.checkout');

    Route::post('/customer/checkout/confirm/{mobil}', [RentalController::class, 'confirmCheckout'])->name('rentals.checkout.confirm');

    /*
    |--------------------------------------------------------------------------
    | Rental
    |--------------------------------------------------------------------------
    */

    Route::post('/customer/rental/{mobil}', [RentalController::class, 'store'])->name('rentals.store');

    /*
    |--------------------------------------------------------------------------
    | Pembayaran
    |--------------------------------------------------------------------------
    */

    Route::get('/customer/pembayaran/{rental}', [PembayaranController::class, 'create'])->name('pembayaran.create');

    Route::post('/customer/pembayaran/{rental}', [PembayaranController::class, 'store'])->name('pembayaran.store');

    /*
    |--------------------------------------------------------------------------
    | Kompensasi Customer
    |--------------------------------------------------------------------------
    */

    Route::get('/customer/kompensasi', [KompensasiController::class, 'customerIndex'])->name('customer.kompensasi.index');

    Route::get('/customer/kompensasi/data', [KompensasiController::class, 'customerData'])->name('customer.kompensasi.data');

    Route::get('/customer/kompensasi/create', [KompensasiController::class, 'customerCreate'])->name('customer.kompensasi.create');

    Route::post('/customer/kompensasi', [KompensasiController::class, 'store'])->name('customer.kompensasi.store');

    /*
    |--------------------------------------------------------------------------
    | Bayar Denda
    |--------------------------------------------------------------------------
    */

    Route::post('/customer/dendas/{denda}/bayar', [DendaController::class, 'customerBayar'])->name('customer.dendas.bayar');
});

/*
|--------------------------------------------------------------------------
| RENTAL & PEMBAYARAN
|--------------------------------------------------------------------------
| Admin dan Staff
|--------------------------------------------------------------------------
*/

Route::middleware('adminstaff')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Rental
    |--------------------------------------------------------------------------
    */

    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');

    Route::get('/rentals/data', [RentalController::class, 'data'])->name('rentals.data');

    Route::get('/rentals/{rental}/detail', [RentalController::class, 'detail'])->name('rentals.detail');

    Route::put('/rentals/{rental}/status', [RentalController::class, 'updateStatus'])->name('rentals.updateStatus');

    /*
    |--------------------------------------------------------------------------
    | Pembayaran
    |--------------------------------------------------------------------------
    */

    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayarans.index');

    Route::get('/pembayaran/data', [PembayaranController::class, 'data'])->name('pembayarans.data');

    Route::get('/pembayaran/{pembayaran}/detail', [PembayaranController::class, 'detail'])->name('pembayarans.detail');

    Route::put('/pembayaran/{pembayaran}/status', [PembayaranController::class, 'updateStatus'])->name('pembayarans.updateStatus');
});

/*
|--------------------------------------------------------------------------
| USERS
|--------------------------------------------------------------------------
| Admin saja — kelola identitas dan role; satu-satunya jalur eskalasi hak.
|--------------------------------------------------------------------------
*/

Route::resource('users', UserController::class)
    ->except(['create', 'edit', 'show'])
    ->middleware('admin');

Route::middleware('admin')->group(function () {
    Route::get('/users/data', [UserController::class, 'data'])->name('users.data');

    Route::get('/users/{user}/detail', [UserController::class, 'detail'])->name('users.detail');
});

/*
|--------------------------------------------------------------------------
| PENGEMBALIAN & PEMERIKSAAN
|--------------------------------------------------------------------------
| Admin dan Staff
|--------------------------------------------------------------------------
*/

Route::middleware('adminstaff')->group(function () {
   Route::middleware('adminstaff')->group(function () {

    // Menu Pengembalian
    Route::resource('pengembalian', PengembalianController::class)
        ->only(['index']);

    // Detail rental pada menu Pengembalian
    Route::get('/pengembalian/{rental}/detail', [
        \App\Http\Controllers\PengembalianController::class,
        'detail'
    ])->name('pengembalian.detail');

    // Menu Pemeriksaan Kendaraan
    Route::resource('pemeriksaan-kendaraan', PemeriksaanKendaraanController::class)
        ->only(['index']);

});

    Route::get('/pemeriksaan-kendaraan/data', [PemeriksaanKendaraanController::class, 'data'])->name('pemeriksaan-kendaraan.data');

    Route::post('/pemeriksaan-kendaraan', [PemeriksaanKendaraanController::class, 'store'])->name('pemeriksaan-kendaraan.store');

    Route::put('/pemeriksaan-kendaraan/{pemeriksaan}', [PemeriksaanKendaraanController::class, 'update'])->name('pemeriksaan-kendaraan.update');

    Route::delete('/pemeriksaan-kendaraan/{pemeriksaan}', [PemeriksaanKendaraanController::class, 'destroy'])->name('pemeriksaan-kendaraan.destroy');
});

/*
|--------------------------------------------------------------------------
| LAPORAN
|--------------------------------------------------------------------------
| Admin dan Staff
|--------------------------------------------------------------------------
*/

Route::middleware('adminstaff')->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

/*
|--------------------------------------------------------------------------
| CUSTOMER RATING
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'customer'])->group(function () {
    Route::post('/customer/ratings/{rental}', [CustomerRatingController::class, 'store'])->name('customer.ratings.store');
});

/*
|--------------------------------------------------------------------------
| ADMIN SETTINGS & RATING
|--------------------------------------------------------------------------
*/

Route::middleware('admin')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Landing Settings
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/landing-settings', [LandingSettingController::class, 'index'])->name('admin.landing-settings.index');

    Route::put('/admin/landing-settings', [LandingSettingController::class, 'update'])->name('admin.landing-settings.update');

    /*
    |--------------------------------------------------------------------------
    | Rating
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/ratings', [AdminRatingController::class, 'index'])->name('admin.ratings.index');

    Route::get('/admin/ratings/data', [AdminRatingController::class, 'data'])->name('admin.ratings.data');

    Route::delete('/admin/ratings/{rating}', [AdminRatingController::class, 'destroy'])->name('admin.ratings.destroy');
});

// route OTP
Route::middleware('auth')->group(function () {
    Route::get('/otp', [OtpController::class, 'show'])->name('otp.show');
    // Bucket route hanya meredam burst; cap 5 salah per user tetap penjaga utama.
    Route::post('/otp', [OtpController::class, 'verify'])
        ->middleware('throttle:10,1,otp-verify')
        ->name('otp.verify');
    Route::post('/otp/resend', [OtpController::class, 'resend'])
        ->middleware('throttle:3,1,otp-resend')
        ->name('otp.resend');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
