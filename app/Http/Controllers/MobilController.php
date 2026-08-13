<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Cabang;
use App\Models\Fasilitas;
use App\Models\Mobil;
use App\Models\TipeMobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mobils = Mobil::all();
        $brands = Brand::all();
        $tipeMobils = TipeMobil::all();
        $cabangs = Cabang::all();
        $fasilitas = Fasilitas::all();

        return view('mobils.index', compact('mobils', 'brands', 'tipeMobils', 'cabangs', 'fasilitas'));
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
            'brand_id' => 'required|exists:brands,id',
            'tipe_mobil_id' => 'required|exists:tipe_mobils,id',
            'cabang_id' => 'required|exists:cabangs,id',
            'name' => 'required|string|max:45',
            'plate_number' => 'required|string|max:10|unique:mobils,plate_number',
            'tahun' => 'required|integer|min:1990|max:' . date('Y'),
            'transmisi' => 'required|in:Manual,Matic',
            'kapasitas' => 'required|integer|min:1',
            'warna' => 'required|string|max:20',
            'harga_perhari' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'image' => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
            'status' => 'required|in:Tersedia,Disewa,Maintenance',
            'description' => 'nullable|string',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'exists:fasilitas,id',
        ], [
            'brand_id.required' => 'Brand wajib dipilih',
            'tipe_mobil_id.required' => 'Tipe mobil wajib dipilih',
            'cabang_id.required' => 'Cabang wajib dipilih',
            'name.required' => 'Nama mobil wajib diisi',
            'name.max' => 'Nama mobil maksimal 45 karakter',
            'plate_number.required' => 'Plat nomor wajib diisi',
            'plate_number.unique' => 'Plat nomor sudah dipakai',
            'tahun.required' => 'Tahun wajib diisi',
            'tahun.integer' => 'Tahun harus berupa angka',
            'transmisi.required' => 'Transmisi wajib dipilih',
            'kapasitas.required' => 'Kapasitas wajib diisi',
            'kapasitas.integer' => 'Kapasitas harus berupa angka',
            'warna.required' => 'Warna wajib diisi',
            'harga_perhari.required' => 'Harga per hari wajib diisi',
            'harga_perhari.numeric' => 'Harga per hari harus berupa angka',
            'deposit.required' => 'Deposit wajib diisi',
            'deposit.numeric' => 'Deposit harus berupa angka',
            'image.mimes' => 'Foto harus berupa gambar (jpg, png, svg)',
            'image.max' => 'Ukuran foto maksimal 2MB',
            'status.required' => 'Status wajib dipilih',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/mobils'), $imageName);
            $validated['image'] = 'images/mobils/' . $imageName;
        }

        $mobil = Mobil::create($validated);

        if ($request->has('fasilitas')) {
            $mobil->fasilitas()->sync($request->fasilitas);
        }

        return redirect()->route('mobils.index')
            ->with('success', 'Mobil berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mobil $mobil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mobil $mobil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mobil $mobil)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'tipe_mobil_id' => 'required|exists:tipe_mobils,id',
            'cabang_id' => 'required|exists:cabangs,id',
            'name' => 'required|string|max:45',
            'plate_number' => 'required|string|max:10|unique:mobils,plate_number,' . $mobil->id,
            'tahun' => 'required|integer|min:1990|max:' . date('Y'),
            'transmisi' => 'required|in:Manual,Matic',
            'kapasitas' => 'required|integer|min:1',
            'warna' => 'required|string|max:20',
            'harga_perhari' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'image' => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
            'status' => 'required|in:Tersedia,Disewa,Maintenance',
            'description' => 'nullable|string',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'exists:fasilitas,id',
        ], [
            'brand_id.required' => 'Brand wajib dipilih',
            'tipe_mobil_id.required' => 'Tipe mobil wajib dipilih',
            'cabang_id.required' => 'Cabang wajib dipilih',
            'name.required' => 'Nama mobil wajib diisi',
            'name.max' => 'Nama mobil maksimal 45 karakter',
            'plate_number.required' => 'Plat nomor wajib diisi',
            'plate_number.unique' => 'Plat nomor sudah dipakai',
            'tahun.required' => 'Tahun wajib diisi',
            'tahun.integer' => 'Tahun harus berupa angka',
            'transmisi.required' => 'Transmisi wajib dipilih',
            'kapasitas.required' => 'Kapasitas wajib diisi',
            'kapasitas.integer' => 'Kapasitas harus berupa angka',
            'warna.required' => 'Warna wajib diisi',
            'harga_perhari.required' => 'Harga per hari wajib diisi',
            'harga_perhari.numeric' => 'Harga per hari harus berupa angka',
            'deposit.required' => 'Deposit wajib diisi',
            'deposit.numeric' => 'Deposit harus berupa angka',
            'image.mimes' => 'Foto harus berupa gambar (jpg, png, svg)',
            'image.max' => 'Ukuran foto maksimal 2MB',
            'status.required' => 'Status wajib dipilih',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/mobils'), $imageName);
            $validated['image'] = 'images/mobils/' . $imageName;
        }

        $mobil->update($validated);

        if ($request->has('fasilitas')) {
            $mobil->fasilitas()->sync($request->fasilitas);
        } else {
            $mobil->fasilitas()->sync([]);
        }

        return redirect()->route('mobils.index')
            ->with('success', 'Mobil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mobil $mobil)
    {
        $mobil->delete();

        return redirect()->route('mobils.index')
            ->with('success', 'Mobil berhasil dihapus.');
    }
}