<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin - RentalKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        body {
            background: #f5f7f6;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #e9ecef;
        }

        .brand {
            font-size: 25px;
            font-weight: 800;
            color: #1f2937;
        }

        .brand span {
            color: #198754;
        }

        .profile {
            background: #f3f7f5;
            border-radius: 12px;
            padding: 8px 14px;
        }

        .profile-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #198754;
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero {
            margin-top: 30px;
            padding: 40px;

            border-radius: 24px;

            background: linear-gradient(
                135deg,
                #212529,
                #198754
            );

            color: white;

            box-shadow: 0 12px 30px rgba(0,0,0,.12);
        }

        .hero h1 {
            font-size: 35px;
            font-weight: 800;
        }

        .hero p {
            color: #dcefe4;
            max-width: 700px;
        }

        .hero-icon {
            font-size: 120px;
            opacity: .12;
        }

        .stat-card {
            background: white;
            border-radius: 18px;
            border: 1px solid #edf0ee;

            padding: 23px;

            height: 100%;

            transition: .25s;
        }

        .stat-card:hover {
            transform: translateY(-4px);

            box-shadow:
                0 10px 25px rgba(0,0,0,.06);
        }

        .stat-icon {
            width: 53px;
            height: 53px;

            border-radius: 15px;

            background: #e9f7ef;
            color: #198754;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 23px;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 800;
        }

        .section-title {
            font-weight: 800;
            color: #1f2937;
        }

        .menu-card {
            background: white;

            border: 1px solid #edf0ee;

            border-radius: 18px;

            padding: 24px;

            height: 100%;

            transition: .25s;
        }

        .menu-card:hover {
            transform: translateY(-5px);

            box-shadow:
                0 10px 25px rgba(0,0,0,.07);

            border-color: #198754;
        }

        .menu-icon {
            width: 55px;
            height: 55px;

            border-radius: 15px;

            background: #e9f7ef;
            color: #198754;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 24px;
        }

        .menu-card.disabled {
            opacity: .55;
            cursor: not-allowed;
        }

        .menu-card.disabled:hover {
            transform: none;
            box-shadow: none;
            border-color: #edf0ee;
        }

        .table-card {
            background: white;

            border-radius: 20px;

            border: 1px solid #edf0ee;

            overflow: hidden;
        }

        .table thead th {
            background: #f8faf9;

            color: #6c757d;

            font-size: 12px;

            text-transform: uppercase;

            border-bottom: 1px solid #e9ecef;

            white-space: nowrap;
        }

        .badge-status {
            padding: 7px 12px;

            border-radius: 20px;

            font-size: 12px;

            font-weight: 600;
        }

        .status-tersedia {
            background: #dff7e8;
            color: #198754;
        }

        .status-disewa {
            background: #fff3cd;
            color: #997404;
        }

        .status-maintenance {
            background: #f8d7da;
            color: #b02a37;
        }

        .btn-green {
            background: #198754;

            color: white;

            border-radius: 10px;

            font-weight: 600;
        }

        .btn-green:hover {
            background: #146c43;
            color: white;
        }

        footer {
            margin-top: 70px;
        }

    </style>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>


<body>


@include('layouts.partials.admin-navbar')



<div class="container">


<div class="hero">

    <div class="row align-items-center">

        <div class="col-lg-8">

            <span
                class="badge bg-light text-success px-3 py-2 mb-3"
            >

                <i class="bi bi-shield-check"></i>

                Administrator

            </span>


            <h1>

                Selamat datang,
                {{ Auth::user()->name }} 👋

            </h1>


            <p class="mt-3 mb-4">

                Kelola seluruh sistem RentalKu melalui
                dashboard administrator. Mulai dari kendaraan,
                pengguna, fasilitas, promo, banner hingga
                operasional rental.

            </p>

        </div>


        <div class="col-lg-4 text-center d-none d-lg-block">

            <i class="bi bi-speedometer2 hero-icon"></i>

        </div>

    </div>

</div>



