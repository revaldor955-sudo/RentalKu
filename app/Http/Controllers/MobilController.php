<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Cabang;
use App\Models\Fasilitas;
use App\Models\Mobil;
use App\Models\TipeMobil;
use App\Models\Supir;
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

    /**
     * Server-side DataTables: daftar mobil (search, sort, pagination)
     */
    public function data(Request $request)
    {
        $query = Mobil::query()
            ->leftJoin('brands', 'mobils.brand_id', '=', 'brands.id')
            ->leftJoin('tipe_mobils', 'mobils.tipe_mobil_id', '=', 'tipe_mobils.id')
            ->leftJoin('cabangs', 'mobils.cabang_id', '=', 'cabangs.id')
            ->select(
                'mobils.*',
                'brands.name as brand_name',
                'tipe_mobils.name as tipe_name',
                'cabangs.name as cabang_name'
            )
            ->withCount('fasilitas')
            ->with('fasilitas');

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('mobils.name', 'like', "%{$search}%")
                    ->orWhere('mobils.plate_number', 'like', "%{$search}%")
                    ->orWhere('mobils.tahun', 'like', "%{$search}%")
                    ->orWhere('mobils.transmisi', 'like', "%{$search}%")
                    ->orWhere('mobils.warna', 'like', "%{$search}%")
                    ->orWhere('mobils.status', 'like', "%{$search}%")
                    ->orWhere('brands.name', 'like', "%{$search}%")
                    ->orWhere('tipe_mobils.name', 'like', "%{$search}%")
                    ->orWhere('cabangs.name', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'mobils.name',
            2 => 'brands.name',
            3 => 'tipe_mobils.name',
            4 => 'cabangs.name',
            5 => 'mobils.plate_number',
            6 => 'mobils.tahun',
            7 => 'mobils.harga_perhari',
            8 => 'mobils.status',
            9 => null,
        ];

        $orderColumn = $request->input('order.0.column', 1);
        $orderDir = $request->input('order.0.dir', 'asc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('mobils.name', 'asc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $mobils = $query->offset($start)->limit($length)->get();

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
                'fasilitas_ids' => $mobil->fasilitas->pluck('id')->toArray(),
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
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
            'plate_number' => 'required|string|max:7|unique:mobils,plate_number',
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

    // Mengambil semua cabang
    $cabangs = Cabang::orderBy('name')->get();

    // Mengambil supir yang tersedia
    $supirs = Supir::where('status', 'tersedia')
        ->orderBy('name')
        ->get();

    // Permintaan AJAX untuk modal detail mobil customer
    if ($request->ajax() || $request->wantsJson()) {

        return view(
            'customer.partials.mobil-detail-modal',
            compact(
                'mobil',
                'cabangs',
                'supirs'
            )
        );
    }

    return view(
        'customer.mobil-detail',
        compact(
            'mobil',
            'cabangs',
            'supirs'
        )
    );
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

        // Respons JSON untuk request AJAX (modal edit)
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Mobil berhasil diperbarui.',
            ]);
        }

        // Selalu kembali ke data mobil STAFF
        return redirect()
            ->route('staff.mobils.index')
            ->with('success', 'Mobil berhasil diperbarui.');
    }

    /**
     * Hapus mobil
     */
    public function destroy(Request $request, Mobil $mobil)
    {
        $mobil->delete();

        // Respons JSON untuk request AJAX (tombol hapus di halaman admin)
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Mobil berhasil dihapus.',
            ]);
        }

        // Redirect sesuai asal halaman (admin vs staff)
        if ($request->routeIs('staff.mobils.destroy')) {
            return redirect()
                ->route('staff.mobils.index')
                ->with('success', 'Mobil berhasil dihapus.');
        }

        return redirect()
            ->route('mobils.index')
            ->with('success', 'Mobil berhasil dihapus.');
    }
}
