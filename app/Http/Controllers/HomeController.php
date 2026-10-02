<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\LandingSetting;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Input invalid diabaikan, bukan error — landing tidak boleh 422.
        $cabangId = $request->query('cabang');
        $cabangAktif = null;
        if ($cabangId !== null && $cabangId !== '') {
            $cabangAktif = Cabang::find($cabangId);
        }

        $mulai = $this->tanggalValid($request->query('tanggal_mulai'), minDate: Carbon::today());
        $selesai = $this->tanggalValid($request->query('tanggal_selesai'));
        if ($mulai === null || $selesai === null || $selesai->lt($mulai)) {
            $mulai = null;
            $selesai = null;
        }

        $jumlah = (int) $request->query('jumlah', 6);
        $jumlah = max(1, min(48, $jumlah));
        $punyaFilter = $cabangAktif !== null || $mulai !== null;

        $totalTersedia = Mobil::where('status', 'Tersedia')->count();

        $mobils = Mobil::with(['brand', 'cabang', 'fotoMobils'])
            ->where('status', 'Tersedia')
            ->when($cabangAktif !== null, function ($query) use ($cabangAktif) {
                $query->where('cabang_id', $cabangAktif->id);
            })
            ->when($mulai !== null, function ($query) use ($mulai, $selesai) {
                // Rental Menunggu/Disetujui yang overlap membuat mobil tidak tersedia.
                $query->whereDoesntHave('rentals', function ($q) use ($mulai, $selesai) {
                    $q->whereIn('status', ['Menunggu', 'Disetujui'])
                        ->where('tanggal_mulai', '<=', $selesai)
                        ->where('tanggal_selesai', '>=', $mulai);
                });
            })
            ->orderByDesc('id')
            ->when(! $punyaFilter, fn ($query) => $query->limit($jumlah))
            ->get();

        // AJAX: kembalikan partial hasil saja, query section lain dilewati.
        if ($request->ajax() || $request->wantsJson()) {
            return view('home.partials.daftar-mobil', compact(
                'mobils',
                'punyaFilter',
                'cabangAktif',
                'mulai',
                'selesai',
                'jumlah',
                'totalTersedia'
            ));
        }

        $banners = DB::table('banners')
            ->where('status', 'aktif')
            ->orderBy('urutan')
            ->get();

        $brands = DB::table('brands')
            ->orderBy('name')
            ->get();

        $cabangs = DB::table('cabangs')
            ->orderBy('name')
            ->get();

$ratings = DB::table('ratings')
    ->join('users', 'ratings.customer_id', '=', 'users.id')
    ->join('rentals', 'ratings.rental_id', '=', 'rentals.id')
    ->join('mobils', 'rentals.mobil_id', '=', 'mobils.id')
    ->select(
        'ratings.*',
        'users.name as nama',
        'users.photo as foto_user',
        'mobils.name as nama_mobil'
    )
    ->latest('ratings.id')
    ->limit(6)
    ->get();
        $landingSettings = LandingSetting::pluck('value', 'key')->toArray();
        $selectedFaqIds = json_decode($landingSettings['selected_faq_ids'] ?? 'null', true);

        $faqs = DB::table('faqs')
            ->when(! empty($selectedFaqIds), function ($query) use ($selectedFaqIds) {
                $query->whereIn('id', array_values(array_unique($selectedFaqIds)));
            })
            ->orderBy('urutan')
            ->get();

        $totalPuas = DB::table('rentals')->where('status', 'selesai')->count() + 1200;
        $ratingRata = round(DB::table('ratings')->avg('rating'), 1);
        $totalMobil = DB::table('mobils')->count();

        return view('home', compact(
            'banners',
            'mobils',
            'brands',
            'ratings',
            'faqs',
            'cabangs',
            'cabangAktif',
            'mulai',
            'selesai',
            'punyaFilter',
            'jumlah',
            'totalTersedia',
            'landingSettings',
            'totalPuas',
            'ratingRata',
            'totalMobil'
        ));
    }

    private function tanggalValid(?string $nilai, ?Carbon $minDate = null): ?Carbon
    {
        if ($nilai === null || ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $nilai)) {
            return null;
        }

        try {
            $tanggal = Carbon::createFromFormat('Y-m-d', $nilai)->startOfDay();
        } catch (\Throwable) {
            return null;
        }

        if ($minDate !== null && $tanggal->lt($minDate)) {
            return null;
        }

        return $tanggal;
    }
}
