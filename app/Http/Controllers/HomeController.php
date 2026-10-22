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
        [$query, $cabangAktif, $transmisi, $kataKunci, $statusInput, $statusMobil] =
            $this->baseKatalogQuery($request);

        $perPage = (int) $request->query('per_page', 10);
        if (! in_array($perPage, [10, 20, 50], true)) {
            $perPage = 10;
        }

        $sort = strtolower(trim((string) $request->query('sort', 'populer')));
        if (! in_array($sort, ['populer', 'harga_asc', 'harga_desc', 'terbaru'], true)) {
            $sort = 'populer';
        }

        $mobils = $this->applyKatalogSort(clone $query, $sort)
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

        $populerIds = $this->populerMobilIds();

        return view('katalog.index', compact(
            'mobils',
            'cabangs',
            'cabangAktif',
            'transmisi',
            'kataKunci',
            'statusInput',
            'statusMobil',
            'populerIds',
            'perPage',
            'sort'
        ));
    }

    /**
     * Data grid katalog (AJAX): filter + sort + pagination tanpa reload.
     * Hanya field yang aman ditampilkan publik.
     */
    public function katalogData(Request $request)
    {
        [$query, $cabangAktif, $transmisi, $kataKunci, $statusInput, $statusMobil] =
            $this->baseKatalogQuery($request);

        $sort = strtolower(trim((string) $request->query('sort', 'populer')));
        if (! in_array($sort, ['populer', 'harga_asc', 'harga_desc', 'terbaru'], true)) {
            $sort = 'populer';
        }

        $perPage = (int) $request->query('per_page', 10);
        if (! in_array($perPage, [10, 20, 50, 100], true)) {
            $perPage = max(1, min($perPage, 100));
        }

        $query = match ($sort) {
            'harga_asc' => $this->applyKatalogSort(clone $query, 'harga_asc'),
            'harga_desc' => $this->applyKatalogSort(clone $query, 'harga_desc'),
            'terbaru' => $this->applyKatalogSort(clone $query, 'terbaru'),
            default => $this->applyKatalogSort(clone $query, 'populer'),
        };

        $page = max(1, (int) $request->query('page', 1));
        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        // Halaman di luar jangkauan dijepit ke halaman valid terdekat.
        if ($paginator->lastPage() > 0 && $page > $paginator->lastPage()) {
            $paginator = $query->paginate($perPage, ['*'], 'page', $paginator->lastPage());
        }

        $populerIds = $this->populerMobilIds();

        $fallbackFoto = 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=900&q=80';

        $data = $paginator->getCollection()->map(function ($mobil) use ($populerIds, $fallbackFoto) {
            $foto = $mobil->fotoMobils->first()?->url
                ?? ($mobil->image ? asset($mobil->image) : $fallbackFoto);

            return [
                'slug' => $mobil->slug,
                'name' => $mobil->name,
                'foto_url' => str_starts_with($foto, 'http') ? $foto : asset($foto),
                'transmisi' => $mobil->transmisi,
                'kapasitas' => $mobil->kapasitas,
                'harga_perhari' => (float) $mobil->harga_perhari,
                'deposit' => (float) ($mobil->deposit ?? 0),
                'cabang' => $mobil->cabang->name ?? '-',
                'populer' => in_array((int) $mobil->id, $populerIds, true),
            ];
        })->values();

        return response()->json([
            'data' => $data,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'tersedia' => $statusMobil === 'Tersedia',
            ],
        ]);
    }

    /**
     * Query dasar katalog + parameter filter yang sudah dinormalisasi.
     * Input invalid diabaikan, bukan error — katalog tidak boleh 422.
     *
     * @return array{0: \Illuminate\Database\Eloquent\Builder, 1: ?Cabang, 2: string, 3: string, 4: string, 5: string}
     */
    private function baseKatalogQuery(Request $request): array
    {
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

        $query = Mobil::with(['brand', 'cabang', 'fotoMobils'])
            ->withCount('rentals')
            ->where('status', $statusMobil)
            ->when($cabangAktif !== null, function ($query) use ($cabangAktif) {
                $query->where('cabang_id', $cabangAktif->id);
            })
            ->when($transmisi !== '', function ($query) use ($transmisi) {
                // Kolom enum menyimpan 'Manual'/'Matic' — samakan kapitalisasinya
                // agar filter lolos di MySQL maupun SQLite (case-sensitive).
                $query->where('transmisi', ucfirst($transmisi));
            })
            ->when($kataKunci !== '', function ($query) use ($kataKunci) {
                $query->where(function ($q) use ($kataKunci) {
                    $q->where('name', 'like', "%{$kataKunci}%")
                        ->orWhere('plate_number', 'like', "%{$kataKunci}%");
                });
            });

        return [$query, $cabangAktif, $transmisi, $kataKunci, $statusInput, $statusMobil];
    }

    /**
     * Urutan grid katalog.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function applyKatalogSort($query, string $sort)
    {
        return match ($sort) {
            'harga_asc' => $query->orderBy('harga_perhari')->orderByDesc('id'),
            'harga_desc' => $query->orderByDesc('harga_perhari')->orderByDesc('id'),
            'terbaru' => $query->orderByDesc('id'),
            default => $query->orderByDesc('rentals_count')->orderByDesc('id'),
        };
    }

    /**
     * 3 mobil paling sering disewa (badge Populer).
     *
     * @return int[]
     */
    private function populerMobilIds(): array
    {
        return array_map(
            'intval',
            Rental::selectRaw('mobil_id, COUNT(*) as c')
                ->groupBy('mobil_id')
                ->orderByDesc('c')
                ->limit(3)
                ->pluck('mobil_id')
                ->all()
        );
    }
}
