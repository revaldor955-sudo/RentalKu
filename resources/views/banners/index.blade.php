<h1>Data Banner</h1>

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

<form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="text" name="judul" placeholder="Judul">
    <input type="file" name="gambar">
    <textarea name="description" placeholder="Deskripsi"></textarea>
    <select name="status">
        <option value="aktif">Aktif</option>
        <option value="nonaktif">Nonaktif</option>
    </select>
    <input type="number" name="urutan" placeholder="Urutan" min="0">

    <button type="submit">Simpan</button>
</form>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Gambar</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>Urutan</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($banners as $banner)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $banner->judul }}</td>
                <td>
                    @if ($banner->gambar)
                        <img src="{{ asset($banner->gambar) }}" width="80">
                    @endif
                </td>
                <td>{{ $banner->description }}</td>
                <td>{{ $banner->status }}</td>
                <td>{{ $banner->urutan }}</td>

                <td>
                    <form action="{{ route('banners.destroy', $banner->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>