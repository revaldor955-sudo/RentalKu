<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function index()
    {
        return view('fasilitas.index')
            ->with('pageTitle', 'Fasilitas');
    }

    /**
     * DataTables: pencarian, pengurutan, dan pagination.
     * Urutan default menggunakan ID terbaru.
     */
    public function data(Request $request)
    {
        $query = Fasilitas::query();

        $recordsTotal = (clone $query)->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(
                'fasilitas.name',
                'like',
                "%{$search}%"
            );
        }

        $recordsFiltered = (clone $query)->count();

        $columns = [
            0 => null,
            1 => 'fasilitas.name',
            2 => null,
        ];

        $orderColumn = $request->input('order.0.column');
        $orderDir = strtolower(
            $request->input('order.0.dir', 'asc')
        ) === 'desc' ? 'desc' : 'asc';

        // Gunakan pengurutan kolom jika pengguna memilihnya.
        if (
            $orderColumn !== null &&
            isset($columns[(int) $orderColumn]) &&
            $columns[(int) $orderColumn] !== null
        ) {
            $query->orderBy(
                $columns[(int) $orderColumn],
                $orderDir
            );

            // Jika nilainya sama, prioritaskan ID terbaru.
            $query->orderByDesc('fasilitas.id');
        } else {
            // Default: fasilitas terbaru tampil paling atas.
            $query->orderByDesc('fasilitas.id');
        }

        $start = max(0, (int) $request->input('start', 0));

        $requestedLength = (int) $request->input('length', 10);

        $length = $requestedLength === -1
            ? 100
            : min(max($requestedLength, 1), 100);

        $fasilitas = $query
            ->offset($start)
            ->limit($length)
            ->get();

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
        return view('fasilitas.index')
            ->with('pageTitle', 'Fasilitas');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama fasilitas wajib diisi.',
        ]);

        Fasilitas::create($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Fasilitas berhasil ditambahkan.',
            ], 201);
        }

        return redirect()
            ->route('fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function show(Fasilitas $fasilita)
    {
        return response()->json($fasilita);
    }

    public function edit(Fasilitas $fasilita)
    {
        return response()->json($fasilita);
    }

    public function update(Request $request, Fasilitas $fasilita)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama fasilitas wajib diisi.',
        ]);

        $fasilita->update($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Fasilitas berhasil diperbarui.',
            ]);
        }

        return redirect()
            ->route('fasilitas.index')
            ->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Request $request, Fasilitas $fasilita)
    {
        $fasilita->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Fasilitas berhasil dihapus.',
            ]);
        }

        return redirect()
            ->route('fasilitas.index')
            ->with('success', 'Fasilitas berhasil dihapus.');
    }
}
