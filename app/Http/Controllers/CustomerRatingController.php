<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerRatingController extends Controller
{
    /**
     * Menampilkan halaman rating.
     */
    public function create($rental)
    {
        $rental = Rental::findOrFail($rental);

        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        if ($rental->status !== 'Selesai') {
            abort(403, 'Rental belum selesai.');
        }

        $sudahMemberiRating = Rating::where(
            'booking_id',
            $rental->id
        )->exists();

        if ($sudahMemberiRating) {
            return redirect()
                ->route('customer.dashboard')
                ->with('error', 'Rental ini sudah memiliki rating.');
        }

        return view(
            'customer.ratings.create',
            compact('rental')
        );
    }


    /**
     * Menyimpan rating.
     */
    public function store(Request $request, $rental)
    {
        $rental = Rental::findOrFail($rental);

        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        if ($rental->status !== 'Selesai') {
            abort(403, 'Rental belum selesai.');
        }

        $sudahMemberiRating = Rating::where(
            'booking_id',
            $rental->id
        )->exists();

        if ($sudahMemberiRating) {
            return redirect()
                ->route('customer.dashboard')
                ->with('error', 'Rental ini sudah memiliki rating.');
        }

        $validated = $request->validate([
            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5',
            ],

            'komentar' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        $rating = new Rating();

        $rating->booking_id = $rental->id;
        $rating->customer_id = Auth::id();
        $rating->staff_id = null;
        $rating->rating = $validated['rating'];
        $rating->komentar = $validated['komentar'];

        $rating->save();

        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Rating berhasil dikirim.');
    }
}