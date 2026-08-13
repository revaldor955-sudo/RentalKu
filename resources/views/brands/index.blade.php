<h1>Data Brand</h1>

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

<form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="text" name="name">
    <input type="file" name="logo">
    <textarea name="description"></textarea>

    <button type="submit">Simpan</button>
</form>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Logo</th>
            <th>Description</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($brands as $brand)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $brand->name }}</td>
                <td>
                    @if ($brand->logo)
                        <img src="{{ asset($brand->logo) }}" width="80">
                    @endif
                </td>
                <td>{{ $brand->description }}</td>

                <td>
                    <form action="{{ route('brands.destroy', $brand->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