<div class="row g-4 mt-2">


    {{-- USERS --}}

    <div class="col-md-6 col-xl-3">

        <div class="stat-card">

            <div class="d-flex justify-content-between">

                <div>

                    <div class="text-muted">
                        Total Pengguna
                    </div>

                    <div class="stat-number">
                        {{ $totalUsers }}
                    </div>

                </div>

                <div class="stat-icon">

                    <i class="bi bi-people"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- MOBIL --}}

    <div class="col-md-6 col-xl-3">

        <div class="stat-card">

            <div class="d-flex justify-content-between">

                <div>

                    <div class="text-muted">
                        Total Mobil
                    </div>

                    <div class="stat-number">
                        {{ $totalMobils }}
                    </div>

                </div>

                <div class="stat-icon">

                    <i class="bi bi-car-front"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- TERSEDIA --}}

    <div class="col-md-6 col-xl-3">

        <div class="stat-card">

            <div class="d-flex justify-content-between">

                <div>

                    <div class="text-muted">
                        Mobil Tersedia
                    </div>

                    <div class="stat-number text-success">
                        {{ $mobilTersedia }}
                    </div>

                </div>

                <div class="stat-icon">

                    <i class="bi bi-check-circle"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- CABANG --}}

    <div class="col-md-6 col-xl-3">

        <div class="stat-card">

            <div class="d-flex justify-content-between">

                <div>

                    <div class="text-muted">
                        Total Cabang
                    </div>

                    <div class="stat-number">
                        {{ $totalCabang }}
                    </div>

                </div>

                <div class="stat-icon">

                    <i class="bi bi-building"></i>

                </div>

            </div>

        </div>

    </div>

</div>



