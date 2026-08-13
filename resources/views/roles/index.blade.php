<h1>Data Role</h1>

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

<form action="{{ route('roles.store') }}" method="POST">
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
        </tr>
    </thead>

    <tbody>
        @foreach ($roles as $role)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->description }}</td>

                <td>
                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
