<?php

namespace App\Http\Controllers;

use App\Models\Kompensasi;
use App\Models\Rental;
use Illuminate\Http\Request;

class KompensasiController extends Controller
{
    public function index()
    {
        return view('kompensasis.index')->with('pageTitle', 'Kompensasi');
    }

    public function data(Request $request)
    {
        $query = Kompensasi::query()
            ->leftJoin('users as customer', 'kompensasis.customer_id', '=', 'customer.id')
            ->leftJoin('users as staff', 'kompensasis.staff_id', '=', 'staff.id')
            ->leftJoin('mobils', 'kompensasis.mobil_id', '=', 'mobils.id')
            ->select('kompensasis.*')
            ->with(['mobil', 'rental', 'customer', 'staff']);

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kompensasis.jenis', 'like', "%{$search}%")
                  ->orWhere('kompensasis.status', 'like', "%{$search}%")
                  ->orWhere('kompensasis.alasan', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('staff', function ($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('mobil', function ($mq) use ($search) {
                      $mq->where('name', 'like', "%{$search}%")
                         ->orWhere('plate_number', 'like', "%{$search}%");
                  });
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'kompensasis.tanggal',
            2 => 'kompensasis.jenis',
            3 => 'customer.name',
            4 => 'mobils.name',
            5 => 'kompensasis.nominal',
            6 => 'kompensasis.status',
            7 => 'kompensasis.created_at',
        ];

        $orderColumn = $request->input('order.0.column', 7);
        $orderDir = $request->input('order.0.dir', 'desc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('kompensasis.created_at', 'desc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $kompensasis = $query->offset($start)->limit($length)->get();

        $data = $kompensasis->map(function ($item) {
            return [
                'id' => $item->id,
                'tanggal' => $item->tanggal?->format('d/m/Y'),
                'jenis' => $item->jenis,
                'customer_name' => $item->customer->name ?? '-',
                'customer_email' => $item->customer->email ?? '-',
                'mobil_name' => $item->mobil->name ?? '-',
                'mobil_plate' => $item->mobil->plate_number ?? '-',
                'nominal' => (float) $item->nominal,
                'alasan' => $item->alasan,
                'status' => $item->status,
                'staff_name' => $item->staff->name ?? '-',
                'catatan' => $item->catatan,
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
            'mobil_id' => 'required|exists:mobils,id',
            'rental_id' => 'required|exists:rentals,id',
            'jenis' => 'required|in:pengembalian_dana,diskon,gratis_sewa',
            'nominal' => 'required_if:jenis,pengembalian_dana|numeric|min:0',
            'alasan' => 'required|string',
            'tanggal' => 'required|date',
        ], [
            'mobil_id.required' => 'Mobil wajib dipilih',
            'rental_id.required' => 'Rental wajib dipilih',
            'jenis.required' => 'Jenis kompensasi wajib dipilih',
            'nominal.required_if' => 'Nominal wajib diisi untuk pengembalian dana',
            'alasan.required' => 'Alasan wajib diisi',
            'tanggal.required' => 'Tanggal wajib diisi',
        ]);

        $validated['customer_id'] = auth()->id();
        $validated['status'] = 'diajukan';

        // Klaim hanya boleh atas rental milik sendiri; mobil mengikuti rental.
        $rental = Rental::where('id', $validated['rental_id'])
            ->where('user_id', auth()->id())
            ->first();
        if (! $rental) {
            abort(403, 'Rental ini bukan milik Anda.');
        }

        // Satu rental hanya boleh punya satu klaim (klaim ditolak boleh diajukan ulang).
        $klaimAktif = Kompensasi::where('rental_id', $validated['rental_id'])
            ->whereIn('status', ['diajukan', 'disetujui', 'selesai'])
            ->exists();
        if ($klaimAktif) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Rental ini sudah memiliki klaim aktif.',
                    'errors' => ['rental_id' => ['Rental ini sudah memiliki klaim aktif.']],
                ], 422);
            }

            return back()
                ->withErrors(['rental_id' => 'Rental ini sudah memiliki klaim aktif.'])
                ->withInput();
        }
        $validated['mobil_id'] = $rental->mobil_id;

        Kompensasi::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Klaim kompensasi berhasil diajukan.',
            ]);
        }

        return redirect()->route('customer.kompensasi.index')
            ->with('success', 'Klaim kompensasi berhasil diajukan.');
    }

    public function update(Request $request, Kompensasi $kompensasi)
    {
        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak,selesai',
            'catatan' => 'nullable|string',
        ], [
            'status.required' => 'Status wajib dipilih',
        ]);

        // Transisi legal: diajukan -> disetujui/ditolak, disetujui -> selesai.
        // Status final tidak bisa diubah lagi.
        $transisi = [
            'diajukan' => ['disetujui', 'ditolak'],
            'disetujui' => ['selesai'],
        ];

        if ($kompensasi->status !== $validated['status']
            && ! in_array($validated['status'], $transisi[$kompensasi->status] ?? [], true)) {
            $pesan = 'Status kompensasi tidak dapat diubah dari '.$kompensasi->status.' ke '.$validated['status'].'.';

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => $pesan,
                ], 422);
            }

            return back()
                ->withErrors(['status' => $pesan])
                ->withInput();
        }

        $validated['staff_id'] = auth()->id();

        // Keputusan baru = belum dibaca customer; edit tanpa ubah status tidak picu notifikasi.
        if ($kompensasi->status !== $validated['status']) {
            $validated['dibaca_at'] = null;
        } else {
            unset($validated['dibaca_at']);
        }

        $kompensasi->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Kompensasi berhasil diperbarui.',
            ]);
        }

        return redirect()->route('kompensasis.index')
            ->with('success', 'Kompensasi berhasil diperbarui.');
    }

    public function destroy(Request $request, Kompensasi $kompensasi)
    {
        $kompensasi->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Kompensasi berhasil dihapus.',
            ]);
        }

        return redirect()->route('kompensasis.index')
            ->with('success', 'Kompensasi berhasil dihapus.');
    }

    public function customerIndex()
    {
        $rentals = Rental::with('mobil')
            ->where('user_id', auth()->id())
            ->where('status', 'Selesai')
            ->whereNotExists(function ($query) {
                $query->selectRaw('1')
                    ->from('kompensasis')
                    ->whereColumn('kompensasis.rental_id', 'rentals.id')
                    ->whereIn('kompensasis.status', ['diajukan', 'disetujui', 'selesai']);
            })
            ->get();

        return view('kompensasis.customer-index', compact('rentals'));
    }

    public function customerData(Request $request)
    {
        $query = Kompensasi::query()
            ->leftJoin('mobils', 'kompensasis.mobil_id', '=', 'mobils.id')
            ->select('kompensasis.*')
            ->with(['mobil', 'rental', 'staff'])
            ->where('kompensasis.customer_id', auth()->id());

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kompensasis.jenis', 'like', "%{$search}%")
                  ->orWhere('kompensasis.status', 'like', "%{$search}%")
                  ->orWhere('kompensasis.alasan', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'kompensasis.tanggal',
            2 => 'kompensasis.jenis',
            3 => 'mobils.name',
            4 => 'kompensasis.nominal',
            5 => 'kompensasis.status',
            6 => 'kompensasis.created_at',
        ];

        $orderColumn = $request->input('order.0.column', 6);
        $orderDir = $request->input('order.0.dir', 'desc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('kompensasis.created_at', 'desc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $kompensasis = $query->offset($start)->limit($length)->get();

        // Tandai keputusan yang tampil sebagai sudah dibaca.
        $terbaca = $kompensasis->whereNull('dibaca_at')
            ->whereIn('status', ['disetujui', 'ditolak', 'selesai'])
            ->pluck('id');
        if ($terbaca->isNotEmpty()) {
            Kompensasi::whereIn('id', $terbaca)->update(['dibaca_at' => now()]);
        }

        $data = $kompensasis->map(function ($item) {
            return [
                'id' => $item->id,
                'tanggal' => $item->tanggal?->format('d/m/Y'),
                'jenis' => $item->jenis,
                'mobil_name' => $item->mobil->name ?? '-',
                'mobil_plate' => $item->mobil->plate_number ?? '-',
                'nominal' => (float) $item->nominal,
                'alasan' => $item->alasan,
                'status' => $item->status,
                'staff_name' => $item->staff->name ?? '-',
                'catatan' => $item->catatan,
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

    /**
     * Customer create claim page — retired: single flow via index popup.
     * Kept as redirect for old links/bookmarks.
     */
    public function customerCreate()
    {
        return redirect()->route('customer.kompensasi.index', ['baru' => 1]);
    }
}