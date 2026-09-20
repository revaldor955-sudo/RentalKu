<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Mobil;
use App\Models\LandingSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Filter cabang
        $cabangId = $request->query('cabang');
        $cabangAktif = null;

        if ($cabangId !== null && $cabangId !== '') {
            $cabangAktif = Cabang::find($cabangId);
        }
$kontak = DB::table('cabangs')
    ->orderBy('id')
    ->first();
        // Validasi tanggal
        $mulai = $this->tanggalValid(
            $request->query('tanggal_mulai'),
            minDate: Carbon::today()
        );

        $selesai = $this->tanggalValid(
            $request->query('tanggal_selesai')
        );

        if (
            $mulai === null ||
            $selesai === null ||
            $selesai->lt($mulai)
        ) {
            $mulai = null;
            $selesai = null;
        }

        // Jumlah mobil
        $jumlah = (int) $request->query('jumlah', 6);
        $jumlah = max(1, min(48, $jumlah));

        $punyaFilter = $cabangAktif !== null || $mulai !== null;

        // Total mobil tersedia
        $totalTersedia = Mobil::where('status', 'Tersedia')->count();

        // Data mobil
        $mobils = Mobil::with([
                'brand',
                'cabang',
                'fotoMobils'
            ])
            ->where('status', 'Tersedia')

            ->when($cabangAktif !== null, function ($query) use ($cabangAktif) {
                $query->where('cabang_id', $cabangAktif->id);
            })

            ->when($mulai !== null, function ($query) use ($mulai, $selesai) {

                // Rental yang masih menunggu atau disetujui
                // tidak boleh memiliki tanggal yang bertabrakan.
                $query->whereDoesntHave('rentals', function ($q) use ($mulai, $selesai) {

                    $q->whereIn('status', [
                            'Menunggu',
                            'Disetujui'
                        ])
                        ->where('tanggal_mulai', '<=', $selesai)
                        ->where('tanggal_selesai', '>=', $mulai);
                });
            })

            ->orderByDesc('id')

            ->when(
                ! $punyaFilter,
                fn ($query) => $query->limit($jumlah)
            )

            ->get();

        // AJAX: hanya mengembalikan hasil pencarian mobil
        if ($request->ajax() || $request->wantsJson()) {

            return view(
                'home.partials.hasil-pencarian',
                compact(
                    'mobils',
                    'punyaFilter',
                    'cabangAktif',
                    'mulai',
                    'selesai',
                    'jumlah',
                    'totalTersedia'
                )
            );
        }

        // Data banner
        $banners = DB::table('banners')
            ->where('status', 'aktif')
            ->orderBy('urutan')
            ->get();

        // Data brand
        $brands = DB::table('brands')
            ->orderBy('name')
            ->get();

        // Data cabang
        $cabangs = DB::table('cabangs')
            ->orderBy('name')
            ->get();

        // Data rating
        $ratings = DB::table('ratings')
            ->join(
                'users',
                'ratings.customer_id',
                '=',
                'users.id'
            )
            ->select(
                'ratings.*',
                'users.name',
                'users.photo as foto_user'
            )
            ->latest('ratings.id')
            ->limit(6)
            ->get();

        // Data FAQ
        $faqs = DB::table('faqs')
            ->orderBy('urutan')
            ->get();
            

        // Data promo dinamis dari tabel kupons
        $kupons = DB::table('kupons')
            ->where(function ($query) {
                $query->whereNull('active_at')
                    ->orWhere('active_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expired_at')
                    ->orWhere('expired_at', '>=', now());
            })
            ->whereColumn('terpakai', '<', 'kuota')
            ->orderByDesc('id')
            ->get();
$landing = LandingSetting::pluck('value', 'key')->toArray();
        // Kirim seluruh data ke landing page
      return view('home', compact(
    'banners',
    'mobils',
    'brands',
    'ratings',
    'faqs',
    'cabangs',
    'kupons',
    'cabangAktif',
    'mulai',
    'selesai',
    'punyaFilter',
    'jumlah',
    'totalTersedia',
    'landing',
    'kontak'
));
    }

    private function tanggalValid(
    ?string $nilai,
    ?Carbon $minDate = null
): ?Carbon {
    if (
        $nilai === null ||
        !preg_match('/^\d{4}-\d{2}-\d{2}$/', $nilai)
    ) {
        return null;
    }

    try {
        $tanggal = Carbon::createFromFormat(
            'Y-m-d',
            $nilai
        )->startOfDay();

        // Memastikan tanggal benar-benar valid
        if ($tanggal->format('Y-m-d') !== $nilai) {
            return null;
        }
    } catch (\Throwable) {
        return null;
    }

    if (
        $minDate !== null &&
        $tanggal->lt($minDate)
    ) {
        return null;
    }

    return $tanggal;
}
}