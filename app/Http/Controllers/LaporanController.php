<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Kompensasi;
use App\Models\Pembayaran;
use Carbon\CarbonPeriod;
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

        // Default periode: awal bulan ini s/d hari ini.
        $dari   = $validated['dari']   ?? now()->startOfMonth()->toDateString();
        $sampai = $validated['sampai'] ?? now()->toDateString();

        // Uang masuk utama: pembayaran yang sudah disetujui.
        $pembayarans = Pembayaran::query()
            ->where('status', 'Disetujui')
            ->whereBetween('tanggal_bayar', [$dari, $sampai])
            ->with([
                'rental.user:id,name',
                'rental.mobil:id,name,plate_number',
                'metodePembayaran:id,name',
            ])
            ->orderBy('tanggal_bayar')
            ->get();

        // Denda lunas. Tabel dendas tidak punya kolom tanggal, jadi
        // dipakai tanggal input (created_at).
        $dendas = Denda::query()
            ->where('status', 'lunas')
            ->whereDate('created_at', '>=', $dari)
            ->whereDate('created_at', '<=', $sampai)
            ->with([
                'rental.user:id,name',
                'rental.mobil:id,name,plate_number',
            ])
            ->get();

        // Kompensasi hanya jenis pengembalian_dana (uang keluar nyata);
        // diskon/gratis_sewa tidak menggerakkan kas.
        $kompensasis = Kompensasi::query()
            ->where('jenis', 'pengembalian_dana')
            ->where('status', 'disetujui')
            ->whereBetween('tanggal', [$dari, $sampai])
            ->with([
                'rental.user:id,name',
                'mobil:id,name',
            ])
            ->get();

        $totalPembayaran  = $pembayarans->sum('jumlah');
        $totalDenda       = $dendas->sum('nominal');
        $totalKompensasi  = $kompensasis->sum('nominal');
        $pendapatanBersih = $totalPembayaran + $totalDenda - $totalKompensasi;

        // Breakdown per metode pembayaran — dari collection yang sudah
        // termuat, tanpa query tambahan.
        $perMetode = $pembayarans
            ->groupBy(fn ($p) => $p->metodePembayaran->name ?? 'Lainnya')
            ->map(fn ($group) => [
                'metode' => $group->first()->metodePembayaran->name ?? 'Lainnya',
                'total'  => $group->sum('jumlah'),
                'jumlah' => $group->count(),
            ])
            ->sortByDesc('total')
            ->values();

        // Tren harian: semua tanggal dalam rentang diisi, yang tanpa
        // transaksi bernilai 0 supaya grafik kontinu.
        $perTanggal = collect();

        foreach ($pembayarans as $p) {
            $key = $p->tanggal_bayar->toDateString();
            $perTanggal[$key] = ($perTanggal[$key] ?? 0) + $p->jumlah;
        }

        foreach ($dendas as $d) {
            $key = $d->created_at->toDateString();
            $perTanggal[$key] = ($perTanggal[$key] ?? 0) + $d->nominal;
        }

        foreach ($kompensasis as $k) {
            $key = $k->tanggal instanceof \Carbon\Carbon
                ? $k->tanggal->toDateString()
                : $k->tanggal;
            $perTanggal[$key] = ($perTanggal[$key] ?? 0) - $k->nominal;
        }

        $tren = collect(CarbonPeriod::create($dari, $sampai))
            ->map(fn (\Carbon\Carbon $tgl) => [
                'tanggal' => $tgl->format('d M'),
                'total'   => $perTanggal[$tgl->toDateString()] ?? 0,
            ]);

        return view('laporan.index', [
            'pembayarans'      => $pembayarans,
            'dendas'           => $dendas,
            'kompensasis'      => $kompensasis,
            'totalPembayaran'  => $totalPembayaran,
            'totalDenda'       => $totalDenda,
            'totalKompensasi'  => $totalKompensasi,
            'pendapatanBersih' => $pendapatanBersih,
            'jumlahTransaksi'  => $pembayarans->count() + $dendas->count(),
            'perMetode'        => $perMetode,
            'tren'             => $tren,
            'dari'             => $dari,
            'sampai'           => $sampai,
        ]);
    }
}
