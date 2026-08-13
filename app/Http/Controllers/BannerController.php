<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();
        return view('banners.index', compact('banners'));
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
            'judul' => 'required|string|max:100',
            'gambar' => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'urutan' => 'nullable|integer|min:0',
        ], [
            'judul.required' => 'Judul wajib diisi',
            'gambar.mimes' => 'Gambar harus berupa gambar (jpg, png, svg)',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
            'status.required' => 'Status wajib dipilih',
        ]);

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/banners'), $imageName);
            $validated['gambar'] = 'images/banners/' . $imageName;
        }

        Banner::create($validated);

        return redirect()->route('banners.index')
            ->with('success', 'Banner berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:100',
            'gambar' => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'urutan' => 'nullable|integer|min:0',
        ], [
            'judul.required' => 'Judul wajib diisi',
            'gambar.mimes' => 'Gambar harus berupa gambar (jpg, png, svg)',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
            'status.required' => 'Status wajib dipilih',
        ]);

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/banners'), $imageName);
            $validated['gambar'] = 'images/banners/' . $imageName;
        }

        $banner->update($validated);

        return redirect()->route('banners.index')
            ->with('success', 'Banner berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('banners.index')
            ->with('success', 'Banner berhasil dihapus.');
    }
}