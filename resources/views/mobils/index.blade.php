<h1>Data Mobil</h1>

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

<form action="{{ route('mobils.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <select name="brand_id">
        <option value="">Pilih Brand</option>
        @foreach ($brands as $brand)
            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
        @endforeach
    </select>

    <select name="tipe_mobil_id">
        <option value="">Pilih Tipe Mobil</option>
        @foreach ($tipeMobils as $tipeMobil)
            <option value="{{ $tipeMobil->id }}">{{ $tipeMobil->name }}</option>
        @endforeach
    </select>

    <select name="cabang_id">
        <option value="">Pilih Cabang</option>
        @foreach ($cabangs as $cabang)
            <option value="{{ $cabang->id }}">{{ $cabang->name }}</option>
        @endforeach
    </select>

    <input type="text" name="name" placeholder="Nama Mobil">
    <input type="text" name="plate_number" placeholder="Plat Nomor">
    <input type="number" name="tahun" placeholder="Tahun">
    <select name="transmisi">
        <option value="">Pilih Transmisi</option>
        <option value="Manual">Manual</option>
        <option value="Matic">Matic</option>
    </select>
    <input type="number" name="kapasitas" placeholder="Kapasitas">
    <input type="text" name="warna" placeholder="Warna">
    <input type="number" name="harga_perhari" step="0.01" placeholder="Harga Per Hari">
    <input type="number" name="deposit" step="0.01" placeholder="Deposit">
    <input type="file" name="image">
    <select name="status">
        <option value="Tersedia">Tersedia</option>
        <option value="Disewa">Disewa</option>
        <option value="Maintenance">Maintenance</option>
    </select>
    <textarea name="description" placeholder="Deskripsi"></textarea>

    <p>Fasilitas:</p>
    @foreach ($fasilitas as $fasilitasItem)
        <label>
            <input type="checkbox" name="fasilitas[]" value="{{ $fasilitasItem->id }}">
            {{ $fasilitasItem->name }}
        </label>
    @endforeach

    <button type="submit">Simpan</button>
</form>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Brand</th>
            <th>Tipe</th>
            <th>Cabang</th>
            <th>Plat Nomor</th>
            <th>Tahun</th>
            <th>Transmisi</th>
            <th>Harga Per Hari</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($mobils as $mobil)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $mobil->name }}</td>
                <td>{{ $mobil->brand->name }}</td>
                <td>{{ $mobil->tipeMobil->name }}</td>
                <td>{{ $mobil->cabang->name }}</td>
                <td>{{ $mobil->plate_number }}</td>
                <td>{{ $mobil->tahun }}</td>
                <td>{{ $mobil->transmisi }}</td>
                <td>{{ $mobil->harga_perhari }}</td>
                <td>{{ $mobil->status }}</td>

                <td>
                    <form action="{{ route('mobils.destroy', $mobil->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>