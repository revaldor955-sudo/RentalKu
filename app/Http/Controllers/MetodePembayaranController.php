<?php

namespace App\Http\Controllers;

use App\Models\MetodePembayaran;
use Illuminate\Http\Request;

class MetodePembayaranController extends Controller
{
    public function index()
    {
        return view('metode_pembayarans.index');
    }

    public function data(Request $request)
    {
        $query = MetodePembayaran::query();

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where('metode_pembayarans.name', 'like', "%{$search}%")
                  ->orWhere('metode_pembayarans.nomor_akun', 'like', "%{$search}%");
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'metode_pembayarans.name',
            2 => 'metode_pembayarans.nomor_akun',
        ];

        $orderColumn = $request->input('order.0.column', 1);
        $orderDir = $request->input('order.0.dir', 'asc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('metode_pembayarans.name', 'asc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $metodePembayarans = $query->offset($start)->limit($length)->get();

        $data = $metodePembayarans->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'nomor_akun' => $item->nomor_akun,
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
        ], [
            'name.required' => 'Nama metode pembayaran wajib diisi',
            'nomor_akun.required' => 'Nomor akun wajib diisi',
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
        ], [
            'name.required' => 'Nama metode pembayaran wajib diisi',
            'nomor_akun.required' => 'Nomor akun wajib diisi',
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