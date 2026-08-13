<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DokumenMobilController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\FotoMobilController;
use App\Http\Controllers\KerusakanMobilController;
use App\Http\Controllers\KuponController;
use App\Http\Controllers\MetodePembayaranController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupirController;
use App\Http\Controllers\TipeMobilController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
->except(['create', 'edit', 'show']);

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