<?php

namespace App\Http\Controllers;

use App\Models\TipeMobil;
use Illuminate\Http\Request;

class TipeMobilController extends Controller
{
    public function index()
    {
        return view('tipe_mobils.index');
    }

    /**
     * Server-side DataTables: daftar tipe mobil (search, sort, pagination)
     */
    public function data(Request $request)
    {
        $query = TipeMobil::query();

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where('tipe_mobils.name', 'like', "%{$search}%")
                  ->orWhere('tipe_mobils.description', 'like', "%{$search}%");
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'tipe_mobils.name',
            2 => 'tipe_mobils.description',
        ];

        $orderColumn = $request->input('order.0.column', 1);
        $orderDir = $request->input('order.0.dir', 'asc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('tipe_mobils.name', 'asc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $tipeMobils = $query->offset($start)->limit($length)->get();

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama tipe mobil wajib diisi',
            'name.max' => 'Nama tipe mobil maksimal 255 karakter',
        ]);

        TipeMobil::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Tipe Mobil berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('tipe_mobils.index')
            ->with('success', 'Tipe Mobil berhasil ditambahkan.');
    }

    public function show(TipeMobil $tipeMobil)
    {
        //
    }

    public function edit(TipeMobil $tipeMobil)
    {
        //
    }

    public function update(Request $request, TipeMobil $tipeMobil)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama tipe mobil wajib diisi',
            'name.max' => 'Nama tipe mobil maksimal 255 karakter',
        ]);

        $tipeMobil->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Tipe Mobil berhasil diperbarui.',
            ]);
        }

        return redirect()->route('tipe_mobils.index')
            ->with('success', 'Tipe Mobil berhasil diperbarui.');
    }

    public function destroy(Request $request, TipeMobil $tipeMobil)
    {
        $tipeMobil->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Tipe Mobil berhasil dihapus.',
            ]);
        }

        return redirect()->route('tipe_mobils.index')
            ->with('success', 'Tipe Mobil berhasil dihapus.');
    }
}