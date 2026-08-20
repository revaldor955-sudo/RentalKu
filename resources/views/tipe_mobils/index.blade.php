<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Tipe Mobil</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
@include('layouts.partials.admin-navbar')

<div class="container py-5">

<h1>Data Tipe Mobil</h1>

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

<form action="{{ route('tipe_mobils.store') }}" method="POST">
    @csrf

    <input type="text" name="name">
    <textarea name="description"></textarea>

    <button type="submit">Simpan</button>
</form>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Description</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($tipeMobils as $tipeMobil)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $tipeMobil->name }}</td>
                <td>{{ $tipeMobil->description }}</td>

                <td>
                    <form action="{{ route('tipe_mobils.destroy', $tipeMobil->id) }}" method="POST">
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
