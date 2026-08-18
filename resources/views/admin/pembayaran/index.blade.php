<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Pembayaran - RentalKu</title>

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
            font-family: Arial, sans-serif;
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
            overflow: hidden;
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
            white-space: nowrap;
        }

        .badge-status {
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-menunggu {
            background: #fff3cd;
            color: #997404;
        }

        .status-disetujui {
            background: #dff7e8;
            color: #198754;
        }

        .status-ditolak {
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

        .proof-image {
            width: 55px;
            height: 45px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

    </style>

</head>

<body>


{{-- NAVBAR --}}

<nav class="navbar">

    <div class="container py-3">

        <div class="d-flex justify-content-between align-items-center">

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
                    <i class="bi bi-speedometer2"></i>
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
                        <i class="bi bi-box-arrow-right"></i>
                        Keluar
                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>


<div class="container py-5">


    {{-- HEADER --}}

    <div class="mb-4">

        <h2 class="fw-bold mb-1">
            Management Pembayaran
        </h2>

        <p class="text-muted mb-0">
            Kelola dan verifikasi pembayaran pelanggan RentalKu.
        </p>

    </div>


    {{-- ALERT --}}

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


    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- TABLE --}}

    <div class="page-card">

        @if($pembayarans->count())

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
                                Metode
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Jumlah
                            </th>

                            <th>
                                Bukti
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($pembayarans as $pembayaran)

                            <tr>

                                <td class="px-4">

                                    {{ $loop->iteration }}

                                </td>


                                {{-- PELANGGAN --}}

                                <td>

                                    <strong>
                                        {{ $pembayaran->rental->user->name ?? '-' }}
                                    </strong>

                                </td>


                                {{-- MOBIL --}}

                                <td>

                                    {{ $pembayaran->rental->mobil->name ?? '-' }}

                                </td>


                                {{-- METODE --}}

                                <td>

                                  {{ $pembayaran->metodePembayaran->name ?? '-' }}

                                </td>


                                {{-- TANGGAL --}}

                                <td>

                                    {{ $pembayaran->tanggal_bayar?->format('d/m/Y') ?? '-' }}

                                </td>


                                {{-- JUMLAH --}}

                                <td>

                                    <strong>
                                        Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                                    </strong>

                                </td>


                                {{-- BUKTI --}}

                                <td>

                                    @if($pembayaran->bukti)

                                        <a
                                            href="{{ asset('storage/' . $pembayaran->bukti) }}"
                                            target="_blank"
                                        >

                                            <img
                                                src="{{ asset('storage/' . $pembayaran->bukti) }}"
                                                class="proof-image"
                                                alt="Bukti pembayaran"
                                            >

                                        </a>

                                    @else

                                        <span class="text-muted">
                                            Tidak ada
                                        </span>

                                    @endif

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @if($pembayaran->status === 'Menunggu')

                                        <span class="badge-status status-menunggu">
                                            Menunggu
                                        </span>

                                    @elseif($pembayaran->status === 'Disetujui')

                                        <span class="badge-status status-disetujui">
                                            Disetujui
                                        </span>

                                    @else

                                        <span class="badge-status status-ditolak">
                                            Ditolak
                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}

                                <td>

                                    @if($pembayaran->status === 'Menunggu')

                                        <div class="d-flex gap-2">

                                            {{-- SETUJUI --}}

                                            <form
                                                action="{{ route('pembayarans.updateStatus', $pembayaran->id) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                @method('PUT')

                                                <input
                                                    type="hidden"
                                                    name="status"
                                                    value="Disetujui"
                                                >

                                                <button
                                                    type="submit"
                                                    class="btn btn-success btn-sm"
                                                    onclick="return confirm('Setujui pembayaran ini?')"
                                                >

                                                    <i class="bi bi-check-lg"></i>

                                                </button>

                                            </form>


                                            {{-- TOLAK --}}

                                            <form
                                                action="{{ route('pembayarans.updateStatus', $pembayaran->id) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                @method('PUT')

                                                <input
                                                    type="hidden"
                                                    name="status"
                                                    value="Ditolak"
                                                >

                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Tolak pembayaran ini?')"
                                                >

                                                    <i class="bi bi-x-lg"></i>

                                                </button>

                                            </form>

                                        </div>

                                    @else

                                        <span class="text-muted small">
                                            Sudah diverifikasi
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

                <i class="bi bi-credit-card fs-1 text-muted"></i>

                <h5 class="fw-bold mt-3">
                    Belum ada pembayaran
                </h5>

                <p class="text-muted mb-0">
                    Data pembayaran pelanggan akan muncul di sini.
                </p>

            </div>

        @endif

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>