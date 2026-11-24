<?php

namespace App\Http\Middleware;

use App\Models\Denda;
use Closure;
use Illuminate\Http\Request;

class BlokirJikaAdaDenda
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return $next($request);
        }

        $denda = Denda::belumLunas()->whereHas('rental', fn($q) => $q->where('user_id', auth()->id()))->get();

        if ($denda->isEmpty()) {
            return $next($request);
        }

        $message = $denda->contains(fn($d) => $d->isBelumBayar()) ? 'Anda masih memiliki denda yang belum dibayar. Selesaikan pembayaran denda terlebih dahulu sebelum menyewa mobil lagi.' : 'Pembayaran denda Anda sedang menunggu verifikasi tim kami. Anda bisa menyewa mobil lagi setelah denda dinyatakan lunas.';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $message,
                ],
                422,
            );
        }

        return redirect()->route('customer.dashboard')->with('error', $message);
    }
}