<div class="row g-4 mt-2">


    <div class="col-md-4">

        <div class="stat-card">

            <div class="d-flex align-items-center gap-3">

                <div class="stat-icon">

                    <i class="bi bi-check-circle"></i>

                </div>

                <div>

                    <div class="text-muted">
                        Tersedia
                    </div>

                    <div class="stat-number text-success">
                        {{ $mobilTersedia }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <div class="stat-card">

            <div class="d-flex align-items-center gap-3">

                <div class="stat-icon">

                    <i class="bi bi-key"></i>

                </div>

                <div>

                    <div class="text-muted">
                        Sedang Disewa
                    </div>

                    <div class="stat-number">
                        {{ $mobilDisewa }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <div class="stat-card">

            <div class="d-flex align-items-center gap-3">

                <div class="stat-icon">

                    <i class="bi bi-tools"></i>

                </div>

                <div>

                    <div class="text-muted">
                        Maintenance
                    </div>

                    <div class="stat-number">
                        {{ $mobilMaintenance }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<section class="mt-5">

    <h3 class="section-title mb-4">

        Management Sistem

    </h3>


    <div class="row g-4">
        {{-- 2. MOBIL --}}

        <div class="col-md-6 col-lg-3">

            <a
                href="{{ route('mobils.index') }}"
                class="text-decoration-none text-dark"
            >

                <div class="menu-card">

                    <div class="menu-icon mb-3">

                        <i class="bi bi-car-front"></i>

                    </div>

                    <h5 class="fw-bold">
                        Management Mobil
                    </h5>

                    <p class="text-muted mb-0">
                        Kelola seluruh data kendaraan.
                    </p>

                </div>

            </a>

        </div>


        {{-- 3. KATEGORI & MEREK --}}

        <div class="col-md-6 col-lg-3">

            <a
                href="{{ route('brands.index') }}"
                class="text-decoration-none text-dark"
            >

                <div class="menu-card">

                    <div class="menu-icon mb-3">

                        <i class="bi bi-tags"></i>

                    </div>

                    <h5 class="fw-bold">
                        Kategori & Merek
                    </h5>

                    <p class="text-muted mb-0">
                        Kelola tipe dan merek mobil.
                    </p>

                </div>

            </a>

        </div>


        {{-- 4. FASILITAS --}}

        <div class="col-md-6 col-lg-3">

            <a
                href="{{ route('fasilitas.index') }}"
                class="text-decoration-none text-dark"
            >

                <div class="menu-card">

                    <div class="menu-icon mb-3">

                        <i class="bi bi-stars"></i>

                    </div>

                    <h5 class="fw-bold">
                        Management Fasilitas
                    </h5>

                    <p class="text-muted mb-0">
                        Kelola fasilitas kendaraan.
                    </p>

                </div>

            </a>

        </div>


       {{-- 5. PENGGUNA --}}

<div class="col-md-6 col-lg-3">

    <a
        href="{{ route('users.index') }}"
        class="text-decoration-none text-dark"
    >

        <div class="menu-card">

            <div class="menu-icon mb-3">

                <i class="bi bi-people"></i>

            </div>

            <h5 class="fw-bold">
                Management Pengguna
            </h5>

            <p class="text-muted mb-0">
                Kelola akun pengguna RentalKu.
            </p>

        </div>

    </a>

</div>


        {{-- 6. PROMO --}}

        <div class="col-md-6 col-lg-3">

            <a
                href="{{ route('kupons.index') }}"
                class="text-decoration-none text-dark"
            >

                <div class="menu-card">

                    <div class="menu-icon mb-3">

                        <i class="bi bi-ticket-perforated"></i>

                    </div>

                    <h5 class="fw-bold">
                        Management Promo
                    </h5>

                    <p class="text-muted mb-0">
                        Kelola promo dan kupon.
                    </p>

                </div>

            </a>

        </div>


        {{-- 7. BANNER --}}

        <div class="col-md-6 col-lg-3">

            <a
                href="{{ route('banners.index') }}"
                class="text-decoration-none text-dark"
            >

                <div class="menu-card">

                    <div class="menu-icon mb-3">

                        <i class="bi bi-images"></i>

                    </div>

                    <h5 class="fw-bold">
                        Management Banner
                    </h5>

                    <p class="text-muted mb-0">
                        Kelola banner halaman utama.
                    </p>

                </div>

            </a>

        </div>

        {{-- 8. RENTAL --}}

<div class="col-md-6 col-lg-3">

    <a
        href="{{ route('rentals.index') }}"
        class="text-decoration-none text-dark"
    >

        <div class="menu-card">

            <div class="menu-icon mb-3">

                <i class="bi bi-car-front-fill"></i>

            </div>

            <h5 class="fw-bold">
                Management Rental
            </h5>

            <p class="text-muted mb-0">
                Kelola pengajuan sewa mobil pelanggan.
            </p>

        </div>

    </a>

</div>

        {{-- 9. PEMBAYARAN --}}

        <div class="col-md-6 col-lg-3">

    <a
        href="{{ route('pembayarans.index') }}"
        class="text-decoration-none text-dark"
    >

        <div class="menu-card">

            <div class="menu-icon mb-3">

                <i class="bi bi-credit-card"></i>

            </div>

            <h5 class="fw-bold">
                Management Pembayaran
            </h5>

            <p class="text-muted mb-0">
                Kelola pembayaran rental pelanggan.
            </p>

        </div>

    </a>

</div>

        {{-- 10. PENGEMBALIAN --}}

      <div class="col-md-6 col-lg-3">

    <a
        href="{{ route('pengembalian.index') }}"
        class="text-decoration-none text-dark"
    >

        <div class="menu-card">

            <div class="menu-icon mb-3">

                <i class="bi bi-arrow-return-left"></i>

            </div>

            <h5 class="fw-bold">
                Pengembalian Mobil
            </h5>

            <p class="text-muted mb-0">
                Kelola proses pengembalian kendaraan.
            </p>

        </div>

    </a>

</div>


        {{-- 11. PEMERIKSAAN KENDARAAN --}}

<div class="col-md-6 col-lg-3">

    <a
        href="{{ route('pemeriksaan-kendaraan.index') }}"
        class="text-decoration-none text-dark"
    >

        <div class="menu-card">

            <div class="menu-icon mb-3">

                <i class="bi bi-clipboard-check"></i>

            </div>

            <h5 class="fw-bold">
                Pemeriksaan Kendaraan
            </h5>

            <p class="text-muted mb-0">
                Pemeriksaan kondisi kendaraan.
            </p>

        </div>

    </a>

</div>


        {{-- 12. LAPORAN --}}

<div class="col-md-6 col-lg-3">

    <a
        href="{{ route('laporan.index') }}"
        class="text-decoration-none text-dark"
    >

        <div class="menu-card">

            <div class="menu-icon mb-3">

                <i class="bi bi-file-earmark-bar-graph"></i>

            </div>

            <h5 class="fw-bold">
                Laporan
            </h5>

            <p class="text-muted mb-0">
                Laporan aktivitas RentalKu.
            </p>

        </div>

    </a>

</div>

    </div>

</section>



<section class="mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="section-title mb-1">
                Mobil Terbaru
            </h3>

            <p class="text-muted mb-0">
                Kendaraan terbaru yang ditambahkan.
            </p>

        </div>


        <a
            href="{{ route('mobils.index') }}"
            class="btn btn-green"
        >

            Lihat Semua

            <i class="bi bi-arrow-right ms-1"></i>

        </a>

    </div>


    <div class="table-card">

        @if($mobils->count())

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>

                            <th class="px-4 py-3">
                                Mobil
                            </th>

                            <th>
                                Brand
                            </th>

                            <th>
                                Cabang
                            </th>

                            <th>
                                Tahun
                            </th>

                            <th>
                                Harga / Hari
                            </th>

                            <th>
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($mobils as $mobil)

                            <tr>

                                <td class="px-4">

                                    <div class="d-flex align-items-center gap-3">

                                        @if($mobil->image)

                                            <img
                                                src="{{ asset($mobil->image) }}"
                                                width="55"
                                                height="42"
                                                style="object-fit:cover;border-radius:10px;"
                                                alt="{{ $mobil->name }}"
                                            >

                                        @else

                                            <div
                                                class="bg-light d-flex align-items-center justify-content-center"
                                                style="width:55px;height:42px;border-radius:10px;"
                                            >

                                                <i class="bi bi-car-front text-secondary"></i>

                                            </div>

                                        @endif


                                        <strong>
                                            {{ $mobil->name }}
                                        </strong>

                                    </div>

                                </td>


                                <td>

                                    {{ $mobil->brand->name ?? '-' }}

                                </td>


                                <td>

                                    {{ $mobil->cabang->name ?? '-' }}

                                </td>


                                <td>

                                    {{ $mobil->tahun }}

                                </td>


                                <td>

                                    Rp
                                    {{ number_format($mobil->harga_perhari, 0, ',', '.') }}

                                </td>


                                <td>

                                    @if($mobil->status === 'Tersedia')

                                        <span class="badge-status status-tersedia">
                                            Tersedia
                                        </span>

                                    @elseif($mobil->status === 'Disewa')

                                        <span class="badge-status status-disewa">
                                            Disewa
                                        </span>

                                    @else

                                        <span class="badge-status status-maintenance">
                                            Maintenance
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="text-center p-5">

                <i class="bi bi-car-front fs-1 text-muted"></i>

                <h5 class="fw-bold mt-3">
                    Belum ada data mobil
                </h5>

                <p class="text-muted">
                    Data mobil akan muncul setelah ditambahkan.
                </p>

            </div>

        @endif

    </div>

</section>



<section class="mt-5">

    <div class="mb-4">

        <h3 class="section-title mb-1">
            Pengguna Terbaru
        </h3>

        <p class="text-muted mb-0">
            Pengguna terbaru yang terdaftar di RentalKu.
        </p>

    </div>


    <div class="table-card">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead>

                    <tr>

                        <th class="px-4 py-3">
                            Pengguna
                        </th>

                        <th>
                            Email
                        </th>

                        <th>
                            Role
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($users as $user)

                        <tr>

                            <td class="px-4">

                                <strong>
                                    {{ $user->name }}
                                </strong>

                            </td>


                            <td>

                                {{ $user->email }}

                            </td>


                            <td>

                                @if($user->roles_id == 1)

                                    <span class="badge bg-dark">
                                        Admin
                                    </span>

                                @elseif($user->roles_id == 2)

                                    <span class="badge bg-primary">
                                        Staff
                                    </span>

                                @else

                                    <span class="badge bg-success">
                                        Customer
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="3"
                                class="text-center text-muted py-4"
                            >

                                Belum ada pengguna.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</section>


</div>



@include('layouts.partials.admin-footer', ['pageTitle' => 'Administrator Dashboard'])


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>
