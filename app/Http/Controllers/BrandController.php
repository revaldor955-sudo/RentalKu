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
        $brands = Brand::latest()->get();

        return view('brands.index', compact('brands'));
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

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand berhasil ditambahkan.');
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

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand berhasil diperbarui.');
    }

    /**
     * Menghapus brand
     */
    public function destroy(Brand $brand)
    {
        // Cegah penghapusan jika masih digunakan mobil
        if ($brand->mobils()->exists()) {
            return redirect()
                ->route('brands.index')
                ->with('error', 'Brand tidak dapat dihapus karena masih digunakan oleh mobil.');
        }

        if (
            $brand->logo &&
            file_exists(public_path($brand->logo))
        ) {
            unlink(public_path($brand->logo));
        }

        $brand->delete();

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand berhasil dihapus.');
    }
}