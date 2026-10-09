<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    public function index()
    {
        return view('cabangs.index')->with('pageTitle', 'Cabang');
    }

    /**
     * Server-side DataTables: daftar cabang (search, sort, pagination)
     */
    public function data(Request $request)
    {
        $query = Cabang::query();

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('cabangs.name', 'like', "%{$search}%")
                  ->orWhere('cabangs.address', 'like', "%{$search}%")
                  ->orWhere('cabangs.phone', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'cabangs.name',
            2 => 'cabangs.address',
            3 => 'cabangs.phone',
        ];

        $orderColumn = $request->input('order.0.column', 1);
        $orderDir = strtolower($request->input('order.0.dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('cabangs.name', 'asc');
        }

        $start = max(0, (int) $request->input('start', 0));
        $length = min(max((int) $request->input('length', 10), 1), 100);

        $cabangs = $query->offset($start)->limit($length)->get();

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Nama cabang wajib diisi',
            'address.required' => 'Alamat cabang wajib diisi',
            'address.max' => 'Alamat maksimal 255 karakter',
        ]);

        Cabang::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Cabang berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('cabangs.index')
            ->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function show(Cabang $cabang)
    {
        //
    }

    public function edit(Cabang $cabang)
    {
        //
    }

    public function update(Request $request, Cabang $cabang)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Nama cabang wajib diisi',
            'address.required' => 'Alamat cabang wajib diisi',
            'address.max' => 'Alamat maksimal 255 karakter',
        ]);

        $cabang->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Cabang berhasil diperbarui.',
            ]);
        }

        return redirect()->route('cabangs.index')
            ->with('success', 'Cabang berhasil diperbarui.');
    }

    public function destroy(Request $request, Cabang $cabang)
    {
        // Cegah penghapusan jika masih dipakai mobil (cascade akan hapus riwayat cabang).
        if ($cabang->mobils()->exists()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Cabang tidak dapat dihapus karena masih digunakan oleh mobil.',
                ], 422);
            }

            return redirect()->route('cabangs.index')->with('error', 'Cabang tidak dapat dihapus karena masih digunakan oleh mobil.');
        }

        $cabang->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Cabang berhasil dihapus.',
            ]);
        }

        return redirect()->route('cabangs.index')
            ->with('success', 'Cabang berhasil dihapus.');
    }
}