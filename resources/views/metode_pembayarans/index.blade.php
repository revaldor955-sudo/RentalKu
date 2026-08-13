<h1>Data Metode Pembayaran</h1>

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

<form action="{{ route('metode_pembayarans.store') }}" method="POST">
    @csrf

    <input type="text" name="name">
    <input type="text" name="nomor_akun">

    <button type="submit">Simpan</button>
</form>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Nomor Akun</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($metodePembayarans as $metodePembayaran)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $metodePembayaran->name }}</td>
                <td>{{ $metodePembayaran->nomor_akun }}</td>

                <td>
                    <form action="{{ route('metode_pembayarans.destroy', $metodePembayaran->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>