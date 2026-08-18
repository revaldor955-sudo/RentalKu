<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Booking - RentalKu</title>

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
            font-family: Arial, Helvetica, sans-serif;
            color: #1f2937;
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

        .page-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #edf0ee;
            box-shadow: 0 8px 25px rgba(0,0,0,.04);
            overflow: hidden;
        }

        .btn-green {
            background: #198754;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-green:hover {
            background: #146c43;
            color: white;
        }

        .table thead th {
            background: #f8faf9;
            color: #6c757d;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
            border-bottom: 1px solid #e9ecef;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .status {
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-menunggu {
            background: #fff3cd;
            color: #997404;
        }

        .status-dikonfirmasi {
            background: #dff7e8;
            color: #198754;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #b02a37;
        }

        .status-selesai {
            background: #e7f1ff;
            color: #0d6efd;
        }

        .status-dibatalkan {
            background: #e9ecef;
            color: #495057;
        }

        .empty-icon {
            font-size: 60px;
            color: #adb5bd;
        }

    </style>

</head>


<body>


{{-- NAVBAR --}}

<nav class="navbar">

    <div class="container py-3">

        <div class="d-flex justify-content-between align-items-center w-100">

            <a
                href="{{ route('admin.dashboard') }}"
                class="text-decoration-none brand"
            >
                Rental<span>ku</span>.
            </a>


            <div class="d-flex gap-2">

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="btn btn-outline-secondary btn-sm"
                >
                    <i class="bi bi-speedometer2 me-1"></i>
                    Dashboard
                </a>


                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-outline-danger btn-sm"
                    >
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Keluar
                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>



<div class="container py-5">


{{-- HEADER --}}

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-1">
            Management Booking
        </h2>

        <p class="text-muted mb-0">
            Kelola seluruh pemesanan kendaraan RentalKu.
        </p>

    </div>

</div>



{{-- ALERT SUCCESS --}}

@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show">

        <i class="bi bi-check-circle me-2"></i>

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

    </div>

@endif



{{-- ALERT ERROR --}}

@if(session('error'))

    <div class="alert alert-danger alert-dismissible fade show">

        <i class="bi bi-exclamation-circle me-2"></i>

        {{ session('error') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

    </div>

@endif



{{-- DATA BOOKING --}}

<div class="page-card">

    @if(isset($bookings) && $bookings->count())

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead>

                    <tr>

                        <th class="px-4 py-3">
                            #
                        </th>

                        <th>
                            Pelanggan
                        </th>

                        <th>
                            Mobil
                        </th>

                        <th>
                            Tanggal Mulai
                        </th>

                        <th>
                            Tanggal Selesai
                        </th>

                        <th>
                            Total
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($bookings as $booking)

                        <tr>

                            {{-- NO --}}

                            <td class="px-4">
                                {{ $loop->iteration }}
                            </td>


                            {{-- PELANGGAN --}}

                            <td>

                                <strong>

                                    {{ $booking->user->name
                                        ?? $booking->user->nama
                                        ?? $booking->nama_pelanggan
                                        ?? $booking->nama
                                        ?? '-' }}

                                </strong>

                                @if(isset($booking->user->email))

                                    <div class="small text-muted">

                                        {{ $booking->user->email }}

                                    </div>

                                @endif

                            </td>


                            {{-- MOBIL --}}

                            <td>

                                <strong>

                                    {{ $booking->mobil->name
                                        ?? $booking->mobil->nama
                                        ?? $booking->nama_mobil
                                        ?? $booking->mobil_name
                                        ?? '-' }}

                                </strong>

                            </td>


                            {{-- TANGGAL MULAI --}}

                            <td>

                                @if(isset($booking->tanggal_mulai))

                                    {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }}

                                @elseif(isset($booking->tgl_mulai))

                                    {{ \Carbon\Carbon::parse($booking->tgl_mulai)->format('d M Y') }}

                                @elseif(isset($booking->start_date))

                                    {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}

                                @else

                                    -

                                @endif

                            </td>


                            {{-- TANGGAL SELESAI --}}

                            <td>

                                @if(isset($booking->tanggal_selesai))

                                    {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}

                                @elseif(isset($booking->tgl_selesai))

                                    {{ \Carbon\Carbon::parse($booking->tgl_selesai)->format('d M Y') }}

                                @elseif(isset($booking->end_date))

                                    {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}

                                @else

                                    -

                                @endif

                            </td>


                            {{-- TOTAL --}}

                            <td>

                                @if(isset($booking->total_harga))

                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}

                                @elseif(isset($booking->total))

                                    Rp {{ number_format($booking->total, 0, ',', '.') }}

                                @else

                                    -

                                @endif

                            </td>


                            {{-- STATUS --}}

                            <td>

                                @php

                                    $status = strtolower(
                                        $booking->status ?? 'menunggu'
                                    );

                                @endphp


                                @if($status === 'menunggu')

                                    <span class="status status-menunggu">
                                        Menunggu
                                    </span>

                                @elseif($status === 'dikonfirmasi')

                                    <span class="status status-dikonfirmasi">
                                        Dikonfirmasi
                                    </span>

                                @elseif($status === 'ditolak')

                                    <span class="status status-ditolak">
                                        Ditolak
                                    </span>

                                @elseif($status === 'selesai')

                                    <span class="status status-selesai">
                                        Selesai
                                    </span>

                                @elseif($status === 'dibatalkan')

                                    <span class="status status-dibatalkan">
                                        Dibatalkan
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        {{ ucfirst($status) }}
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

            <i class="bi bi-calendar-x empty-icon"></i>

            <h5 class="fw-bold mt-3">
                Belum ada booking
            </h5>

            <p class="text-muted mb-0">
                Data pemesanan kendaraan akan muncul di halaman ini.
            </p>

        </div>

    @endif

</div>


</div>



{{-- FOOTER --}}

<footer class="bg-white border-top py-4 mt-5">

    <div class="container text-center">

        <div class="fw-bold">

            Rental<span class="text-success">ku</span>.

        </div>

        <small class="text-muted">

            Management Booking • RentalKu

        </small>

    </div>

</footer>



<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>
