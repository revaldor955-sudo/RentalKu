<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Menampilkan semua brand
     */
    public function index()
    {
        return view('brands.index')->with('pageTitle', 'Merek');
    }

    /**
     * Server-side DataTables: daftar brand (search, sort, pagination)
     */
    public function data(Request $request)
    {
        $query = Brand::query()->withCount('mobils');

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('brands.name', 'like', "%{$search}%")
                    ->orWhere('brands.description', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'brands.name',
            2 => 'brands.description',
        ];

        $orderColumn = $request->input('order.0.column', 1);
        $orderDir = strtolower($request->input('order.0.dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('brands.name', 'asc');
        }

        $start = max(0, (int) $request->input('start', 0));
        $length = min(max((int) $request->input('length', 10), 1), 100);

        $brands = $query->offset($start)->limit($length)->get();

        $data = $brands->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name,
                'logo' => $brand->logo,
                'description' => $brand->description,
                'mobils_count' => $brand->mobils_count,
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    /**
     * Detail brand untuk edit modal (AJAX)
     */
    public function show(Brand $brand)
    {
        return response()->json([
            'id' => $brand->id,
            'name' => $brand->name,
            'logo' => $brand->logo,
            'description' => $brand->description,
            'mobils_count' => $brand->mobils()->count(),
        ]);
    }

    /**
     * Menyimpan brand baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:brands,name',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Nama brand wajib diisi.',
            'name.unique' => 'Nama brand sudah digunakan.',
            'name.max' => 'Nama brand maksimal 50 karakter.',
            'logo.image' => 'Logo harus berupa gambar.',
            'logo.mimes' => 'Logo harus berformat JPG, JPEG, PNG, atau SVG.',
            'logo.max' => 'Ukuran logo maksimal 2 MB.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
        ]);

        if ($request->hasFile('logo')) {

            $image = $request->file('logo');

            $imageName = time() . '_' . $image->getClientOriginalName();

            $image->move(
                public_path('images/brands'),
                $imageName
            );

            $validated['logo'] = 'images/brands/' . $imageName;
        }

        Brand::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Brand berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('brands.index')->with('success', 'Brand berhasil ditambahkan.');
    }

    /**
     * Memperbarui brand
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:brands,name,' . $brand->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Nama brand wajib diisi.',
            'name.unique' => 'Nama brand sudah digunakan.',
            'name.max' => 'Nama brand maksimal 50 karakter.',
            'logo.image' => 'Logo harus berupa gambar.',
            'logo.mimes' => 'Logo harus berformat JPG, JPEG, PNG, atau SVG.',
            'logo.max' => 'Ukuran logo maksimal 2 MB.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
        ]);

        if ($request->hasFile('logo')) {

            // Hapus logo lama
            if (
                $brand->logo &&
                file_exists(public_path($brand->logo))
            ) {
                unlink(public_path($brand->logo));
            }

            $image = $request->file('logo');

            $imageName = time() . '_' . $image->getClientOriginalName();

            $image->move(
                public_path('images/brands'),
                $imageName
            );

            $validated['logo'] = 'images/brands/' . $imageName;
        }

        $brand->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Brand berhasil diperbarui.',
            ]);
        }

        return redirect()->route('brands.index')->with('success', 'Brand berhasil diperbarui.');
    }

    /**
     * Menghapus brand
     */
    public function destroy(Request $request, Brand $brand)
    {
        // Cegah penghapusan jika masih digunakan mobil
        if ($brand->mobils()->exists()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Brand tidak dapat dihapus karena masih digunakan oleh mobil.',
                ], 422);
            }

            return redirect()->route('brands.index')->with('error', 'Brand tidak dapat dihapus karena masih digunakan oleh mobil.');
            }

        if (
            $brand->logo &&
            file_exists(public_path($brand->logo))
        ) {
            unlink(public_path($brand->logo));
        }

        $brand->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Brand berhasil dihapus.',
            ]);
        }

        return redirect()->route('brands.index')->with('success', 'Brand berhasil dihapus.');
    }
}