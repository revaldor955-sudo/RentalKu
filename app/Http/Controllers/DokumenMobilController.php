<?php

namespace App\Http\Controllers;

use App\Models\DokumenMobil;
use App\Models\Mobil;
use Illuminate\Http\Request;

class DokumenMobilController extends Controller
{
        public function index()
    {
        $dokumenMobils = DokumenMobil::all();
        $mobils = Mobil::all();
        return view('dokumen_mobils.index', compact('dokumenMobils', 'mobils'));
    }

        public function create()
    {
        //
    }

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

        public function show(DokumenMobil $dokumenMobil)
    {
        //
    }

        public function edit(DokumenMobil $dokumenMobil)
    {
        //
    }

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

        public function destroy(DokumenMobil $dokumenMobil)
    {
        $dokumenMobil->delete();

        return redirect()->route('dokumen_mobils.index')
            ->with('success', 'Dokumen mobil berhasil dihapus.');
    }
}