<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Kerusakan Mobil</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
@include('layouts.partials.admin-navbar')

<div class="container py-5">

<h1>Data Kerusakan Mobil</h1>

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

<form action="{{ route('kerusakan_mobils.store') }}" method="POST">
    @csrf

    <select name="jenis_kerusakan">
        <option value="">Pilih Jenis Kerusakan</option>
        <option value="Mesin">Mesin</option>
        <option value="Ban">Ban</option>
        <option value="Body">Body</option>
        <option value="Interior">Interior</option>
        <option value="Rem">Rem</option>
        <option value="Kelistrikan">Kelistrikan</option>
        <option value="AC">AC</option>
        <option value="Transmisi">Transmisi</option>
        <option value="Suspensi">Suspensi</option>
        <option value="Kaca">Kaca</option>
        <option value="Lainnya">Lainnya</option>
    </select>

    <textarea name="description" placeholder="Deskripsi"></textarea>

    <button type="submit">Simpan</button>
</form>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Jenis Kerusakan</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($kerusakanMobils as $kerusakanMobil)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kerusakanMobil->jenis_kerusakan }}</td>
                <td>{{ $kerusakanMobil->description }}</td>

                <td>
                    <form action="{{ route('kerusakan_mobils.destroy', $kerusakanMobil->id) }}" method="POST">
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
