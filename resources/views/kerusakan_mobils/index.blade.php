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