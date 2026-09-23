<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('faqs.index', compact('faqs'));
    }

    /**
     * Server-side DataTables: daftar FAQ (search, sort, pagination)
     */
    public function data(Request $request)
    {
        $query = Faq::query();

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where('faqs.pertanyaan', 'like', "%{$search}%")
                  ->orWhere('faqs.jawaban', 'like', "%{$search}%");
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'faqs.pertanyaan',
            2 => null,
            3 => 'faqs.urutan',
            4 => null,
        ];

        $orderColumn = $request->input('order.0.column', 3);
        $orderDir = $request->input('order.0.dir', 'asc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('faqs.urutan', 'asc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $faqs = $query->offset($start)->limit($length)->get();

        $data = $faqs->map(function ($item) {
            return [
                'id' => $item->id,
                'pertanyaan' => $item->pertanyaan,
                'jawaban' => $item->jawaban,
                'urutan' => $item->urutan,
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
            'urutan' => 'nullable|integer|min:0',
        ], [
            'pertanyaan.required' => 'Pertanyaan wajib diisi',
            'jawaban.required' => 'Jawaban wajib diisi',
        ]);

        Faq::create($validated);

        return redirect()->route('faqs.index')
            ->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function show(Faq $faq)
    {
        //
    }

    public function edit(Faq $faq)
    {
        //
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
            'urutan' => 'nullable|integer|min:0',
        ], [
            'pertanyaan.required' => 'Pertanyaan wajib diisi',
            'jawaban.required' => 'Jawaban wajib diisi',
        ]);

        $faq->update($validated);

        return redirect()->route('faqs.index')
            ->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faqs.index')
            ->with('success', 'FAQ berhasil dihapus.');
    }
}