<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Server-side DataTables: daftar banner (search, sort, pagination)
     */
    public function data(Request $request)
    {
        $query = Banner::query();

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'judul',
            2 => 'urutan',
            3 => 'status',
        ];

        $orderColumn = $request->input('order.0.column', 0);
        $orderDir = strtolower($request->input('order.0.dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('urutan', 'asc');
        }

        $start = max(0, (int) $request->input('start', 0));
        $length = min(max((int) $request->input('length', 10), 1), 100);

        $banners = $query->offset($start)->limit($length)->get();

        $data = $banners->map(function ($banner) {
            return [
                'id' => $banner->id,
                'judul' => $banner->judul,
                'gambar' => $banner->gambar,
                'description' => $banner->description,
                'link' => $banner->link,
                'status' => $banner->status,
                'urutan' => $banner->urutan,
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
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('banners.index')->with('pageTitle', 'Banner');
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
            'link' => 'nullable|string|max:255',
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

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Banner berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('banners.index')
            ->with('success', 'Banner berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return response()->json($banner);
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
            'link' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
            'urutan' => 'nullable|integer|min:0',
        ], [
            'judul.required' => 'Judul wajib diisi',
            'gambar.mimes' => 'Gambar harus berupa gambar (jpg, png, svg)',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
            'status.required' => 'Status wajib dipilih',
        ]);

        if ($request->hasFile('gambar')) {
            if ($banner->gambar && file_exists(public_path($banner->gambar))) {
                unlink(public_path($banner->gambar));
            }

            $image = $request->file('gambar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/banners'), $imageName);
            $validated['gambar'] = 'images/banners/' . $imageName;
        }

        $banner->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Banner berhasil diperbarui.',
            ]);
        }

        return redirect()->route('banners.index')
            ->with('success', 'Banner berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Banner $banner)
    {
        if ($banner->gambar && file_exists(public_path($banner->gambar))) {
            unlink(public_path($banner->gambar));
        }

        $banner->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Banner berhasil dihapus.',
            ]);
        }

        return redirect()->route('banners.index')
            ->with('success', 'Banner berhasil dihapus.');
    }
}