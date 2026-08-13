<h1>Data Supir</h1>

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

<form action="{{ route('supirs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="text" name="name">
    <input type="text" name="phone">
    <input type="file" name="image">
    <input type="number" name="tarif_perhari" step="0.01">
    <select name="status">
        <option value="tersedia">Tersedia</option>
        <option value="tidak tersedia">Tidak Tersedia</option>
    </select>

    <button type="submit">Simpan</button>
</form>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Foto</th>
            <th>Tarif Per Hari</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($supirs as $supir)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $supir->name }}</td>
                <td>{{ $supir->phone }}</td>
                <td>
                    @if ($supir->image)
                        <img src="{{ asset($supir->image) }}" width="80">
                    @endif
                </td>
                <td>{{ $supir->tarif_perhari }}</td>
                <td>{{ ucfirst($supir->status) }}</td>

                <td>
                    <form action="{{ route('supirs.destroy', $supir->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>