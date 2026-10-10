<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    public function index()
    {
        return view('cabangs.index')
            ->with('pageTitle', 'Cabang');
    }

    /**
     * DataTables: pencarian, pengurutan, dan pagination.
     * Default: cabang terbaru tampil paling atas.
     */
    public function data(Request $request)
    {
        $query = Cabang::query();

        $recordsTotal = (clone $query)->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('cabangs.name', 'like', "%{$search}%")
                    ->orWhere('cabangs.address', 'like', "%{$search}%")
                    ->orWhere('cabangs.phone', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = (clone $query)->count();

        $columns = [
            0 => null,
            1 => 'cabangs.name',
            2 => 'cabangs.address',
            3 => null,
            4 => null,
        ];

        $orderColumn = $request->input('order.0.column');
        $orderDir = strtolower(
            $request->input('order.0.dir', 'asc')
        ) === 'desc' ? 'desc' : 'asc';

        $hasCustomOrder = false;

        if (
            $orderColumn !== null &&
            isset($columns[(int) $orderColumn]) &&
            $columns[(int) $orderColumn] !== null
        ) {
            $query->orderBy(
                $columns[(int) $orderColumn],
                $orderDir
            );

            $hasCustomOrder = true;
        }

        if ($hasCustomOrder) {
            // Jika nilai pengurutan sama, ID terbaru tetap diutamakan.
            $query->orderByDesc('cabangs.id');
        } else {
            // Pengurutan default: ID terbaru di urutan pertama.
            $query->orderByDesc('cabangs.id');
        }

        $start = max(0, (int) $request->input('start', 0));

        $requestedLength = (int) $request->input('length', 10);
        $length = $requestedLength === -1
            ? 100
            : min(max($requestedLength, 1), 100);

        $cabangs = $query
            ->offset($start)
            ->limit($length)
            ->get();

        $data = $cabangs->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'address' => $item->address,
                'phone' => $item->phone,
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
        return view('cabangs.index')
            ->with('pageTitle', 'Cabang');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Nama cabang wajib diisi.',
            'address.required' => 'Alamat cabang wajib diisi.',
            'address.max' => 'Alamat maksimal 255 karakter.',
        ]);

        Cabang::create($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Cabang berhasil ditambahkan.',
            ], 201);
        }

        return redirect()
            ->route('cabangs.index')
            ->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function show(Cabang $cabang)
    {
        return response()->json($cabang);
    }

    public function edit(Cabang $cabang)
    {
        return response()->json($cabang);
    }

    public function update(Request $request, Cabang $cabang)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Nama cabang wajib diisi.',
            'address.required' => 'Alamat cabang wajib diisi.',
            'address.max' => 'Alamat maksimal 255 karakter.',
        ]);

        $cabang->update($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Cabang berhasil diperbarui.',
            ]);
        }

        return redirect()
            ->route('cabangs.index')
            ->with('success', 'Cabang berhasil diperbarui.');
    }

    public function destroy(Request $request, Cabang $cabang)
    {
        // Jangan hapus cabang yang masih digunakan oleh mobil.
        if ($cabang->mobils()->exists()) {
            $message = 'Cabang tidak dapat dihapus karena masih digunakan oleh mobil.';

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'message' => $message,
                ], 422);
            }

            return redirect()
                ->route('cabangs.index')
                ->with('error', $message);
        }

        $cabang->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Cabang berhasil dihapus.',
            ]);
        }

        return redirect()
            ->route('cabangs.index')
            ->with('success', 'Cabang berhasil dihapus.');
    }
}
