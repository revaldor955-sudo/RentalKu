<?php

namespace App\Http\Controllers;

use App\Models\FotoMobil;
use App\Models\Mobil;
use Illuminate\Http\Request;

class FotoMobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::orderByDesc('id')->get();

        return view('foto_mobils.index', compact('mobils'))
            ->with('pageTitle', 'Foto Kendaraan');
    }

    /**
     * DataTables: pencarian, pengurutan, dan pagination foto mobil.
     * Default: foto dengan ID terbaru tampil paling atas.
     */
    public function data(Request $request)
    {
        $query = FotoMobil::query()
            ->leftJoin(
                'mobils',
                'foto_mobils.mobil_id',
                '=',
                'mobils.id'
            )
            ->select('foto_mobils.*')
            ->with('mobil');

        // Total data sebelum pencarian.
        $recordsTotal = FotoMobil::count();

        // Pencarian berdasarkan nama mobil atau nomor polisi.
        $search = trim((string) $request->input('search.value', ''));

        if ($search !== '') {
            $query->whereHas('mobil', function ($mq) use ($search) {
                $mq->where('name', 'like', "%{$search}%")
                   ->orWhere('plate_number', 'like', "%{$search}%");
            });
        }

        // Total data setelah pencarian.
        $recordsFiltered = (clone $query)
            ->count('foto_mobils.id');

        // Indeks kolom harus sesuai dengan tabel pada Blade.
        $columns = [
            0 => null,              // Nomor urut
            1 => 'mobils.name',     // Mobil
            2 => null,              // Foto
            3 => null,              // Aksi
        ];

        $orderColumn = $request->input('order.0.column');
        $orderDir = strtolower(
            $request->input('order.0.dir', 'desc')
        ) === 'asc' ? 'asc' : 'desc';

        // Ikuti pengurutan manual jika kolom yang dipilih mendukungnya.
        if (
            $orderColumn !== null
            && isset($columns[$orderColumn])
            && $columns[$orderColumn] !== null
        ) {
            $query->orderBy($columns[$orderColumn], $orderDir);

            // Jika nama mobil sama, foto terbaru didahulukan.
            $query->orderByDesc('foto_mobils.id');
        } else {
            // Pengurutan default: foto terbaru terlebih dahulu.
            $query->orderByDesc('foto_mobils.id');
        }

        // Pagination DataTables.
        $start = max(0, (int) $request->input('start', 0));
        $length = (int) $request->input('length', 10);

        if ($length < 1) {
            $length = 10;
        }

        $length = min($length, 100);

        $fotoMobils = $query
            ->offset($start)
            ->limit($length)
            ->get();

        $data = $fotoMobils->map(function ($item) {
            return [
                'id' => $item->id,
                'mobil_id' => $item->mobil_id,
                'mobil_name' => $item->mobil->name ?? '-',
                'mobil_plate' => $item->mobil->plate_number ?? '-',
                'url' => $item->url,
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
        //
    }

    /**
     * Menyimpan foto mobil baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mobil_id' => 'required|exists:mobils,id',
            'url' => 'required|mimes:jpeg,png,jpg,svg|max:2048',
        ], [
            'mobil_id.required' => 'Mobil wajib dipilih',
            'url.required' => 'Foto wajib diisi',
            'url.mimes' => 'Foto harus berupa gambar (JPG, PNG, SVG)',
            'url.max' => 'Ukuran foto maksimal 2MB',
        ]);

        if ($request->hasFile('url')) {
            $image = $request->file('url');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();

            $image->move(
                public_path('images/foto_mobils'),
                $imageName
            );

            $validated['url'] = 'images/foto_mobils/' . $imageName;
        }

        FotoMobil::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Foto mobil berhasil ditambahkan.',
            ], 201);
        }

        return redirect()
            ->route('foto_mobils.index')
            ->with('success', 'Foto mobil berhasil ditambahkan.');
    }

    public function show(FotoMobil $fotoMobil)
    {
        //
    }

    public function edit(FotoMobil $fotoMobil)
    {
        //
    }

    /**
     * Memperbarui data foto mobil.
     */
    public function update(Request $request, FotoMobil $fotoMobil)
    {
        $validated = $request->validate([
            'mobil_id' => 'required|exists:mobils,id',
            'url' => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
        ], [
            'mobil_id.required' => 'Mobil wajib dipilih',
            'url.mimes' => 'Foto harus berupa gambar (JPG, PNG, SVG)',
            'url.max' => 'Ukuran foto maksimal 2MB',
        ]);

        if ($request->hasFile('url')) {
            $image = $request->file('url');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();

            $image->move(
                public_path('images/foto_mobils'),
                $imageName
            );

            $newPath = 'images/foto_mobils/' . $imageName;

            // Hapus foto lama setelah foto baru berhasil diunggah.
            if (
                $fotoMobil->url
                && file_exists(public_path($fotoMobil->url))
            ) {
                unlink(public_path($fotoMobil->url));
            }

            $validated['url'] = $newPath;
        }

        $fotoMobil->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Foto mobil berhasil diperbarui.',
            ]);
        }

        return redirect()
            ->route('foto_mobils.index')
            ->with('success', 'Foto mobil berhasil diperbarui.');
    }

    /**
     * Menghapus foto mobil.
     */
    public function destroy(Request $request, FotoMobil $fotoMobil)
    {
        if (
            $fotoMobil->url
            && file_exists(public_path($fotoMobil->url))
        ) {
            unlink(public_path($fotoMobil->url));
        }

        $fotoMobil->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Foto mobil berhasil dihapus.',
            ]);
        }

        return redirect()
            ->route('foto_mobils.index')
            ->with('success', 'Foto mobil berhasil dihapus.');
    }
}
