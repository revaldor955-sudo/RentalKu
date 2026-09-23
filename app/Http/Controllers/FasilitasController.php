<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
        public function index()
    {
        $fasilitas = Fasilitas::all();
        return view('fasilitas.index', compact('fasilitas'));
    }

    /**
     * Server-side DataTables: daftar fasilitas (search, sort, pagination)
     */
    public function data(Request $request)
    {
        $query = Fasilitas::query();

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where('fasilitas.name', 'like', "%{$search}%");
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'fasilitas.name',
        ];

        $orderColumn = $request->input('order.0.column', 1);
        $orderDir = $request->input('order.0.dir', 'asc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('fasilitas.name', 'asc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $fasilitas = $query->offset($start)->limit($length)->get();

        $data = $fasilitas->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
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
        ], [
            'name.required' => 'Nama fasilitas wajib diisi',
        ]);

        Fasilitas::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Fasilitas berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

        public function show(Fasilitas $fasilita)
    {
        //
    }

        public function edit(Fasilitas $fasilita)
    {
        //
    }

        public function update(Request $request, Fasilitas $fasilita)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama fasilitas wajib diisi',
        ]);

        $fasilita->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Fasilitas berhasil diperbarui.',
            ]);
        }

        return redirect()->route('fasilitas.index')
            ->with('success', 'Fasilitas berhasil diperbarui.');
    }

        public function destroy(Request $request, Fasilitas $fasilita)
    {
        $fasilita->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Fasilitas berhasil dihapus.',
            ]);
        }

        return redirect()->route('fasilitas.index')
            ->with('success', 'Fasilitas berhasil dihapus.');
    }
}