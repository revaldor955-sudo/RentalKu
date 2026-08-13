<h1>Data Kupon</h1>

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

<form action="{{ route('kupons.store') }}" method="POST">
    @csrf

    <input type="text" name="code">
    <select name="jenis">
        <option value="persen">Persen</option>
        <option value="nominal">Nominal</option>
    </select>
    <input type="number" name="value" step="0.01">
    <input type="number" name="kuota">
    <input type="number" name="minimal_pembelian" step="0.01">
    <input type="date" name="active_at">
    <input type="date" name="expired_at">

    <button type="submit">Simpan</button>
</form>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Jenis</th>
            <th>Value</th>
            <th>Kuota</th>
            <th>Terpakai</th>
            <th>Minimal Pembelian</th>
            <th>Aktif</th>
            <th>Expired</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($kupons as $kupon)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kupon->code }}</td>
                <td>{{ ucfirst($kupon->jenis) }}</td>
                <td>{{ $kupon->value }}</td>
                <td>{{ $kupon->kuota }}</td>
                <td>{{ $kupon->terpakai }}</td>
                <td>{{ $kupon->minimal_pembelian }}</td>
                <td>{{ $kupon->active_at }}</td>
                <td>{{ $kupon->expired_at }}</td>

                <td>
                    <form action="{{ route('kupons.destroy', $kupon->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>