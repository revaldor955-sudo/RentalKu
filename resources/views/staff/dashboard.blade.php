<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Staff - RentalKu</title>

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
            margin: 0;
        }

        .page-content {
            padding: 24px;
        }

        @media (max-width: 1024px) {
            .page-content {
                padding: 16px;
            }
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
            box-shadow: 0 10px 25px rgba(0,0,0,.06);
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
            box-shadow: 0 10px 25px rgba(0,0,0,.07);
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

    </style>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

@include('layouts.partials.staff-sidebar')

{{-- Page Content (dipindah ke #mainContent oleh staff-sidebar) --}}
<div class="page-content">

<div class="container">


<div class="hero">

    <span class="badge bg-light text-success px-3 py-2 mb-3">

        <i class="bi bi-person-check"></i>

        Staff RentalKu

    </span>

    <h1>

        Selamat datang,
        {{ Auth::user()->name }} 👋

    </h1>

    <p class="mt-3 mb-0">

        Kelola operasional RentalKu mulai dari kendaraan,
        rental pelanggan, pembayaran, hingga pemeriksaan kendaraan.

    </p>

</div>


<div class="row g-4 mt-2">

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


    <div class="col-md-6 col-xl-3">

        <div class="stat-card">

            <div class="d-flex justify-content-between">

                <div>

                    <div class="text-muted">
                        Sedang Disewa
                    </div>

                    <div class="stat-number">
                        {{ $mobilDisewa }}
                    </div>

                </div>

                <div class="stat-icon">

                    <i class="bi bi-key"></i>

                </div>

            </div>

        </div>

    </div>


    <div class="col-md-6 col-xl-3">

        <div class="stat-card">

            <div class="d-flex justify-content-between">

                <div>

                    <div class="text-muted">
                        Total Rental
                    </div>

                    <div class="stat-number">
                        {{ $totalRental }}
                    </div>

                </div>

                <div class="stat-icon">

                    <i class="bi bi-calendar-check"></i>

                </div>

            </div>

        </div>

    </div>


    <div class="col-md-6 col-xl-3">

        <div class="stat-card">

            <div class="d-flex justify-content-between">

                <div>

                    <div class="text-muted">
                        Denda Belum Bayar
                    </div>

                    <div class="stat-number text-danger">
                        {{ $unpaidDendasCount ?? 0 }}
                    </div>

                </div>

                <div class="stat-icon">

                    <i class="bi bi-exclamation-triangle"></i>

                </div>

            </div>

        </div>

    </div>


    <div class="col-md-6 col-xl-3">

        <div class="stat-card">

            <div class="d-flex justify-content-between">

                <div>

                    <div class="text-muted">
                        Klaim Diajukan
                    </div>

                    <div class="stat-number text-primary">
                        {{ $claimedKompensasisCount ?? 0 }}
                    </div>

                </div>

                <div class="stat-icon">

                    <i class="bi bi-cash-coin"></i>

                </div>

            </div>

        </div>

    </div>

    </div>

</div>



<section class="mt-5">

    <h3 class="section-title mb-4">
        Perlu Tindakan
    </h3>

    <div class="row g-4">

        <div class="col-md-6 col-lg-4">

            <a
                href="{{ route('rentals.index') }}"
                class="text-decoration-none text-dark"
            >

                <div class="menu-card">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div class="menu-icon mb-0">
                            <i class="bi bi-calendar-check"></i>
                        </div>

                        <span class="badge bg-warning text-dark rounded-pill fs-6">
                            {{ $pendingRentalsCount ?? 0 }}
                        </span>

                    </div>

                    <h5 class="fw-bold">
                        Rental Menunggu
                    </h5>

                    <p class="text-muted mb-3">
                        Pengajuan rental yang perlu disetujui.
                    </p>

                    @forelse($pendingRentals as $rental)

                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">

                            <div>
                                <div class="fw-semibold">
                                    {{ $rental->user->name ?? '-' }}
                                </div>
                                <small class="text-muted">
                                    {{ $rental->mobil->name ?? '-' }} - Mulai {{ $rental->tanggal_mulai?->format('d M Y') }}
                                </small>
                            </div>

                        </div>

                    @empty

                        <p class="text-muted mb-0">
                            Semua beres.
                        </p>

                    @endforelse

                </div>

            </a>

        </div>


        <div class="col-md-6 col-lg-4">

            <a
                href="{{ route('pembayarans.index') }}"
                class="text-decoration-none text-dark"
            >

                <div class="menu-card">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div class="menu-icon mb-0">
                            <i class="bi bi-credit-card"></i>
                        </div>

                        <span class="badge bg-info text-dark rounded-pill fs-6">
                            {{ $pendingPaymentsCount ?? 0 }}
                        </span>

                    </div>

                    <h5 class="fw-bold">
                        Pembayaran Menunggu
                    </h5>

                    <p class="text-muted mb-3">
                        Pembayaran yang perlu diverifikasi.
                    </p>

                    @forelse($pendingPayments as $pembayaran)

                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">

                            <div>
                                <div class="fw-semibold">
                                    {{ $pembayaran->rental->user->name ?? '-' }}
                                </div>
                                <small class="text-muted">
                                    Rp {{ number_format($pembayaran->jumlah ?? 0, 0, ',', '.') }} - {{ $pembayaran->tanggal_bayar?->format('d M Y') }}
                                </small>
                            </div>

                        </div>

                    @empty

                        <p class="text-muted mb-0">
                            Semua beres.
                        </p>

                    @endforelse

                </div>

            </a>

        </div>


        <div class="col-md-6 col-lg-4">

            <a
                href="{{ route('pengembalian.index') }}"
                class="text-decoration-none text-dark"
            >

                <div class="menu-card">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div class="menu-icon mb-0">
                            <i class="bi bi-arrow-return-left"></i>
                        </div>

                        <span class="badge bg-danger rounded-pill fs-6">
                            {{ $returnDueRentals->count() }}
                        </span>

                    </div>

                    <h5 class="fw-bold">
                        Perlu Dikembalikan
                    </h5>

                    <p class="text-muted mb-3">
                        Sewa yang harus sudah kembali.
                    </p>

                    @forelse($returnDueRentals as $rental)

                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">

                            <div>
                                <div class="fw-semibold">
                                    {{ $rental->user->name ?? '-' }}
                                </div>
                                <small class="text-muted">
                                    {{ $rental->mobil->name ?? '-' }} -
                                    @if($rental->tanggal_selesai?->isToday())
                                        Hari ini
                                    @else
                                        <span class="text-danger">Terlambat {{ $rental->tanggal_selesai?->diffInDays(today()) }} hari</span>
                                    @endif
                                </small>
                            </div>

                        </div>

                    @empty

                        <p class="text-muted mb-0">
                            Semua beres.
                        </p>

                    @endforelse

                </div>

            </a>

        </div>

    </div>

</section>


<section class="mt-5">

    <h3 class="section-title mb-4">
        Mobil Terbaru
    </h3>

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
                                    <strong>
                                        {{ $mobil->name }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $mobil->tahun }}
                                </td>

                                <td>
                                    Rp {{ number_format($mobil->harga_perhari, 0, ',', '.') }}
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

            <div class="text-center py-5">

                <i class="bi bi-car-front fs-1 text-muted"></i>

                <h5 class="fw-bold mt-3">
                    Belum ada data mobil
                </h5>

                <p class="text-muted mb-0">
                    Data mobil akan muncul setelah ditambahkan.
                </p>

            </div>

        @endif

    </div>

</section>


<section class="mt-5">

    <h3 class="section-title mb-4">
        Transaksi Terakhir
    </h3>

    <div class="table-card">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead>
                    <tr>
                        <th>Pelanggan</th>
                        <th>Mobil</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($latestRentals as $rental)

                        <tr>
                            <td>{{ $rental->user->name ?? '-' }}</td>
                            <td>{{ $rental->mobil->name ?? '-' }}</td>
                            <td>Rp {{ number_format($rental->total_harga ?? 0, 0, ',', '.') }}</td>
                            <td>
                                @if($rental->status === 'Menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($rental->status === 'Disetujui')
                                    <span class="badge bg-primary">Disetujui</span>
                                @elseif($rental->status === 'Ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($rental->status === 'Selesai')
                                    <span class="badge bg-secondary">Selesai</span>
                                @else
                                    <span class="badge bg-dark">{{ $rental->status }}</span>
                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Belum ada transaksi.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</section>


</div>


@include('layouts.partials.admin-footer', ['pageTitle' => 'Staff Dashboard'])

{{-- Bootstrap JS (dibutuhkan modal) --}}

</div>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>