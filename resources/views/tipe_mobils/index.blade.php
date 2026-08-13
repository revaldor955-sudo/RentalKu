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