<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Cabang;
use App\Models\Fasilitas;
use App\Models\Mobil;
use App\Models\Supir;
use App\Models\TipeMobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MobilController extends Controller
{
    /**
     * Menampilkan halaman kelola mobil.
     */
    public function index()
    {
        $mobils = Mobil::with([
            'brand',
            'tipeMobil',
            'cabang',
            'fasilitas',
        ])
            ->orderByDesc('created_at')
            ->orderByDesc('id')
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
            ))->with('pageTitle', 'Kelola Kendaraan');
        }

        return view('mobils.index', compact(
            'mobils',
            'brands',
            'tipeMobils',
            'cabangs',
            'fasilitas'
        ))->with('pageTitle', 'Kelola Kendaraan');
    }

    /**
     * Data mobil untuk DataTables.
     * Default: mobil terbaru berada di urutan paling atas.
     */
    public function data(Request $request)
    {
        $query = Mobil::query()
            ->leftJoin('brands', 'mobils.brand_id', '=', 'brands.id')
            ->leftJoin(
                'tipe_mobils',
                'mobils.tipe_mobil_id',
                '=',
                'tipe_mobils.id'
            )
            ->leftJoin(
                'cabangs',
                'mobils.cabang_id',
                '=',
                'cabangs.id'
            )
            ->select(
                'mobils.*',
                'brands.name as brand_name',
                'tipe_mobils.name as tipe_name',
                'cabangs.name as cabang_name'
            )
            ->withCount('fasilitas')
            ->with('fasilitas');

        // Jumlah semua mobil sebelum pencarian.
        $recordsTotal = Mobil::count();

        // Pencarian DataTables.
        $search = trim((string) $request->input('search.value', ''));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('mobils.name', 'like', "%{$search}%")
                    ->orWhere(
                        'mobils.plate_number',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'mobils.tahun',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'mobils.transmisi',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'mobils.warna',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'mobils.status',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere('brands.name', 'like', "%{$search}%")
                    ->orWhere(
                        'tipe_mobils.name',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'cabangs.name',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        // Jumlah mobil setelah pencarian.
        $recordsFiltered = (clone $query)
            ->count('mobils.id');

        // Kolom yang boleh diurutkan.
        $columns = [
            0 => null, // Nomor urut
            1 => 'mobils.name',
            2 => 'brands.name',
            3 => 'tipe_mobils.name',
            4 => 'cabangs.name',
            5 => 'mobils.plate_number',
            6 => 'mobils.tahun',
            7 => 'mobils.harga_perhari',
            8 => 'mobils.status',
            9 => null, // Aksi
        ];

        $orders = $request->input('order', []);
        $orderApplied = false;

        // Jika pengguna memilih pengurutan kolom,
        // ikuti pilihan tersebut.
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

        // Jika belum ada pengurutan dari DataTables,
        // tampilkan mobil terbaru terlebih dahulu.
        if (!$orderApplied) {
            $query->orderByDesc('mobils.created_at')
                ->orderByDesc('mobils.id');
        } else {
            // Jika nilai kolom yang dipilih sama,
            // mobil yang lebih baru berada lebih dahulu.
            $query->orderByDesc('mobils.created_at')
                ->orderByDesc('mobils.id');
        }

        // Pagination DataTables.
        $start = max(
            0,
            (int) $request->input('start', 0)
        );

        $requestedLength = (int) $request->input('length', 10);

        // -1 berarti tampilkan semua data pada DataTables.
        // Batasi jumlah data untuk menjaga performa.
        $length = $requestedLength === -1
            ? 100
            : min(max($requestedLength, 1), 100);

        $mobils = $query
            ->offset($start)
            ->limit($length)
            ->get();

        // Format data JSON untuk DataTables.
        $data = $mobils->map(function ($mobil) {
            return [
                'id' => $mobil->id,
                'name' => $mobil->name,
                'warna' => $mobil->warna,
                'brand_name' => $mobil->brand_name ?? '-',
                'tipe_name' => $mobil->tipe_name ?? '-',
                'cabang_name' => $mobil->cabang_name ?? '-',
                'plate_number' => $mobil->plate_number,
                'tahun' => $mobil->tahun,
                'harga_perhari' => $mobil->harga_perhari,
                'status' => $mobil->status,
                'image' => $mobil->image,
                'fasilitas_count' => $mobil->fasilitas_count,
                'brand_id' => $mobil->brand_id,
                'tipe_mobil_id' => $mobil->tipe_mobil_id,
                'cabang_id' => $mobil->cabang_id,
                'transmisi' => $mobil->transmisi,
                'kapasitas' => $mobil->kapasitas,
                'deposit' => $mobil->deposit,
                'description' => $mobil->description,
                'fasilitas_ids' => $mobil->fasilitas
                    ->pluck('id')
                    ->toArray(),
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
     * Menambahkan mobil baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'tipe_mobil_id' => 'required|exists:tipe_mobils,id',
            'cabang_id' => 'required|exists:cabangs,id',
            'name' => 'required|string|max:45',
            'plate_number' => 'required|string|max:20|unique:mobils,plate_number',
            'tahun' => 'required|integer|min:1990|max:' . date('Y'),
            'transmisi' => 'required|in:manual,matic,Manual,Matic',
            'kapasitas' => 'required|integer|min:1',
            'warna' => 'required|string|max:20',
            'harga_perhari' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:Tersedia,Disewa,Maintenance',
            'description' => 'nullable|string',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'exists:fasilitas,id',
        ], [
            'brand_id.required' => 'Brand wajib dipilih.',
            'tipe_mobil_id.required' => 'Tipe mobil wajib dipilih.',
            'cabang_id.required' => 'Cabang wajib dipilih.',
            'name.required' => 'Nama mobil wajib diisi.',
            'name.max' => 'Nama mobil maksimal 45 karakter.',
            'plate_number.required' => 'Plat nomor wajib diisi.',
            'plate_number.unique' => 'Plat nomor sudah dipakai.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'transmisi.required' => 'Transmisi wajib dipilih.',
            'kapasitas.required' => 'Kapasitas wajib diisi.',
            'kapasitas.integer' => 'Kapasitas harus berupa angka.',
            'warna.required' => 'Warna wajib diisi.',
            'harga_perhari.required' => 'Harga per hari wajib diisi.',
            'harga_perhari.numeric' => 'Harga per hari harus berupa angka.',
            'deposit.required' => 'Deposit wajib diisi.',
            'deposit.numeric' => 'Deposit harus berupa angka.',
            'image.mimes' => 'Foto harus berformat JPG atau PNG.',
            'image.max' => 'Ukuran foto maksimal 2 MB.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        $validated['transmisi'] = ucfirst(
            strtolower($validated['transmisi'])
        );

        // Upload gambar jika tersedia.
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageName = time() . '_' . $image->hashName();

            $image->move(
                public_path('images/mobils'),
                $imageName
            );

            $validated['image'] = 'images/mobils/' . $imageName;
        }

        // Pisahkan fasilitas agar tidak ikut dimasukkan
        // sebagai kolom tabel mobils.
        $fasilitasIds = $validated['fasilitas'] ?? [];

        unset($validated['fasilitas']);

        // Buat data mobil baru.
        $mobil = Mobil::create($validated);

        // Simpan fasilitas mobil.
        $mobil->fasilitas()->sync($fasilitasIds);

        // Respons JSON untuk permintaan AJAX.
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Mobil berhasil ditambahkan.',
                'id' => $mobil->id,
            ], 201);
        }

        if ($request->is('staff/mobils')) {
            return redirect()
                ->route('staff.mobils.index')
                ->with('success', 'Mobil berhasil ditambahkan.');
        }

        return redirect()
            ->route('mobils.index')
            ->with('success', 'Mobil berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail mobil.
     */
    public function show(Mobil $mobil)
    {
        $mobil->load([
            'brand',
            'tipeMobil',
            'cabang',
            'fasilitas',
        ]);

        $cabangs = Cabang::orderBy('name')->get();

        $supirs = Supir::where('status', 'tersedia')
            ->orderBy('name')
            ->get();

        return view(
            'customer.mobil-detail',
            compact('mobil', 'cabangs', 'supirs')
        );
    }

    /**
     * Memperbarui data mobil.
     */
    public function update(Request $request, Mobil $mobil)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'tipe_mobil_id' => 'required|exists:tipe_mobils,id',
            'cabang_id' => 'required|exists:cabangs,id',
            'name' => 'required|string|max:45',
            'plate_number' => 'required|string|max:20|unique:mobils,plate_number,' . $mobil->id,
            'tahun' => 'required|integer|min:1990|max:' . date('Y'),
            'transmisi' => 'required|in:Manual,Matic',
            'kapasitas' => 'required|integer|min:1',
            'warna' => 'required|string|max:20',
            'harga_perhari' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:Tersedia,Disewa,Maintenance',
            'description' => 'nullable|string',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'exists:fasilitas,id',
        ]);

        // Pisahkan fasilitas dari data utama mobil.
        $fasilitasIds = $validated['fasilitas'] ?? [];

        unset($validated['fasilitas']);

        // Ganti foto jika pengguna mengunggah foto baru.
        if ($request->hasFile('image')) {
            if (
                $mobil->image &&
                File::exists(public_path($mobil->image))
            ) {
                File::delete(public_path($mobil->image));
            }

            $image = $request->file('image');

            $imageName = time() . '_' . $image->hashName();

            $image->move(
                public_path('images/mobils'),
                $imageName
            );

            $validated['image'] = 'images/mobils/' . $imageName;
        }

        $mobil->update($validated);

        // Sinkronkan fasilitas, termasuk jika tidak ada yang dipilih.
        $mobil->fasilitas()->sync($fasilitasIds);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Mobil berhasil diperbarui.',
            ]);
        }

        if ($request->routeIs('staff.mobils.*')) {
            return redirect()
                ->route('staff.mobils.index')
                ->with('success', 'Mobil berhasil diperbarui.');
        }

        return redirect()
            ->route('mobils.index')
            ->with('success', 'Mobil berhasil diperbarui.');
    }

    /**
     * Menghapus data mobil.
     */
    public function destroy(Request $request, Mobil $mobil)
    {
        // Jangan hapus mobil yang memiliki riwayat rental.
        if ($mobil->rentals()->exists()) {
            $message = 'Mobil tidak dapat dihapus karena masih memiliki riwayat rental.';

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'message' => $message,
                ], 422);
            }

            if ($request->routeIs('staff.mobils.*')) {
                return redirect()
                    ->route('staff.mobils.index')
                    ->with('error', $message);
            }

            return redirect()
                ->route('mobils.index')
                ->with('error', $message);
        }

        // Hapus foto jika ada.
        if (
            $mobil->image &&
            File::exists(public_path($mobil->image))
        ) {
            File::delete(public_path($mobil->image));
        }

        $mobil->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Mobil berhasil dihapus.',
            ]);
        }

        if ($request->routeIs('staff.mobils.*')) {
            return redirect()
                ->route('staff.mobils.index')
                ->with('success', 'Mobil berhasil dihapus.');
        }

        return redirect()
            ->route('mobils.index')
            ->with('success', 'Mobil berhasil dihapus.');
    }
}
