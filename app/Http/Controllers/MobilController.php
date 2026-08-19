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
     * Menampilkan data mobil
     */
    public function index()
    {
        $mobils = Mobil::with(['brand', 'tipeMobil', 'cabang', 'fasilitas'])
            ->latest()
            ->get();

        $brands = Brand::all();
        $tipeMobils = TipeMobil::all();
        $cabangs = Cabang::all();
        $fasilitas = Fasilitas::all();

        if (request()->is('staff/mobils')) {
            return view('staff.mobils.index', compact(
                'mobils',
                'brands',
                'tipeMobils',
                'cabangs',
                'fasilitas'
            ));
        }

        return view('mobils.index', compact(
            'mobils',
            'brands',
            'tipeMobils',
            'cabangs',
            'fasilitas'
        ));
    }

    public function create()
    {
        $brands = Brand::all();
        $tipeMobils = TipeMobil::all();
        $cabangs = Cabang::all();
        $fasilitas = Fasilitas::all();

        return view('staff.mobils.create', compact(
            'brands',
            'tipeMobils',
            'cabangs',
            'fasilitas'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'tipe_mobil_id' => 'required|exists:tipe_mobils,id',
            'cabang_id' => 'required|exists:cabangs,id',
            'name' => 'required|string|max:45',
            'plate_number' => 'required|string|max:10|unique:mobils,plate_number',
            'tahun' => 'required|integer|min:1990|max:'.date('Y'),
            'transmisi' => 'required|in:manual,matic,Manual,Matic',
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

        $validated['transmisi'] = ucfirst(strtolower($validated['transmisi']));

        // Upload gambar
        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time().'_'.$image->getClientOriginalName();

            $image->move(
                public_path('images/mobils'),
                $imageName
            );

            $validated['image'] = 'images/mobils/'.$imageName;
        }

        // Simpan mobil
        $mobil = Mobil::create($validated);

        // Simpan fasilitas
        if ($request->has('fasilitas')) {
            $mobil->fasilitas()->sync($request->fasilitas);
        }

        // Jika Staff
        if ($request->is('staff/mobils')) {
            return redirect()
                ->route('staff.mobils.index')
                ->with('success', 'Mobil berhasil ditambahkan.');
        }

        // Jika Admin
        return redirect()
            ->route('mobils.index')
            ->with('success', 'Mobil berhasil ditambahkan.');
    }

    /**
     * Detail mobil
     */
    public function show(Request $request, $id)
    {
        $mobil = Mobil::with([
            'brand',
            'tipeMobil',
            'cabang',
            'fasilitas',
        ])->findOrFail($id);

        $cabangs = Cabang::orderBy('name')->get();

        // Permintaan AJAX (modal detail mobil di dashboard customer):
        // kembalikan partial view agar tidak reload seluruh halaman.
        if ($request->ajax() || $request->wantsJson()) {
            return view('customer.partials.mobil-detail-modal', compact('mobil', 'cabangs'));
        }

        return view('customer.mobil-detail', compact('mobil', 'cabangs'));
    }

    /**
     * Form edit
     */
    public function edit(Mobil $mobil)
    {
        $brands = Brand::all();
        $tipeMobils = TipeMobil::all();
        $cabangs = Cabang::all();
        $fasilitas = Fasilitas::all();

        $mobil->load([
            'brand',
            'tipeMobil',
            'cabang',
            'fasilitas',
        ]);

        return view('staff.mobils.edit', compact(
            'mobil',
            'brands',
            'tipeMobils',
            'cabangs',
            'fasilitas'
        ));
    }

    /**
     * Update mobil
     */
    public function update(Request $request, Mobil $mobil)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'tipe_mobil_id' => 'required|exists:tipe_mobils,id',
            'cabang_id' => 'required|exists:cabangs,id',
            'name' => 'required|string|max:45',
            'plate_number' => 'required|string|max:10|unique:mobils,plate_number,'.$mobil->id,
            'tahun' => 'required|integer|min:1990|max:'.date('Y'),
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
        ]);

        // Upload foto baru
        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time().'_'.$image->getClientOriginalName();

            $image->move(
                public_path('images/mobils'),
                $imageName
            );

            $validated['image'] = 'images/mobils/'.$imageName;
        }

        // Update data mobil
        $mobil->update($validated);

        // Update fasilitas
        $mobil->fasilitas()->sync(
            $request->input('fasilitas', [])
        );

        // Selalu kembali ke data mobil STAFF
        return redirect()
            ->route('staff.mobils.index')
            ->with('success', 'Mobil berhasil diperbarui.');
    }

    /**
     * Hapus mobil
     */
    public function destroy(Mobil $mobil)
    {
        $mobil->delete();

        return redirect()
            ->route('staff.mobils.index')
            ->with('success', 'Mobil berhasil dihapus.');
    }
}
