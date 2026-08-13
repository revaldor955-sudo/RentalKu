<?php

namespace App\Http\Controllers;

use App\Models\DokumenMobil;
use App\Models\Mobil;
use Illuminate\Http\Request;

class DokumenMobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokumenMobils = DokumenMobil::all();
        $mobils = Mobil::all();
        return view('dokumen_mobils.index', compact('dokumenMobils', 'mobils'));
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
            'mobil_id' => 'required|exists:mobils,id',
            'jenis' => 'required|in:stnk,asuransi,bpkb',
            'nomor_dokumen' => 'required|string|max:50',
            'berlaku_sampai' => 'required|date',
            'file' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
        ], [
            'mobil_id.required' => 'Mobil wajib dipilih',
            'jenis.required' => 'Jenis dokumen wajib dipilih',
            'nomor_dokumen.required' => 'Nomor dokumen wajib diisi',
            'berlaku_sampai.required' => 'Berlaku sampai wajib diisi',
            'file.mimes' => 'File harus berupa gambar atau pdf',
            'file.max' => 'Ukuran file maksimal 2MB',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/dokumen_mobils'), $fileName);
            $validated['file'] = 'images/dokumen_mobils/' . $fileName;
        }

        DokumenMobil::create($validated);

        return redirect()->route('dokumen_mobils.index')
            ->with('success', 'Dokumen mobil berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DokumenMobil $dokumenMobil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DokumenMobil $dokumenMobil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DokumenMobil $dokumenMobil)
    {
        $validated = $request->validate([
            'mobil_id' => 'required|exists:mobils,id',
            'jenis' => 'required|in:stnk,asuransi,bpkb',
            'nomor_dokumen' => 'required|string|max:50',
            'berlaku_sampai' => 'required|date',
            'file' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
        ], [
            'mobil_id.required' => 'Mobil wajib dipilih',
            'jenis.required' => 'Jenis dokumen wajib dipilih',
            'nomor_dokumen.required' => 'Nomor dokumen wajib diisi',
            'berlaku_sampai.required' => 'Berlaku sampai wajib diisi',
            'file.mimes' => 'File harus berupa gambar atau pdf',
            'file.max' => 'Ukuran file maksimal 2MB',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/dokumen_mobils'), $fileName);
            $validated['file'] = 'images/dokumen_mobils/' . $fileName;
        }

        $dokumenMobil->update($validated);

        return redirect()->route('dokumen_mobils.index')
            ->with('success', 'Dokumen mobil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DokumenMobil $dokumenMobil)
    {
        $dokumenMobil->delete();

        return redirect()->route('dokumen_mobils.index')
            ->with('success', 'Dokumen mobil berhasil dihapus.');
    }
}