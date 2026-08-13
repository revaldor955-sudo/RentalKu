<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
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
            'name' => 'required|string|max:50',
            'logo' => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama brand wajib diisi',
            'logo.mimes' => 'Logo harus berupa gambar (jpg, png, svg)',
            'logo.max' => 'Ukuran logo maksimal 2MB',
        ]);

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/brands'), $imageName);
            $validated['logo'] = 'images/brands/' . $imageName;
        }

        Brand::create($validated);

        return redirect()->route('brands.index')
            ->with('success', 'Brand berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama brand wajib diisi',
            'logo.mimes' => 'Logo harus berupa gambar (jpg, png, svg)',
            'logo.max' => 'Ukuran logo maksimal 2MB',
        ]);

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/brands'), $imageName);
            $validated['logo'] = 'images/brands/' . $imageName;
        }

        $brand->update($validated);

        return redirect()->route('brands.index')
            ->with('success', 'Brand berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index')
            ->with('success', 'Brand berhasil dihapus.');
    }
}
