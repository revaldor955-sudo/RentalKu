<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        return view('admin.ratings.index')->with('pageTitle', 'Customer Rating');
    }

    public function data(Request $request)
    {
        $query = Rating::with(['customer', 'booking.mobil', 'staff']);

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', fn($c) => $c->where('name', 'like', "%{$search}%"))
                  ->orWhere('komentar', 'like', "%{$search}%")
                  ->orWhere('rating', $search);
            });
        }

        $recordsFiltered = $query->count();

        $orderColumn = (int)$request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'desc');

        if ($orderColumn === 0) {
            $query->orderBy('id', $orderDir);
        } else {
            $query->orderBy('id', 'desc');
        }

        $start = (int)$request->input('start', 0);
        $length = (int)$request->input('length', 10);

        $ratings = $query->offset($start)->limit($length)->get();

        $data = $ratings->map(function ($r) {
            return [
                'id' => $r->id,
                'customer_name' => $r->customer?->name ?? 'Anonim',
                'customer_email' => $r->customer?->email ?? '',
                'mobil_name' => $r->booking?->mobil?->nama_mobil ?? '-',
                'booking_id' => $r->booking_id,
                'rating' => $r->rating,
                'komentar' => $r->komentar,
            ];
        });

        return response()->json([
            'draw' => (int)$request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function destroy(Rating $rating, Request $request)
    {
        $rating->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Ulasan berhasil dihapus.']);
        }

        return redirect()->route('admin.ratings.index')->with('success', 'Ulasan berhasil dihapus.');
    }
}
