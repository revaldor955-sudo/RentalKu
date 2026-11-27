<?php

namespace App\Http\Controllers;

use App\Models\TipeMobil;
use Illuminate\Http\Request;

class TipeMobilController extends Controller
{
    /**
     * Menampilkan halaman kelola tipe mobil.
     */
    public function index()
    {
        return view('tipe_mobils.index')
            ->with('pageTitle', 'Tipe Kendaraan');
    }

    /**
     * Data tipe mobil untuk DataTables.
     * Default: data terbaru berada paling atas.
     */
    public function data(Request $request)
    {
        $query = TipeMobil::query();

        $recordsTotal = TipeMobil::count();

        $search = trim((string) $request->input('search.value', ''));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('tipe_mobils.name', 'like', "%{$search}%")
                    ->orWhere(
                        'tipe_mobils.description',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        $recordsFiltered = (clone $query)->count('tipe_mobils.id');

        $columns = [
            0 => null,
            1 => 'tipe_mobils.name',
            2 => 'tipe_mobils.description',
            3 => null,
        ];

        $orders = $request->input('order', []);
        $orderApplied = false;

        foreach ($orders as $order) {
            $columnIndex = (int) ($order['column'] ?? -1);

            if (
                !isset($columns[$columnIndex]) ||
                $columns[$columnIndex] === null
            ) {
                continue;
            }

            $direction = strtolower(
                $order['dir'] ?? 'asc'
            ) === 'desc' ? 'desc' : 'asc';

            $query->orderBy(
                $columns[$columnIndex],
                $direction
            );

            $orderApplied = true;
        }

        // Urutan default: tipe mobil terbaru terlebih dahulu.
        if (!$orderApplied) {
            $query->orderByDesc('tipe_mobils.created_at')
                ->orderByDesc('tipe_mobils.id');
        } else {
            // Jika nilai kolom yang dipilih sama,
            // dahulukan data yang lebih baru.
            $query->orderByDesc('tipe_mobils.created_at')
                ->orderByDesc('tipe_mobils.id');
        }

        $start = max(
            0,
            (int) $request->input('start', 0)
        );

        $requestedLength = (int) $request->input('length', 10);

        $length = $requestedLength === -1
            ? 100
            : min(max($requestedLength, 1), 100);

        $tipeMobils = $query
            ->offset($start)
            ->limit($length)
            ->get();

        $data = $tipeMobils->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function create()
    {
        //
    }

    /**
     * Menambahkan tipe mobil.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama tipe mobil wajib diisi.',
            'name.max' => 'Nama tipe mobil maksimal 255 karakter.',
        ]);

        $tipeMobil = TipeMobil::create($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Tipe mobil berhasil ditambahkan.',
                'id' => $tipeMobil->id,
            ], 201);
        }

        return redirect()
            ->route('tipe_mobils.index')
            ->with('success', 'Tipe mobil berhasil ditambahkan.');
    }

    public function show(TipeMobil $tipeMobil)
    {
        return response()->json([
            'id' => $tipeMobil->id,
            'name' => $tipeMobil->name,
            'description' => $tipeMobil->description,
        ]);
    }

    public function edit(TipeMobil $tipeMobil)
    {
        return view('tipe_mobils.edit', compact('tipeMobil'));
    }

    /**
     * Memperbarui tipe mobil.
     */
    public function update(Request $request, TipeMobil $tipeMobil)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama tipe mobil wajib diisi.',
            'name.max' => 'Nama tipe mobil maksimal 255 karakter.',
        ]);

        $tipeMobil->update($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Tipe mobil berhasil diperbarui.',
            ]);
        }

        return redirect()
            ->route('tipe_mobils.index')
            ->with('success', 'Tipe mobil berhasil diperbarui.');
    }

    /**
     * Menghapus tipe mobil.
     */
    public function destroy(Request $request, TipeMobil $tipeMobil)
    {
        if ($tipeMobil->mobils()->exists()) {
            $message = 'Tipe mobil tidak dapat dihapus karena masih digunakan oleh mobil.';

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'message' => $message,
                ], 422);
            }

            return redirect()
                ->route('tipe_mobils.index')
                ->with('error', $message);
        }

        $tipeMobil->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Tipe mobil berhasil dihapus.',
            ]);
        }

        return redirect()
            ->route('tipe_mobils.index')
            ->with('success', 'Tipe mobil berhasil dihapus.');
    }
}
