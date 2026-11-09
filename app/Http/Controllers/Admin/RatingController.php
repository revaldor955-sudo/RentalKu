<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        return view('admin.ratings.index')
            ->with('pageTitle', 'Ulasan Pelanggan');
    }

    public function data(Request $request)
    {
        // Query dasar ulasan.
        $query = Rating::query()
            ->with(['customer', 'booking.mobil', 'staff']);

        // Total seluruh ulasan sebelum pencarian.
        $recordsTotal = Rating::count();

        // Pencarian ulasan.
        $search = trim(
            (string) $request->input('search.value', '')
        );

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($customer) use ($search) {
                    $customer->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhereHas('booking.mobil', function ($mobil) use ($search) {
                        $mobil->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    })
                    ->orWhere('komentar', 'like', "%{$search}%")
                    ->orWhere('rating', 'like', "%{$search}%");
            });
        }

        // Total ulasan setelah pencarian.
        $recordsFiltered = (clone $query)->count();

        /*
         * Pengurutan default:
         * ID terbesar = ulasan terbaru.
         *
         * Pengurutan ini tidak bergantung pada kolom No
         * di DataTables karena kolom No hanya nomor tampilan.
         */
        $query->orderByDesc('id');

        // Pagination DataTables.
        $start = max(
            0,
            (int) $request->input('start', 0)
        );

        $length = (int) $request->input('length', 10);

        if ($length < 1) {
            $length = 10;
        }

        $length = min($length, 100);

        $ratings = $query
            ->offset($start)
            ->limit($length)
            ->get();

        // Format data untuk DataTables.
        $data = $ratings->map(function ($r) {
            return [
                'id' => $r->id,
                'customer_name' => $r->customer?->name ?? 'Anonim',
                'customer_email' => $r->customer?->email ?? '',
                'mobil_name' => $r->booking?->mobil?->name ?? '-',
                'booking_id' => $r->booking_id,
                'rating' => $r->rating,
                'komentar' => $r->komentar,
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function destroy(Request $request, Rating $rating)
    {
        $rating->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Ulasan berhasil dihapus.',
            ]);
        }

        return redirect()
            ->route('admin.ratings.index')
            ->with('success', 'Ulasan berhasil dihapus.');
    }
}
