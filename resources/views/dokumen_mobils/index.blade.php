<h1>Data Dokumen Mobil</h1>

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

<form action="{{ route('dokumen_mobils.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <select name="mobil_id">
        <option value="">Pilih Mobil</option>
        @foreach ($mobils as $mobil)
            <option value="{{ $mobil->id }}">{{ $mobil->name }} ({{ $mobil->plate_number }})</option>
        @endforeach
    </select>

    <select name="jenis">
        <option value="">Pilih Jenis Dokumen</option>
        <option value="stnk">STNK</option>
        <option value="asuransi">Asuransi</option>
        <option value="bpkb">BPKB</option>
    </select>

    <input type="text" name="nomor_dokumen" placeholder="Nomor Dokumen">
    <input type="date" name="berlaku_sampai">
    <input type="file" name="file">

    <button type="submit">Simpan</button>
</form>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Mobil</th>
            <th>Jenis</th>
            <th>Nomor Dokumen</th>
            <th>Berlaku Sampai</th>
            <th>File</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($dokumenMobils as $dokumenMobil)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $dokumenMobil->mobil->name ?? '-' }}</td>
                <td>{{ strtoupper($dokumenMobil->jenis) }}</td>
                <td>{{ $dokumenMobil->nomor_dokumen }}</td>
                <td>{{ $dokumenMobil->berlaku_sampai }}</td>
                <td>
                    @if ($dokumenMobil->file)
                        <a href="{{ asset($dokumenMobil->file) }}" target="_blank">Lihat</a>
                    @endif
                </td>

                <td>
                    <form action="{{ route('dokumen_mobils.destroy', $dokumenMobil->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>