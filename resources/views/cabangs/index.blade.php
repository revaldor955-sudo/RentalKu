<h1>Data Cabang</h1>

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

<form action="{{ route('cabangs.store') }}" method="POST">
    @csrf

    <input type="text" name="name">
    <input type="text" name="address">

    <button type="submit">Simpan</button>
</form>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Address</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($cabangs as $cabang)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $cabang->name }}</td>
                <td>{{ $cabang->address }}</td>

                <td>
                    <form action="{{ route('cabangs.destroy', $cabang->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>