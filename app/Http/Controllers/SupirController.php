<?php

namespace App\Http\Controllers;

use App\Models\Supir;
use Illuminate\Http\Request;

class SupirController extends Controller
{
    public function index()
    {
        return view('supirs.index');
    }

    /**
     * Server-side DataTables: daftar supir (search, sort, pagination)
     */
    public function data(Request $request)
    {
        $query = Supir::query();

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where('supirs.name', 'like', "%{$search}%")
                  ->orWhere('supirs.phone', 'like', "%{$search}%");
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'supirs.name',
            2 => 'supirs.phone',
            3 => 'supirs.image',
            4 => 'supirs.tarif_perhari',
            5 => 'supirs.status',
        ];

        $orderColumn = $request->input('order.0.column', 1);
        $orderDir = $request->input('order.0.dir', 'asc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('supirs.name', 'asc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $supirs = $query->offset($start)->limit($length)->get();

        $data = $supirs->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'phone' => $item->phone,
                'image' => $item->image,
                'tarif_perhari' => $item->tarif_perhari,
                'status' => $item->status,
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
            'phone' => 'required|string|max:20',
            'image' => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
            'tarif_perhari' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,tidak tersedia',
        ], [
            'name.required' => 'Nama supir wajib diisi',
            'phone.required' => 'Nomor HP wajib diisi',
            'phone.max' => 'Nomor HP maksimal 20 karakter',
            'image.mimes' => 'Foto harus berupa gambar (jpg, png, svg)',
            'image.max' => 'Ukuran foto maksimal 2MB',
            'tarif_perhari.required' => 'Tarif per hari wajib diisi',
            'tarif_perhari.numeric' => 'Tarif per hari harus berupa angka',
            'status.required' => 'Status wajib dipilih',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/supirs'), $imageName);
            $validated['image'] = 'images/supirs/' . $imageName;
        }

        Supir::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Supir berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('supirs.index')
            ->with('success', 'Supir berhasil ditambahkan.');
    }

    public function show(Supir $supir)
    {
        //
    }

    public function edit(Supir $supir)
    {
        //
    }

    public function update(Request $request, Supir $supir)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'image' => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
            'tarif_perhari' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,tidak tersedia',
        ], [
            'name.required' => 'Nama supir wajib diisi',
            'phone.required' => 'Nomor HP wajib diisi',
            'phone.max' => 'Nomor HP maksimal 20 karakter',
            'image.mimes' => 'Foto harus berupa gambar (jpg, png, svg)',
            'image.max' => 'Ukuran foto maksimal 2MB',
            'tarif_perhari.required' => 'Tarif per hari wajib diisi',
            'tarif_perhari.numeric' => 'Tarif per hari harus berupa angka',
            'status.required' => 'Status wajib dipilih',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/supirs'), $imageName);
            $validated['image'] = 'images/supirs/' . $imageName;
        }

        $supir->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Supir berhasil diperbarui.',
            ]);
        }

        return redirect()->route('supirs.index')
            ->with('success', 'Supir berhasil diperbarui.');
    }

    public function destroy(Request $request, Supir $supir)
    {
        $supir->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Supir berhasil dihapus.',
            ]);
        }

        return redirect()->route('supirs.index')
            ->with('success', 'Supir berhasil dihapus.');
    }
}