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

        return view('metode_pembayarans.index', compact('cabangs'))->with('pageTitle', 'Metode Pembayaran');
    }

    public function data(Request $request)
    {
        $query = MetodePembayaran::query()
            ->leftJoin('cabangs', 'metode_pembayarans.cabang_id', '=', 'cabangs.id')
            ->select('metode_pembayarans.*')
            ->with('cabang');

        $recordsTotal = $query->count();

        // Filter pemilik rekening: id cabang, 'pusat', atau semua bila kosong.
        $cabangFilter = $request->input('cabang_id');

        if ($cabangFilter === 'pusat') {
            $query->whereNull('metode_pembayarans.cabang_id');
        } elseif ($cabangFilter !== null && $cabangFilter !== '') {
            $query->where('metode_pembayarans.cabang_id', $cabangFilter);
        }

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('metode_pembayarans.name', 'like', "%{$search}%")
                  ->orWhere('metode_pembayarans.nomor_akun', 'like', "%{$search}%")
                  ->orWhere('metode_pembayarans.atas_nama', 'like', "%{$search}%")
                  ->orWhere('cabangs.name', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'metode_pembayarans.name',
            2 => 'metode_pembayarans.nomor_akun',
            3 => 'cabangs.name',
            4 => 'metode_pembayarans.atas_nama',
        ];

        $orderColumn = $request->input('order.0.column', 1);
        $orderDir = strtolower($request->input('order.0.dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('metode_pembayarans.name', 'asc');
        }

        $start = max(0, (int) $request->input('start', 0));
        $length = min(max((int) $request->input('length', 10), 1), 100);

        $metodePembayarans = $query->offset($start)->limit($length)->get();

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
            'name.required' => 'Nama metode pembayaran wajib diisi',
            'nomor_akun.required' => 'Nomor akun wajib diisi',
            'cabang_id.exists' => 'Cabang tidak valid.',
        ]);

        MetodePembayaran::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Metode pembayaran berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('metode_pembayarans.index')
            ->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function update(Request $request, MetodePembayaran $metodePembayaran)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nomor_akun' => 'required|string|max:255',
            'cabang_id' => 'nullable|exists:cabangs,id',
            'atas_nama' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama metode pembayaran wajib diisi',
            'nomor_akun.required' => 'Nomor akun wajib diisi',
            'cabang_id.exists' => 'Cabang tidak valid.',
        ]);

        $metodePembayaran->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Metode pembayaran berhasil diperbarui.',
            ]);
        }

        return redirect()->route('metode_pembayarans.index')
            ->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    public function destroy(Request $request, MetodePembayaran $metodePembayaran)
    {
        // FK pembayarans.metode_pembayaran_id RESTRICT — tolak dengan 422, bukan 500.
        if ($metodePembayaran->pembayaran()->exists()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Metode pembayaran tidak dapat dihapus karena masih dipakai pembayaran.',
                ], 422);
            }

            return redirect()->route('metode_pembayarans.index')->with('error', 'Metode pembayaran tidak dapat dihapus karena masih dipakai pembayaran.');
        }

        $metodePembayaran->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Metode pembayaran berhasil dihapus.',
            ]);
        }

        return redirect()->route('metode_pembayarans.index')
            ->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}