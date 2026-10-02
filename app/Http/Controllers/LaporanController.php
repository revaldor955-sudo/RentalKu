<?php

namespace App\Http\Controllers;

use App\Support\LaporanData;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Laporan pendapatan: pembayaran Disetujui + denda lunas - kompensasi
     * pengembalian_dana, dalam rentang tanggal.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'dari'   => ['nullable', 'date'],
            'sampai' => ['nullable', 'date', 'after_or_equal:dari'],
        ]);

        $dari   = $validated['dari']   ?? now()->subDays(29)->toDateString();
        $sampai = $validated['sampai'] ?? now()->toDateString();

        $laporan = LaporanData::laporan($dari, $sampai);

        return view('laporan.index', $laporan + [
            'dari'   => $dari,
            'sampai' => $sampai,
        ]);
    }
}
