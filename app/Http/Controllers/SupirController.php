<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Supir;
use Illuminate\Http\Request;

class SupirController extends Controller
{
    public function index()
    {
        $cabangs = Cabang::orderBy('name')->get();

        return view('supirs.index', compact('cabangs'))
            ->with('pageTitle', 'Supir');
    }

    /**
     * DataTables: pencarian, pengurutan, dan pagination.
     * Default: supir terbaru tampil paling atas.
     */
    public function data(Request $request)
    {
        $query = Supir::query();

        $recordsTotal = (clone $query)->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('supirs.name', 'like', "%{$search}%")
                    ->orWhere('supirs.phone', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = (clone $query)->count();

        // Indeks kolom mengikuti tabel DataTables di Blade.
        $columns = [
            0 => null, // No
            1 => 'supirs.name',
            2 => 'supirs.phone',
            3 => null, // Foto
            4 => 'supirs.tarif_perhari',
            5 => 'supirs.status',
            6 => null, // Aksi
        ];

        $orderColumn = $request->input('order.0.column');
        $orderDir = strtolower(
            $request->input('order.0.dir', 'asc')
        ) === 'desc' ? 'desc' : 'asc';

        if (
            $orderColumn !== null &&
            isset($columns[(int) $orderColumn]) &&
            $columns[(int) $orderColumn] !== null
        ) {
            $query->orderBy(
                $columns[(int) $orderColumn],
                $orderDir
            );

            // ID terbaru menjadi pemecah seri.
            $query->orderByDesc('supirs.id');
        } else {
            // Urutan default: supir terbaru terlebih dahulu.
            $query->orderByDesc('supirs.id');
        }

        $start = max(0, (int) $request->input('start', 0));

        $requestedLength = (int) $request->input('length', 10);

        $length = $requestedLength === -1
            ? 100
            : min(max($requestedLength, 1), 100);

        $supirs = $query
            ->offset($start)
            ->limit($length)
            ->get();

        $data = $supirs->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'cabang_id' => $item->cabang_id,
                'phone' => $item->phone,
                'image' => $item->image,
                'tarif_perhari' => $item->tarif_perhari,
                'status' => $item->status,
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
        $cabangs = Cabang::orderBy('name')->get();

        return view('supirs.index', compact('cabangs'))
            ->with('pageTitle', 'Supir');
    }

    public function store(Request $request)
    {
        // Ubah format tampilan Rupiah, misalnya 150.000,
        // menjadi angka 150000 sebelum validasi.
        $request->merge([
            'tarif_perhari' => preg_replace(
                '/\D/',
                '',
                (string) $request->input('tarif_perhari', '')
            ),
        ]);

        $validated = $request->validate([
            'cabang_id' => 'required|exists:cabangs,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'image' => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
            'tarif_perhari' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,tidak tersedia',
        ], [
            'cabang_id.required' => 'Cabang wajib dipilih.',
            'cabang_id.exists' => 'Cabang yang dipilih tidak valid.',
            'name.required' => 'Nama supir wajib diisi.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.max' => 'Nomor HP maksimal 20 karakter.',
            'image.mimes' => 'Foto harus berupa JPG, PNG, JPEG, atau SVG.',
            'image.max' => 'Ukuran foto maksimal 2 MB.',
            'tarif_perhari.required' => 'Tarif per hari wajib diisi.',
            'tarif_perhari.numeric' => 'Tarif per hari harus berupa angka.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        if ($request->hasFile('image')) {
            $directory = public_path('images/supirs');

            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $image = $request->file('image');
            $imageName = uniqid('supir_') . '.' . $image->extension();

            $image->move($directory, $imageName);

            $validated['image'] = 'images/supirs/' . $imageName;
        }

        Supir::create($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Supir berhasil ditambahkan.',
            ], 201);
        }

        return redirect()
            ->route('supirs.index')
            ->with('success', 'Supir berhasil ditambahkan.');
    }

    public function show(Supir $supir)
    {
        return response()->json($supir);
    }

    public function edit(Supir $supir)
    {
        return response()->json($supir);
    }

    public function update(Request $request, Supir $supir)
    {
        // Normalisasi tarif Rupiah sebelum validasi.
        $request->merge([
            'tarif_perhari' => preg_replace(
                '/\D/',
                '',
                (string) $request->input('tarif_perhari', '')
            ),
        ]);

        $validated = $request->validate([
            'cabang_id' => 'required|exists:cabangs,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'image' => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
            'tarif_perhari' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,tidak tersedia',
        ], [
            'cabang_id.required' => 'Cabang wajib dipilih.',
            'cabang_id.exists' => 'Cabang yang dipilih tidak valid.',
            'name.required' => 'Nama supir wajib diisi.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.max' => 'Nomor HP maksimal 20 karakter.',
            'image.mimes' => 'Foto harus berupa JPG, PNG, JPEG, atau SVG.',
            'image.max' => 'Ukuran foto maksimal 2 MB.',
            'tarif_perhari.required' => 'Tarif per hari wajib diisi.',
            'tarif_perhari.numeric' => 'Tarif per hari harus berupa angka.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        if ($request->hasFile('image')) {
            $directory = public_path('images/supirs');

            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $image = $request->file('image');
            $imageName = uniqid('supir_') . '.' . $image->extension();

            $image->move($directory, $imageName);

            $validated['image'] = 'images/supirs/' . $imageName;

            // Hapus foto lama setelah foto baru berhasil disimpan.
            if (
                $supir->image &&
                is_file(public_path($supir->image))
            ) {
                @unlink(public_path($supir->image));
            }
        }

        $supir->update($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Supir berhasil diperbarui.',
            ]);
        }

        return redirect()
            ->route('supirs.index')
            ->with('success', 'Supir berhasil diperbarui.');
    }

    public function destroy(Request $request, Supir $supir)
    {
        if (
            $supir->image &&
            is_file(public_path($supir->image))
        ) {
            @unlink(public_path($supir->image));
        }

        $supir->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Supir berhasil dihapus.',
            ]);
        }

        return redirect()
            ->route('supirs.index')
            ->with('success', 'Supir berhasil dihapus.');
    }
}
