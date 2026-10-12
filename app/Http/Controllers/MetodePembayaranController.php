<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;

class MetodePembayaranController extends Controller
{
    public function index()
    {
        $cabangs = Cabang::orderBy('name')->get();

        return view('metode_pembayarans.index', compact('cabangs'))
            ->with('pageTitle', 'Metode Pembayaran');
    }

    public function data(Request $request)
    {
        $query = MetodePembayaran::query()
            ->leftJoin(
                'cabangs',
                'metode_pembayarans.cabang_id',
                '=',
                'cabangs.id'
            )
            ->select('metode_pembayarans.*')
            ->with('cabang');

        // Jumlah seluruh data sebelum filter dan pencarian.
        $recordsTotal = MetodePembayaran::count();

        // Filter berdasarkan pemilik rekening.
        $cabangFilter = $request->input('cabang_id');

        if ($cabangFilter === 'pusat') {
            $query->whereNull('metode_pembayarans.cabang_id');
        } elseif ($cabangFilter !== null && $cabangFilter !== '') {
            $query->where(
                'metode_pembayarans.cabang_id',
                $cabangFilter
            );
        }

        // Pencarian data.
        $search = trim((string) $request->input('search.value', ''));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where(
                    'metode_pembayarans.name',
                    'like',
                    "%{$search}%"
                )
                    ->orWhere(
                        'metode_pembayarans.nomor_akun',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'metode_pembayarans.atas_nama',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'cabangs.name',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        // Hitung data setelah filter dan pencarian.
        $recordsFiltered = (clone $query)
            ->count('metode_pembayarans.id');

        // Kolom yang bisa diurutkan dari DataTables.
        $columns = [
            0 => null,
            1 => 'metode_pembayarans.name',
            2 => 'metode_pembayarans.nomor_akun',
            3 => 'cabangs.name',
            4 => 'metode_pembayarans.atas_nama',
            5 => null,
        ];

        $orderColumn = $request->input('order.0.column');
        $orderDir = strtolower(
            (string) $request->input('order.0.dir', 'desc')
        ) === 'asc' ? 'asc' : 'desc';

        if (
            $orderColumn !== null &&
            isset($columns[$orderColumn]) &&
            $columns[$orderColumn] !== null
        ) {
            // Jika pengguna memilih kolom, ikuti pengurutan tersebut.
            $query->orderBy($columns[$orderColumn], $orderDir);

            // Jika nilainya sama, data dengan ID terbaru didahulukan.
            $query->orderByDesc('metode_pembayarans.id');
        } else {
            // Pengurutan default: data terbaru berada paling atas.
            $query->orderByDesc('metode_pembayarans.id');
        }

        // Pagination DataTables.
        $start = max(0, (int) $request->input('start', 0));
        $length = (int) $request->input('length', 10);

        if ($length < 1) {
            $length = 10;
        }

        $length = min($length, 100);

        $metodePembayarans = $query
            ->offset($start)
            ->limit($length)
            ->get();

        // Format data untuk DataTables.
        $data = $metodePembayarans->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'nomor_akun' => $item->nomor_akun,
                'cabang_id' => $item->cabang_id,
                'cabang_name' => $item->cabang->name ?? 'Pusat',
                'atas_nama' => $item->atas_nama ?? '-',
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nomor_akun' => 'required|string|max:255',
            'cabang_id' => 'nullable|exists:cabangs,id',
            'atas_nama' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama metode pembayaran wajib diisi.',
            'nomor_akun.required' => 'Nomor akun wajib diisi.',
            'cabang_id.exists' => 'Cabang tidak valid.',
        ]);

        MetodePembayaran::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Metode pembayaran berhasil ditambahkan.',
            ], 201);
        }

        return redirect()
            ->route('metode_pembayarans.index')
            ->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function update(
        Request $request,
        MetodePembayaran $metodePembayaran
    ) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nomor_akun' => 'required|string|max:255',
            'cabang_id' => 'nullable|exists:cabangs,id',
            'atas_nama' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama metode pembayaran wajib diisi.',
            'nomor_akun.required' => 'Nomor akun wajib diisi.',
            'cabang_id.exists' => 'Cabang tidak valid.',
        ]);

        $metodePembayaran->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Metode pembayaran berhasil diperbarui.',
            ]);
        }

        return redirect()
            ->route('metode_pembayarans.index')
            ->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    public function destroy(
        Request $request,
        MetodePembayaran $metodePembayaran
    ) {
        // Jangan hapus metode pembayaran yang masih digunakan.
        if ($metodePembayaran->pembayaran()->exists()) {
            $message = 'Metode pembayaran tidak dapat dihapus karena masih dipakai pembayaran.';

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => $message,
                ], 422);
            }

            return redirect()
                ->route('metode_pembayarans.index')
                ->with('error', $message);
        }

        $metodePembayaran->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Metode pembayaran berhasil dihapus.',
            ]);
        }

        return redirect()
            ->route('metode_pembayarans.index')
            ->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}
