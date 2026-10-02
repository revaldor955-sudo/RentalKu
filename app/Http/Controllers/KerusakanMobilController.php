<?php

namespace App\Http\Controllers;

use App\Models\KerusakanMobil;
use Illuminate\Http\Request;

class KerusakanMobilController extends Controller
{
    public function index()
    {
        return view('kerusakan_mobils.index');
    }

    public function data(Request $request)
    {
        $query = KerusakanMobil::query();

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where('kerusakan_mobils.jenis_kerusakan', 'like', "%{$search}%")
                  ->orWhere('kerusakan_mobils.description', 'like', "%{$search}%");
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'kerusakan_mobils.jenis_kerusakan',
            2 => 'kerusakan_mobils.description',
        ];

        $orderColumn = $request->input('order.0.column', 1);
        $orderDir = $request->input('order.0.dir', 'asc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('kerusakan_mobils.jenis_kerusakan', 'asc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $kerusakanMobils = $query->offset($start)->limit($length)->get();

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
            'jenis_kerusakan' => 'required|in:Mesin,Ban,Body,Interior,Rem,Kelistrikan,AC,Transmisi,Suspensi,Kaca,Lainnya',
            'description' => 'nullable|string',
        ], [
            'jenis_kerusakan.required' => 'Jenis kerusakan wajib diisi',
        ]);

        KerusakanMobil::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Kerusakan mobil berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('kerusakan_mobils.index')
            ->with('success', 'Kerusakan mobil berhasil ditambahkan.');
    }

    public function update(Request $request, KerusakanMobil $kerusakanMobil)
    {
        $validated = $request->validate([
            'jenis_kerusakan' => 'required|in:Mesin,Ban,Body,Interior,Rem,Kelistrikan,AC,Transmisi,Suspensi,Kaca,Lainnya',
            'description' => 'nullable|string',
        ], [
            'jenis_kerusakan.required' => 'Jenis kerusakan wajib diisi',
        ]);

        $kerusakanMobil->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Kerusakan mobil berhasil diperbarui.',
            ]);
        }

        return redirect()->route('kerusakan_mobils.index')
            ->with('success', 'Kerusakan mobil berhasil diperbarui.');
    }

    public function destroy(Request $request, KerusakanMobil $kerusakanMobil)
    {
        $kerusakanMobil->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Kerusakan mobil berhasil dihapus.',
            ]);
        }

        return redirect()->route('kerusakan_mobils.index')
            ->with('success', 'Kerusakan mobil berhasil dihapus.');
    }
}