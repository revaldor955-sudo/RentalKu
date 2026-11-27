<?php

namespace App\Http\Controllers;

use App\Models\KerusakanMobil;
use Illuminate\Http\Request;

class KerusakanMobilController extends Controller
{
    public function index()
    {
        return view('kerusakan_mobils.index')
            ->with('pageTitle', 'Kerusakan Kendaraan');
    }

    public function data(Request $request)
    {
        $query = KerusakanMobil::query();

        // Jumlah seluruh data sebelum pencarian.
        $recordsTotal = KerusakanMobil::count();

        // Pencarian data.
        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where(
                    'kerusakan_mobils.jenis_kerusakan',
                    'like',
                    "%{$search}%"
                )->orWhere(
                    'kerusakan_mobils.description',
                    'like',
                    "%{$search}%"
                );
            });
        }

        // Jumlah data setelah pencarian.
        $recordsFiltered = (clone $query)->count();

        // Pemetaan kolom DataTables.
        $columns = [
            0 => null, // Nomor
            1 => 'kerusakan_mobils.jenis_kerusakan',
            2 => 'kerusakan_mobils.description',
            3 => null, // Aksi
        ];

        $orderColumn = $request->input('order.0.column');
        $orderDir = strtolower(
            $request->input('order.0.dir', 'desc')
        ) === 'asc' ? 'asc' : 'desc';

        // Jika pengguna memilih pengurutan kolom, ikuti pilihannya.
        if (
            $orderColumn !== null &&
            isset($columns[$orderColumn]) &&
            $columns[$orderColumn]
        ) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            // Default: data terbaru tampil paling atas.
            $query->orderByDesc('kerusakan_mobils.id');
        }

        // Jika nilai pengurutan sama, ID terbesar tetap didahulukan.
        $query->orderByDesc('kerusakan_mobils.id');

        // Pagination DataTables.
        $start = max(0, (int) $request->input('start', 0));

        $length = (int) $request->input('length', 10);
        $length = min(max($length, 1), 100);

        $kerusakanMobils = $query
            ->offset($start)
            ->limit($length)
            ->get();

        // Siapkan data JSON untuk DataTables.
        $data = $kerusakanMobils->map(function ($item) {
            return [
                'id' => $item->id,
                'jenis_kerusakan' => $item->jenis_kerusakan,
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_kerusakan' => [
                'required',
                'in:Mesin,Ban,Body,Interior,Rem,Kelistrikan,AC,Transmisi,Suspensi,Kaca,Lainnya',
            ],
            'description' => 'nullable|string',
        ], [
            'jenis_kerusakan.required' => 'Jenis kerusakan wajib diisi.',
            'jenis_kerusakan.in' => 'Jenis kerusakan yang dipilih tidak valid.',
        ]);

        KerusakanMobil::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Kerusakan mobil berhasil ditambahkan.',
            ], 201);
        }

        return redirect()
            ->route('kerusakan_mobils.index')
            ->with('success', 'Kerusakan mobil berhasil ditambahkan.');
    }

    public function update(
        Request $request,
        KerusakanMobil $kerusakanMobil
    ) {
        $validated = $request->validate([
            'jenis_kerusakan' => [
                'required',
                'in:Mesin,Ban,Body,Interior,Rem,Kelistrikan,AC,Transmisi,Suspensi,Kaca,Lainnya',
            ],
            'description' => 'nullable|string',
        ], [
            'jenis_kerusakan.required' => 'Jenis kerusakan wajib diisi.',
            'jenis_kerusakan.in' => 'Jenis kerusakan yang dipilih tidak valid.',
        ]);

        $kerusakanMobil->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Kerusakan mobil berhasil diperbarui.',
            ]);
        }

        return redirect()
            ->route('kerusakan_mobils.index')
            ->with('success', 'Kerusakan mobil berhasil diperbarui.');
    }

    public function destroy(
        Request $request,
        KerusakanMobil $kerusakanMobil
    ) {
        $kerusakanMobil->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Kerusakan mobil berhasil dihapus.',
            ]);
        }

        return redirect()
            ->route('kerusakan_mobils.index')
            ->with('success', 'Kerusakan mobil berhasil dihapus.');
    }
}
