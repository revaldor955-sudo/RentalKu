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
     * Admin melihat semua pesan
     */
    public function index()
    {
        $contacts = Contact::latest()->get();

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
        ));
    }


    /**
     * Admin melihat detail pesan
     */
    public function show(Contact $contact)
    {
        if ($contact->status === 'Belum Dibaca') {
            $contact->update([
                'status' => 'Dibaca',
            ]);
        }

        return view('admin.contacts.show', compact('contact'));
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

        return redirect()
            ->route('contacts.show', $contact)
            ->with(
                'success',
                'Balasan berhasil dikirim ke email ' . $contact->email
            );
    }


    /**
     * Admin menghapus pesan
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()
            ->route('contacts.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}