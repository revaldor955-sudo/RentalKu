<?php

namespace App\Http\Controllers;

use App\Mail\ContactReplyMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Pengunjung mengirim pesan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:150',
            ],

            'subjek' => [
                'required',
                'string',
                'max:200',
            ],

            'pesan' => [
                'required',
                'string',
                'max:5000',
            ],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 150 karakter.',

            'subjek.required' => 'Subjek wajib diisi.',
            'subjek.max' => 'Subjek maksimal 200 karakter.',

            'pesan.required' => 'Pesan wajib diisi.',
            'pesan.max' => 'Pesan maksimal 5000 karakter.',
        ]);

        Contact::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'subjek' => $validated['subjek'],
            'pesan' => $validated['pesan'],
            'status' => 'Belum Dibaca',
        ]);

        return back()->with(
            'success',
            'Pesan berhasil dikirim. Tim RentalKu akan segera menghubungi Anda melalui email.'
        );
    }


    /**
     * Server-side DataTables: daftar pesan masuk (search, sort, pagination)
     */
    public function data(Request $request)
    {
        $query = Contact::query();

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subjek', 'like', "%{$search}%")
                  ->orWhere('pesan', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $statusFilter = $request->input('columns.4.search.value');

        if ($statusFilter && $statusFilter !== 'Semua') {
            $query->where('status', $statusFilter);
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'contacts.nama',
            2 => 'contacts.email',
            3 => 'contacts.subjek',
            4 => 'contacts.status',
            5 => 'contacts.created_at',
            6 => null,
        ];

        $orderColumn = (int) $request->input('order.0.column', 5);
        $orderDir = $request->input('order.0.dir', 'desc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('contacts.created_at', 'desc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        if ($length > 0 && $length !== -1) {
            $query->offset($start)->limit($length);
        }

        $contacts = $query->get();

        $data = $contacts->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'email' => $item->email,
                'subjek' => $item->subjek,
                'pesan' => $item->pesan,
                'status' => $item->status,
                'balasan' => $item->balasan,
                'dibalas_pada' => $item->dibalas_pada,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
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
     * Admin melihat semua pesan
     */
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);

        $totalPesan = Contact::count();

        $belumDibaca = Contact::where(
            'status',
            'Belum Dibaca'
        )->count();

        $sudahDibalas = Contact::where(
            'status',
            'Dibalas'
        )->count();

        return view('admin.contacts.index', compact(
            'contacts',
            'totalPesan',
            'belumDibaca',
            'sudahDibalas'
        ))->with('pageTitle', 'Hubungi Kami');
    }


    /**
     * Admin lihat detail satu pesan (AJAX)
     */
    public function detail(Contact $contact)
    {
        return response()->json($contact);
    }


    /**
     * Admin mark as read (AJAX)
     */
    public function markAsRead(Contact $contact)
    {
        if ($contact->status === 'Belum Dibaca') {
            $contact->update([
                'status' => 'Dibaca',
            ]);
        }

        return response()->json(['success' => true]);
    }


    /**
     * Admin membalas pesan
     */
    public function reply(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'balasan' => [
                'required',
                'string',
                'max:5000',
            ],
        ], [
            'balasan.required' => 'Balasan wajib diisi.',
            'balasan.max' => 'Balasan maksimal 5000 karakter.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Kirim email ke pengunjung
        |--------------------------------------------------------------------------
        */

        Mail::to($contact->email)->send(
            new ContactReplyMail(
                $contact,
                $validated['balasan']
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Simpan balasan ke database
        |--------------------------------------------------------------------------
        */

        $contact->update([
            'balasan' => $validated['balasan'],
            'status' => 'Dibalas',
            'dibalas_pada' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Balasan berhasil dikirim ke email ' . $contact->email
        ]);
    }


    /**
     * Admin menghapus pesan
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dihapus.'
        ]);
    }
}