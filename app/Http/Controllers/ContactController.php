<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'subjek' => 'required',
            'pesan' => 'required',
        ]);

        // Placeholder: simpan ke database atau kirim email
        // Log::info('Pesan kontak diterima', $request->all());

        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}
