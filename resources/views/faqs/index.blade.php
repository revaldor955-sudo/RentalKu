<h1>Data FAQ</h1>

@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if ($errors->any())
    <p style="color: red;">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </p>
@endif

<form action="{{ route('faqs.store') }}" method="POST">
    @csrf

    <textarea name="pertanyaan" placeholder="Pertanyaan"></textarea>
    <textarea name="jawaban" placeholder="Jawaban"></textarea>
    <input type="number" name="urutan" placeholder="Urutan" min="0">

    <button type="submit">Simpan</button>
</form>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Pertanyaan</th>
            <th>Jawaban</th>
            <th>Urutan</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($faqs as $faq)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $faq->pertanyaan }}</td>
                <td>{{ $faq->jawaban }}</td>
                <td>{{ $faq->urutan }}</td>

                <td>
                    <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>