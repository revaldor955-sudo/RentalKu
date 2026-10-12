<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\LandingSetting;
use App\Models\Mobil;
use App\Models\Rental;
use Illuminate\Http\Request;
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

        // Filter status katalog: tersedia (default) atau tidak_tersedia.
        $statusInput = strtolower(trim((string) $request->query('status', '')));
        if (! in_array($statusInput, ['tersedia', 'tidak_tersedia'], true)) {
            $statusInput = '';
        }
        $statusMobil = $statusInput === 'tidak_tersedia' ? 'Disewa' : 'Tersedia';

        $punyaFilter = $cabangAktif !== null || $statusInput !== '';

        $mobils = Mobil::with(['brand', 'cabang', 'fotoMobils'])
            ->withCount('rentals')
            ->where('status', $statusMobil)
            ->when($cabangAktif !== null, function ($query) use ($cabangAktif) {
                $query->where('cabang_id', $cabangAktif->id);
            })
            ->orderByDesc('rentals_count')
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        // AJAX: kembalikan partial hasil saja, query section lain dilewati.
        if ($request->ajax() || $request->wantsJson()) {
            return view('home.partials.daftar-mobil', compact(
                'mobils',
                'punyaFilter',
                'cabangAktif',
                'statusInput',
                'statusMobil'
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
            ->where('is_active', true)
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
            'statusInput',
            'statusMobil',
            'punyaFilter',
            'landingSettings',
            'totalPuas',
            'ratingRata',
            'totalMobil'
        ));
    }

    public function katalog(Request $request)
    {
        // Input invalid diabaikan, bukan error — katalog tidak boleh 422.
        $cabangId = $request->query('cabang');
        $cabangAktif = null;
        if ($cabangId !== null && $cabangId !== '') {
            $cabangAktif = Cabang::find($cabangId);
        }

        $transmisi = strtolower(trim((string) $request->query('transmisi', '')));
        if (! in_array($transmisi, ['manual', 'matic'], true)) {
            $transmisi = '';
        }

        $kataKunci = trim((string) $request->query('q', ''));

        $statusInput = strtolower(trim((string) $request->query('status', '')));
        if (! in_array($statusInput, ['tersedia', 'tidak_tersedia'], true)) {
            $statusInput = '';
        }
        $statusMobil = $statusInput === 'tidak_tersedia' ? 'Disewa' : 'Tersedia';

        $perPage = (int) $request->query('per_page', 10);
        if (! in_array($perPage, [10, 20, 50], true)) {
            $perPage = 10;
        }

        $mobils = Mobil::with(['brand', 'cabang', 'fotoMobils'])
            ->withCount('rentals')
            ->where('status', $statusMobil)
            ->when($cabangAktif !== null, function ($query) use ($cabangAktif) {
                $query->where('cabang_id', $cabangAktif->id);
            })
            ->when($transmisi !== '', function ($query) use ($transmisi) {
                $query->where('transmisi', $transmisi);
            })
            ->when($kataKunci !== '', function ($query) use ($kataKunci) {
                $query->where(function ($q) use ($kataKunci) {
                    $q->where('name', 'like', "%{$kataKunci}%")
                        ->orWhere('plate_number', 'like', "%{$kataKunci}%");
                });
            })
            ->orderByDesc('rentals_count')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        // Halaman di luar jangkauan (misal ganti per_page saat di page akhir)
        // dialihkan ke halaman valid terdekat, bukan grid kosong.
        if ($mobils->lastPage() > 0 && ($mobils->currentPage() > $mobils->lastPage() || $mobils->currentPage() < 1)) {
            return redirect()->route('katalog.index', array_merge(
                $request->query(),
                ['page' => max(1, min($mobils->currentPage(), $mobils->lastPage()))]
            ));
        }

        $cabangs = DB::table('cabangs')->orderBy('name')->get();

        $populerIds = array_map(
            'intval',
            Rental::selectRaw('mobil_id, COUNT(*) as c')
                ->groupBy('mobil_id')
                ->orderByDesc('c')
                ->limit(3)
                ->pluck('mobil_id')
                ->all()
        );

        return view('katalog.index', compact(
            'mobils',
            'cabangs',
            'cabangAktif',
            'transmisi',
            'kataKunci',
            'statusInput',
            'statusMobil',
            'populerIds',
            'perPage'
        ));
    }
}
