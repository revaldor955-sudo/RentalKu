<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index()
    {
        return view('banners.index')->with('pageTitle', 'Banner');
    }

    /**
     * DataTables: pencarian, pengurutan, dan pagination.
     */
    public function data(Request $request)
    {
        $query = Banner::query();

        $recordsTotal = Banner::count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = (clone $query)->count();

        $columns = [
            0 => null,
            1 => null,
            2 => 'judul',
            3 => 'urutan',
            4 => 'status',
            5 => null,
        ];

        $orderColumn = $request->input('order.0.column');
        $orderDir = strtolower(
            (string) $request->input('order.0.dir', 'desc')
        ) === 'asc' ? 'asc' : 'desc';

        /*
         * Urutan default: banner terbaru di atas.
         */
        if (
            $orderColumn === null ||
            !isset($columns[(int) $orderColumn]) ||
            $columns[(int) $orderColumn] === null
        ) {
            $query->orderByDesc('banners.created_at')
                ->orderByDesc('banners.id');
        } else {
            $query->orderBy(
                $columns[(int) $orderColumn],
                $orderDir
            )->orderByDesc('banners.created_at')
                ->orderByDesc('banners.id');
        }

        $start = max(0, (int) $request->input('start', 0));
        $length = (int) $request->input('length', 10);

        if ($length === -1) {
            $length = 100;
        } else {
            $length = min(max($length, 1), 100);
        }

        $banners = $query
            ->offset($start)
            ->limit($length)
            ->get();

        $data = $banners->map(function ($banner) {
            return [
                'id' => $banner->id,
                'judul' => $banner->judul,
                'gambar' => $banner->gambar,
                'description' => $banner->description,
                'link' => $banner->link,
                'status' => $banner->status,
                'urutan' => $banner->urutan,
                'created_at' => $banner->created_at,
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
        return view('banners.index')->with('pageTitle', 'Banner');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'nullable|string',
            'link' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
            'urutan' => 'nullable|integer|min:0',
        ], [
            'judul.required' => 'Judul banner wajib diisi.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat JPG, JPEG, PNG, atau SVG.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
            'status.required' => 'Status banner wajib dipilih.',
            'status.in' => 'Status banner tidak valid.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'urutan.min' => 'Urutan tidak boleh negatif.',
        ]);

        if ($request->hasFile('gambar')) {
            $folder = public_path('images/banners');

            if (!File::isDirectory($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            $image = $request->file('gambar');
            $imageName = uniqid('banner_', true) . '.' .
                $image->getClientOriginalExtension();

            $image->move($folder, $imageName);

            $validated['gambar'] = 'images/banners/' . $imageName;
        }

        $validated['urutan'] = $validated['urutan'] ?? 0;

        Banner::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Banner berhasil ditambahkan.',
            ]);
        }

        return redirect()
            ->route('banners.index')
            ->with('success', 'Banner berhasil ditambahkan.');
    }

    public function show(Banner $banner)
    {
        return response()->json($banner);
    }

    public function edit(Banner $banner)
    {
        return response()->json($banner);
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'nullable|string',
            'link' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
            'urutan' => 'nullable|integer|min:0',
        ], [
            'judul.required' => 'Judul banner wajib diisi.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat JPG, JPEG, PNG, atau SVG.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
            'status.required' => 'Status banner wajib dipilih.',
            'status.in' => 'Status banner tidak valid.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'urutan.min' => 'Urutan tidak boleh negatif.',
        ]);

        if ($request->hasFile('gambar')) {
            $folder = public_path('images/banners');

            if (!File::isDirectory($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            $image = $request->file('gambar');
            $imageName = uniqid('banner_', true) . '.' .
                $image->getClientOriginalExtension();

            $image->move($folder, $imageName);

            // Hapus gambar lama jika berada di folder banner.
            if (
                $banner->gambar &&
                str_starts_with($banner->gambar, 'images/banners/') &&
                File::exists(public_path($banner->gambar))
            ) {
                File::delete(public_path($banner->gambar));
            }

            $validated['gambar'] = 'images/banners/' . $imageName;
        }

        $validated['urutan'] = $validated['urutan'] ?? 0;

        $banner->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Banner berhasil diperbarui.',
            ]);
        }

        return redirect()
            ->route('banners.index')
            ->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy(Request $request, Banner $banner)
    {
        if (
            $banner->gambar &&
            str_starts_with($banner->gambar, 'images/banners/') &&
            File::exists(public_path($banner->gambar))
        ) {
            File::delete(public_path($banner->gambar));
        }

        $banner->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Banner berhasil dihapus.',
            ]);
        }

        return redirect()
            ->route('banners.index')
            ->with('success', 'Banner berhasil dihapus.');
    }
}
