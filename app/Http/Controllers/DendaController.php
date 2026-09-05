<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Rental;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function index()
    {
        $rentals = Rental::with('mobil', 'user')
            ->where('status', 'Selesai')
            ->get();
        return view('dendas.index', compact('rentals'));
    }

    /**
     * Server-side DataTables: daftar denda (search, sort, pagination)
     */
    public function data(Request $request)
    {
        $query = Denda::query()
            ->leftJoin('rentals', 'dendas.rental_id', '=', 'rentals.id')
            ->leftJoin('users', 'rentals.user_id', '=', 'users.id')
            ->leftJoin('mobils', 'rentals.mobil_id', '=', 'mobils.id')
            ->select('dendas.*')
            ->with('rental.mobil', 'rental.user');

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('dendas.jenis', 'like', "%{$search}%")
                  ->orWhere('dendas.status', 'like', "%{$search}%")
                  ->orWhereHas('rental.user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('rental.mobil', function ($mq) use ($search) {
                      $mq->where('name', 'like', "%{$search}%")
                         ->orWhere('plate_number', 'like', "%{$search}%");
                  });
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'mobils.name',
            2 => 'users.name',
            3 => 'dendas.jenis',
            4 => 'dendas.nominal',
            5 => 'dendas.status',
            6 => 'dendas.created_at',
        ];

        $orderColumn = $request->input('order.0.column', 6);
        $orderDir = $request->input('order.0.dir', 'desc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('dendas.created_at', 'desc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $dendas = $query->offset($start)->limit($length)->get();

        $data = $dendas->map(function ($item) {
            return [
                'id' => $item->id,
                'rental_id' => $item->rental_id,
                'mobil_name' => $item->rental->mobil->name ?? '-',
                'mobil_plate' => $item->rental->mobil->plate_number ?? '-',
                'pelanggan' => $item->rental->user->name ?? '-',
                'jenis' => $item->jenis,
                'nominal' => (float) $item->nominal,
                'foto_bukti' => $item->foto_bukti,
                'syarat_dan_ketentuan' => $item->syarat_dan_ketentuan,
                'status' => $item->status,
                'created_at' => $item->created_at?->format('d/m/Y H:i'),
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'jenis' => 'required|in:keterlambatan,kerusakan,kehilangan',
            'nominal' => 'required|numeric|min:0',
            'foto_bukti' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'syarat_dan_ketentuan' => 'nullable|string',
            'status' => 'required|in:belum bayar,lunas',
        ], [
            'rental_id.required' => 'Rental wajib dipilih',
            'jenis.required' => 'Jenis denda wajib dipilih',
            'nominal.required' => 'Nominal denda wajib diisi',
            'nominal.min' => 'Nominal denda tidak boleh negatif',
            'foto_bukti.mimes' => 'Foto bukti harus berupa gambar (jpg, png)',
            'foto_bukti.max' => 'Ukuran foto maksimal 2MB',
            'status.required' => 'Status wajib dipilih',
        ]);

        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/dendas'), $fileName);
            $validated['foto_bukti'] = 'images/dendas/' . $fileName;
        }

        Denda::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Denda berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('dendas.index')
            ->with('success', 'Denda berhasil ditambahkan.');
    }

    public function update(Request $request, Denda $denda)
    {
        $validated = $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'jenis' => 'required|in:keterlambatan,kerusakan,kehilangan',
            'nominal' => 'required|numeric|min:0',
            'foto_bukti' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'syarat_dan_ketentuan' => 'nullable|string',
            'status' => 'required|in:belum bayar,lunas',
        ], [
            'rental_id.required' => 'Rental wajib dipilih',
            'jenis.required' => 'Jenis denda wajib dipilih',
            'nominal.required' => 'Nominal denda wajib diisi',
            'nominal.min' => 'Nominal denda tidak boleh negatif',
            'foto_bukti.mimes' => 'Foto bukti harus berupa gambar (jpg, png)',
            'foto_bukti.max' => 'Ukuran foto maksimal 2MB',
            'status.required' => 'Status wajib dipilih',
        ]);

        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/dendas'), $fileName);
            $validated['foto_bukti'] = 'images/dendas/' . $fileName;
        }

        $denda->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Denda berhasil diperbarui.',
            ]);
        }

        return redirect()->route('dendas.index')
            ->with('success', 'Denda berhasil diperbarui.');
    }

    public function destroy(Request $request, Denda $denda)
    {
        $denda->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Denda berhasil dihapus.',
            ]);
        }

        return redirect()->route('dendas.index')
            ->with('success', 'Denda berhasil dihapus.');
    }
}