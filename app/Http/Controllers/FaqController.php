<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('urutan', 'asc')->orderBy('id', 'desc')->get();

        return view('faqs.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jawaban' => 'required|string',
            'urutan' => 'nullable|integer|min:0',
        ], [
            'pertanyaan.required' => 'Pertanyaan wajib diisi.',
            'jawaban.required' => 'Jawaban wajib diisi.',
            'pertanyaan.max' => 'Pertanyaan maksimal 255 karakter.',
            'urutan.integer' => 'Urutan harus berupa angka.',
        ]);

        Faq::create([
            'pertanyaan' => $validated['pertanyaan'],
            'jawaban' => $validated['jawaban'],
            'urutan' => $validated['urutan'] ?? 0,
        ]);

        return redirect()->route('faqs.index')->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jawaban' => 'required|string',
            'urutan' => 'nullable|integer|min:0',
        ], [
            'pertanyaan.required' => 'Pertanyaan wajib diisi.',
            'jawaban.required' => 'Jawaban wajib diisi.',
            'pertanyaan.max' => 'Pertanyaan maksimal 255 karakter.',
            'urutan.integer' => 'Urutan harus berupa angka.',
        ]);

        $faq->update([
            'pertanyaan' => $validated['pertanyaan'],
            'jawaban' => $validated['jawaban'],
            'urutan' => $validated['urutan'] ?? 0,
        ]);

        return redirect()->route('faqs.index')->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faqs.index')->with('success', 'FAQ berhasil dihapus.');
    }
}