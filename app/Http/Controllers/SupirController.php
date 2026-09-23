<?php

namespace App\Http\Controllers;

use App\Models\Supir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SupirController extends Controller
{
    public function index()
    {
        $supirs = Supir::latest()->get();

        return view('supirs.index', compact('supirs'));
    }

    public function create()
    {
        return redirect()->route('supirs.index');
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
            'name.required' => 'Nama supir wajib diisi.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.max' => 'Nomor HP maksimal 20 karakter.',
            'image.mimes' => 'Foto harus berupa JPG, JPEG, PNG, atau SVG.',
            'image.max' => 'Ukuran foto maksimal 2 MB.',
            'tarif_perhari.required' => 'Tarif per hari wajib diisi.',
            'tarif_perhari.numeric' => 'Tarif harus berupa angka.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        $this->prepareUploadFolder();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/supirs'), $imageName);
            $validated['image'] = 'images/supirs/' . $imageName;
        }

        Supir::create($validated);

        return redirect()->route('supirs.index')->with('success', 'Supir berhasil ditambahkan.');
    }

    public function show(Supir $supir)
    {
        return redirect()->route('supirs.index');
    }

    public function edit(Supir $supir)
    {
        return redirect()->route('supirs.index');
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
            'name.required' => 'Nama supir wajib diisi.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.max' => 'Nomor HP maksimal 20 karakter.',
            'image.mimes' => 'Foto harus berupa JPG, JPEG, PNG, atau SVG.',
            'image.max' => 'Ukuran foto maksimal 2 MB.',
            'tarif_perhari.required' => 'Tarif per hari wajib diisi.',
            'tarif_perhari.numeric' => 'Tarif harus berupa angka.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        $this->prepareUploadFolder();

        if ($request->hasFile('image')) {

            if ($supir->image) {
                $oldImage = public_path($supir->image);

                if (File::exists($oldImage)) {
                    File::delete($oldImage);
                }
            }

            $image = $request->file('image');

            $imageName = time() . '_' . uniqid() . '.' .
                $image->getClientOriginalExtension();

            $image->move(
                public_path('images/supirs'),
                $imageName
            );

            $validated['image'] = 'images/supirs/' . $imageName;
        }

        $supir->update($validated);

        return redirect()
            ->route('supirs.index')
            ->with('success', 'Data supir berhasil diperbarui.');
    }

    public function destroy(Supir $supir)
    {
        if ($supir->image) {
            $imagePath = public_path($supir->image);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $supir->delete();

        return redirect()
            ->route('supirs.index')
            ->with('success', 'Supir berhasil dihapus.');
    }

    private function prepareUploadFolder()
    {
        $folder = public_path('images/supirs');

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }
    }
}