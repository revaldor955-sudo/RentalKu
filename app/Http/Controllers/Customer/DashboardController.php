<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Models\Rental;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $mobils = Mobil::with(['brand', 'tipeMobil', 'cabang', 'fasilitas'])
            ->latest()->take(6)->get();

        $rentals = Rental::with(['mobil', 'pembayaran'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $response = Http::withHeaders([
            'Authorization' => config('services.pexels.key'),
        ])->get('https://api.pexels.com/v1/search', [
            'query' => 'car rental',
            'per_page' => 6,
            'orientation' => 'landscape',
        ]);

        $photos = $response->successful() ? $response->json('photos', []) : [];

        return view('customer.dashboard', compact('mobils', 'photos', 'rentals'));
    }
}