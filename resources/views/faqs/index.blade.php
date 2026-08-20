<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data FAQ</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
@include('layouts.partials.admin-navbar')

<div class="container py-5">

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
</div>

</body>
</html>
