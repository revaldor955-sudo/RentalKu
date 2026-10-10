<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    /**
     * Menampilkan halaman kelola merek.
     */
    public function index()
    {
        return view('brands.index')
            ->with('pageTitle', 'Merek');
    }

    /**
     * Data merek untuk DataTables.
     * Pengurutan default: merek terbaru berada paling atas.
     */
    public function data(Request $request)
    {
        $query = Brand::query()->withCount('mobils');

        // Total semua merek sebelum pencarian.
        $recordsTotal = Brand::count();

        // Pencarian merek.
        $search = trim((string) $request->input('search.value', ''));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('brands.name', 'like', "%{$search}%")
                    ->orWhere(
                        'brands.description',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        // Total merek setelah pencarian.
        $recordsFiltered = (clone $query)->count('brands.id');

        // Kolom yang boleh digunakan untuk pengurutan.
        $columns = [
            0 => null, // Nomor
            1 => null, // Logo
            2 => 'brands.name',
            3 => 'brands.description',
            4 => null, // Jumlah mobil
            5 => null, // Aksi
        ];

        $orders = $request->input('order', []);
        $orderApplied = false;

        // Jika pengguna memilih pengurutan kolom,
        // gunakan pilihan tersebut.
        foreach ($orders as $order) {
            $columnIndex = (int) ($order['column'] ?? -1);

            if (
                !isset($columns[$columnIndex]) ||
                $columns[$columnIndex] === null
            ) {
                continue;
            }

            $direction = strtolower(
                $order['dir'] ?? 'asc'
            ) === 'desc' ? 'desc' : 'asc';

            $query->orderBy(
                $columns[$columnIndex],
                $direction
            );

            $orderApplied = true;
        }

        // Pengurutan default: merek terbaru lebih dahulu.
        if (!$orderApplied) {
            $query->orderByDesc('brands.created_at')
                ->orderByDesc('brands.id');
        } else {
            // Jika nilai kolom yang diurutkan sama,
            // dahulukan merek yang lebih baru.
            $query->orderByDesc('brands.created_at')
                ->orderByDesc('brands.id');
        }

        // Pagination.
        $start = max(
            0,
            (int) $request->input('start', 0)
        );

        $requestedLength = (int) $request->input('length', 10);

        $length = $requestedLength === -1
            ? 100
            : min(max($requestedLength, 1), 100);

        $brands = $query
            ->offset($start)
            ->limit($length)
            ->get();

        // Data yang dikirim ke DataTables.
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
     * Detail merek untuk modal edit.
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
     * Menyimpan merek baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:brands,name',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Nama merek wajib diisi.',
            'name.unique' => 'Nama merek sudah digunakan.',
            'name.max' => 'Nama merek maksimal 50 karakter.',
            'logo.image' => 'Logo harus berupa gambar.',
            'logo.mimes' => 'Logo harus berformat JPG, JPEG, PNG, atau SVG.',
            'logo.max' => 'Ukuran logo maksimal 2 MB.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
        ]);

        // Pastikan folder penyimpanan logo tersedia.
        $directory = public_path('images/brands');

        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Upload logo jika pengguna memilih file.
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = time() . '_' . $image->hashName();

            $image->move($directory, $imageName);

            $validated['logo'] = 'images/brands/' . $imageName;
        }

        $brand = Brand::create($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Merek berhasil ditambahkan.',
                'id' => $brand->id,
            ], 201);
        }

        return redirect()
            ->route('brands.index')
            ->with('success', 'Merek berhasil ditambahkan.');
    }

    /**
     * Memperbarui merek.
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:brands,name,' . $brand->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Nama merek wajib diisi.',
            'name.unique' => 'Nama merek sudah digunakan.',
            'name.max' => 'Nama merek maksimal 50 karakter.',
            'logo.image' => 'Logo harus berupa gambar.',
            'logo.mimes' => 'Logo harus berformat JPG, JPEG, PNG, atau SVG.',
            'logo.max' => 'Ukuran logo maksimal 2 MB.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
        ]);

        // Pastikan folder logo tersedia.
        $directory = public_path('images/brands');

        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Ganti logo jika ada file baru.
        if ($request->hasFile('logo')) {
            if (
                $brand->logo &&
                File::exists(public_path($brand->logo))
            ) {
                File::delete(public_path($brand->logo));
            }

            $image = $request->file('logo');
            $imageName = time() . '_' . $image->hashName();

            $image->move($directory, $imageName);

            $validated['logo'] = 'images/brands/' . $imageName;
        }

        $brand->update($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Merek berhasil diperbarui.',
            ]);
        }

        return redirect()
            ->route('brands.index')
            ->with('success', 'Merek berhasil diperbarui.');
    }

    /**
     * Menghapus merek.
     */
    public function destroy(Request $request, Brand $brand)
    {
        // Cegah penghapusan jika merek masih digunakan mobil.
        if ($brand->mobils()->exists()) {
            $message = 'Merek tidak dapat dihapus karena masih digunakan oleh mobil.';

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'message' => $message,
                ], 422);
            }

            return redirect()
                ->route('brands.index')
                ->with('error', $message);
        }

        // Hapus logo dari folder jika ada.
        if (
            $brand->logo &&
            File::exists(public_path($brand->logo))
        ) {
            File::delete(public_path($brand->logo));
        }

        $brand->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Merek berhasil dihapus.',
            ]);
        }

        return redirect()
            ->route('brands.index')
            ->with('success', 'Merek berhasil dihapus.');
    }
}
