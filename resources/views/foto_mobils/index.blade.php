<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Foto Mobil</title>
</head>
<body>
@include('layouts.partials.admin-navbar')

<div class="container py-5">

<h1>Data Foto Mobil</h1>

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

<form action="{{ route('foto_mobils.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <select name="mobil_id">
        <option value="">Pilih Mobil</option>
        @foreach ($mobils as $mobil)
            <option value="{{ $mobil->id }}">{{ $mobil->name }} ({{ $mobil->plate_number }})</option>
        @endforeach
    </select>

    <input type="file" name="url">

    <button type="submit">Simpan</button>
</form>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Mobil</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($fotoMobils as $fotoMobil)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $fotoMobil->mobil->name ?? '-' }}</td>
                <td>
                    @if ($fotoMobil->url)
                        <img src="{{ asset($fotoMobil->url) }}" width="80">
                    @endif
                </td>

                <td>
                    <form action="{{ route('foto_mobils.destroy', $fotoMobil->id) }}" method="POST">
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
