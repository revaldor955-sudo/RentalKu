<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Rental - RentalKu</title>

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
            background: #f6f8f7;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #eee;
        }

        .brand {
            font-size: 25px;
            font-weight: 800;
            color: #1f2937;
            text-decoration: none;
        }

        .brand span {
            color: #198754;
        }

        .page-title {
            font-weight: 800;
            color: #1f2937;
        }

        .card-custom {
            background: white;
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0,0,0,.05);
        }

        .table th {
            font-size: 13px;
            color: #6b7280;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-menunggu {
            background: #fff3cd;
            color: #856404;
        }

        .status-disetujui {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #842029;
        }

        .status-selesai {
            background: #cff4fc;
            color: #055160;
        }

        .btn-action {
            border-radius: 9px;
            font-size: 12px;
            font-weight: 600;
        }

        .empty {
            padding: 50px;
            text-align: center;
            color: #6b7280;
        }
    </style>
</head>

<body>

{{-- NAVBAR --}}
<nav class="navbar">
    <div class="container py-3">

        <div class="d-flex align-items-center justify-content-between">

            <a href="{{ route('admin.dashboard') }}" class="brand">
                Rental<span>Ku</span>.
            </a>

            <div class="d-flex align-items-center gap-3">

                <span>
                    <i class="bi bi-person-circle"></i>
                    {{ Auth::user()->name }}
                </span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i>
                        Keluar
                    </button>
                </form>

            </div>

        </div>

    </div>
</nav>


<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="page-title mb-1">
                Management Rental
            </h2>

            <p class="text-muted mb-0">
                Kelola pengajuan sewa mobil pelanggan.
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left me-1"></i>
            Dashboard

        </a>

    </div>


    {{-- ALERT SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ALERT ERROR --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            <i class="bi bi-exclamation-circle-fill me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- TABLE --}}
    <div class="card-custom">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

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
                                Tanggal Sewa
                            </th>

                            <th>
                                Hari
                            </th>

                            <th>
                                Total
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

                        @forelse($rentals as $rental)

                            <tr>

                                <td class="px-4">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- PELANGGAN --}}
                                <td>

                                    <div class="fw-bold">
                                        {{ $rental->user->name ?? '-' }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $rental->user->email ?? '-' }}
                                    </small>

                                </td>


                                {{-- MOBIL --}}
                                <td>

                                    <div class="fw-bold">
                                        {{ $rental->mobil->name ?? '-' }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $rental->mobil->plate_number ?? '-' }}
                                    </small>

                                </td>


                                {{-- TANGGAL --}}
                                <td>

                                    {{ $rental->tanggal_mulai->format('d/m/Y') }}

                                    <br>

                                    <small class="text-muted">
                                        s/d
                                        {{ $rental->tanggal_selesai->format('d/m/Y') }}
                                    </small>

                                </td>


                                {{-- JUMLAH HARI --}}
                                <td>

                                    {{ $rental->jumlah_hari }}

                                    hari

                                </td>


                                {{-- TOTAL --}}
                                <td>

                                    <strong>
                                        Rp {{ number_format($rental->total_harga, 0, ',', '.') }}
                                    </strong>

                                </td>


                                {{-- STATUS --}}
                                <td>

                                    @if($rental->status === 'Menunggu')

                                        <span class="status status-menunggu">
                                            Menunggu
                                        </span>

                                    @elseif($rental->status === 'Disetujui')

                                        <span class="status status-disetujui">
                                            Disetujui
                                        </span>

                                    @elseif($rental->status === 'Ditolak')

                                        <span class="status status-ditolak">
                                            Ditolak
                                        </span>

                                    @elseif($rental->status === 'Selesai')

                                        <span class="status status-selesai">
                                            Selesai
                                        </span>

                                    @else

                                        <span class="status bg-secondary text-white">
                                            {{ $rental->status }}
                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}
                                <td>

                                    @if($rental->status === 'Menunggu')

                                        <div class="d-flex gap-2">

                                            {{-- SETUJUI --}}
                                            <form
                                                action="{{ route('rentals.updateStatus', $rental->id) }}"
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
                                                    class="btn btn-success btn-sm btn-action"
                                                    onclick="return confirm('Setujui pengajuan rental ini?')"
                                                >

                                                    <i class="bi bi-check-lg"></i>
                                                    Setujui

                                                </button>

                                            </form>


                                            {{-- TOLAK --}}
                                            <form
                                                action="{{ route('rentals.updateStatus', $rental->id) }}"
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
                                                    class="btn btn-outline-danger btn-sm btn-action"
                                                    onclick="return confirm('Tolak pengajuan rental ini?')"
                                                >

                                                    <i class="bi bi-x-lg"></i>
                                                    Tolak

                                                </button>

                                            </form>

                                        </div>


                                    @elseif($rental->status === 'Disetujui')

                                        {{-- SELESAIKAN --}}
                                        <form
                                            action="{{ route('rentals.updateStatus', $rental->id) }}"
                                            method="POST"
                                        >

                                            @csrf
                                            @method('PUT')

                                            <input
                                                type="hidden"
                                                name="status"
                                                value="Selesai"
                                            >

                                            <button
                                                type="submit"
                                                class="btn btn-primary btn-sm btn-action"
                                                onclick="return confirm('Selesaikan rental ini?')"
                                            >

                                                <i class="bi bi-check2-circle"></i>
                                                Selesaikan

                                            </button>

                                        </form>


                                    @elseif($rental->status === 'Ditolak')

                                        <span class="text-muted">
                                            Tidak ada aksi
                                        </span>


                                    @elseif($rental->status === 'Selesai')

                                        <span class="text-muted">
                                            Selesai
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8">

                                    <div class="empty">

                                        <i class="bi bi-car-front fs-1"></i>

                                        <h5 class="mt-3">
                                            Belum ada rental
                                        </h5>

                                        <p class="mb-0">
                                            Belum ada pengajuan sewa mobil dari pelanggan.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>
