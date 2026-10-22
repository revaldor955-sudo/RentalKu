<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\Kompensasi;
use App\Models\MetodePembayaran;
use App\Models\Mobil;
use App\Models\Rental;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function riwayat()
    {
        $userId = auth()->id();
        $rentals = Rental::with(['mobil', 'pembayaran', 'dendas', 'cabangAmbil', 'cabangKembali', 'rating'])
            ->where('user_id', $userId)
            ->whereIn('status', ['Selesai', 'Ditolak'])
            ->latest()
            ->get();

        return view('customer.riwayat', compact('rentals'));
    }

    public function index()
    {
        $userId = auth()->id();

        $mobilTersediaCount = Mobil::where('status', 'Tersedia')->count();

        $rentalCount = Rental::where('user_id', $userId)->count();

        $totalTransaksi = Rental::where('user_id', $userId)->sum('total_harga');

        $filters = request()->only(['q', 'cabang', 'transmisi']);

        $mobils = Mobil::with(['brand', 'tipeMobil', 'cabang', 'fasilitas'])
            ->where('status', 'Tersedia')
            ->when($filters['q'] ?? null, function ($query, $q) {
                $query->where('name', 'like', '%' . $q . '%');
            })
            ->when($filters['cabang'] ?? null, function ($query, $cabang) {
                $query->where('cabang_id', $cabang);
            })
            ->when($filters['transmisi'] ?? null, function ($query, $transmisi) {
                $query->where('transmisi', $transmisi);
            })
            ->latest()
            ->take(9)
            ->get();

        $cabangs = Cabang::orderBy('name')->get();

        $metodePembayarans = MetodePembayaran::orderBy('name')->get();

        $rentals = Rental::with(['mobil', 'pembayaran', 'dendas', 'cabangAmbil', 'cabangKembali', 'rating'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        // Tab: Aktivitas (Menunggu/Disetujui) vs Riwayat (Selesai/Ditolak).
        $rentalsAktif = $rentals->whereIn('status', ['Menunggu', 'Disetujui']);
        $rentalsRiwayat = $rentals->whereIn('status', ['Selesai', 'Ditolak']);

        // Grid aktivitas ala landing: tampil sebagian + tombol muat lagi.
        $jumlahRental = max(4, (int) request()->input('jumlah_rental', 4));
        $totalRentals = $rentals->count();
        $rentalsTampil = $rentalsAktif->take($jumlahRental);

        // Hasil verifikasi klaim yang belum dibaca customer.
        $klaimUpdates = Kompensasi::with('mobil')
            ->where('customer_id', $userId)
            ->whereNull('dibaca_at')
            ->whereIn('status', ['disetujui', 'ditolak', 'selesai'])
            ->latest()
            ->get();

        // GoodUI #4 (social proof): 3 mobil paling sering disewa.
        $populerIds = Rental::selectRaw('mobil_id, COUNT(*) as c')->groupBy('mobil_id')->orderByDesc('c')->limit(3)->pluck('mobil_id')->all();
        $populerIds = array_map('intval', $populerIds);

        return view('customer.dashboard', compact(
            'mobils',
            'rentals',
            'rentalsAktif',
            'rentalsRiwayat',
            'mobilTersediaCount',
            'rentalCount',
            'totalTransaksi',
            'cabangs',
            'filters',
            'klaimUpdates',
            'metodePembayarans',
            'jumlahRental',
            'totalRentals',
            'rentalsTampil',
            'populerIds'
        ));
    }

    /**
     * Live search katalog (AJAX): mobil Tersedia + filter.
     */
    public function search(Request $request)
    {
        $mobils = Mobil::with(['brand', 'tipeMobil', 'cabang'])
            ->where('status', 'Tersedia')
            ->when($request->input('q'), function ($query, $q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('mobils.name', 'like', '%' . $q . '%')
                        ->orWhereHas('brand', function ($b) use ($q) {
                            $b->where('name', 'like', '%' . $q . '%');
                        });
                });
            })
            ->when($request->input('cabang'), function ($query, $cabang) {
                $query->where('cabang_id', $cabang);
            })
            ->when($request->input('transmisi'), function ($query, $transmisi) {
                $query->where('transmisi', $transmisi);
            })
            ->latest()
            ->take(12)
            ->get();

        return response()->json($mobils->map(function ($mobil) {
            return [
                'id' => $mobil->id,
                'slug' => $mobil->slug,
                'name' => $mobil->name,
                'image_url' => $mobil->image ? asset($mobil->image) : null,
                'transmisi' => $mobil->transmisi,
                'kapasitas' => $mobil->kapasitas,
                'harga_perhari' => (float) $mobil->harga_perhari,
                'deposit' => (float) ($mobil->deposit ?? 0),
                'cabang' => $mobil->cabang->name ?? '-',
            ];
        })->values());
    }
}
