<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function create(Rental $rental)
    {
        abort_unless($rental->user_id === Auth::id(), 403);

        abort_unless($rental->status === 'Selesai', 403);

        $sudahMemberiUlasan = Rating::where('booking_id', $rental->id)->exists();

        if ($sudahMemberiUlasan) {
            return redirect()->route('customer.dashboard')->with('error', 'Pengajuan ini sudah memiliki ulasan.');
        }

        return view('customer.ratings.create', compact('rental'));
    }

    public function store(Request $request, Rental $rental)
    {
        abort_unless($rental->user_id === Auth::id(), 403);

        abort_unless($rental->status === 'Selesai', 403);

        $sudahMemberiUlasan = Rating::where('booking_id', $rental->id)->exists();

        if ($sudahMemberiUlasan) {
            return redirect()->route('customer.dashboard')->with('error', 'Pengajuan ini sudah memiliki ulasan.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        Rating::create([
            'booking_id' => $rental->id,
            'customer_id' => Auth::id(),
            'staff_id' => null,
            'rating' => $validated['rating'],
            'komentar' => $validated['komentar'] ?? null,
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Ulasan berhasil dikirim.');
    }
}