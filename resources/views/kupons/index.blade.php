<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Promo - RentalKu</title>

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
            box-shadow: 0 8px 25px rgba(0,0,0,.04);
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

        .form-control,
        .form-select {
            border-radius: 10px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 .2rem rgba(25,135,84,.12);
        }

        .table thead th {
            background: #f8faf9;
            color: #6c757d;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .code {
            background: #e9f7ef;
            color: #198754;
            padding: 7px 10px;
            border-radius: 8px;
            font-weight: 700;
        }

        .status-active {
            background: #dff7e8;
            color: #198754;
        }

        .status-expired {
            background: #f8d7da;
            color: #b02a37;
        }

        .status-waiting {
            background: #fff3cd;
            color: #997404;
        }

        .status {
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .modal-header {
            background: #198754;
            color: white;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
    </style>
</head>

<body>

@include('layouts.partials.admin-navbar')


<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Management Promo
            </h2>

            <p class="text-muted mb-0">
                Kelola kode promo dan kupon RentalKu.
            </p>
        </div>

        <button
            class="btn btn-green px-3 py-2"
            data-bs-toggle="modal"
            data-bs-target="#tambahModal"
        >
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Promo
        </button>

    </div>


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

            <strong>Terjadi kesalahan:</strong>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    <div class="page-card">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead>
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th>Kode</th>
                        <th>Jenis</th>
                        <th>Nilai</th>
                        <th>Kuota</th>
                        <th>Terpakai</th>
                        <th>Min. Pembelian</th>
                        <th>Aktif</th>
                        <th>Berakhir</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($kupons as $kupon)

                        @php
                            $now = now();

                            if ($now < $kupon->active_at) {
                                $status = 'waiting';
                                $statusText = 'Belum Aktif';
                            } elseif ($now > $kupon->expired_at || $kupon->terpakai >= $kupon->kuota) {
                                $status = 'expired';
                                $statusText = 'Tidak Aktif';
                            } else {
                                $status = 'active';
                                $statusText = 'Aktif';
                            }
                        @endphp

                        <tr>

                            <td class="px-4">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <span class="code">
                                    {{ $kupon->code }}
                                </span>
                            </td>

                            <td>
                                @if($kupon->jenis === 'persen')
                                    <span class="badge bg-primary">
                                        Persen
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        Nominal
                                    </span>
                                @endif
                            </td>

                            <td class="fw-bold">

                                @if($kupon->jenis === 'persen')
                                    {{ number_format($kupon->value, 0, ',', '.') }}%
                                @else
                                    Rp {{ number_format($kupon->value, 0, ',', '.') }}
                                @endif

                            </td>

                            <td>
                                {{ number_format($kupon->kuota) }}
                            </td>

                            <td>
                                {{ number_format($kupon->terpakai) }}
                            </td>

                            <td>
                                Rp {{ number_format($kupon->minimal_pembelian, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="status status-{{ $status }}">
                                    {{ $statusText }}
                                </span>
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($kupon->expired_at)->format('d/m/Y H:i') }}
                            </td>

                            <td>

                                <div class="d-flex justify-content-center gap-2">

                                    <button
                                        class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $kupon->id }}"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <form
                                        action="{{ route('kupons.destroy', $kupon->id) }}"
                                        method="POST"
                                        onsubmit="return confirmSubmit(event, 'Yakin ingin menghapus promo ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="btn btn-danger btn-sm"
                                            type="submit"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                        {{-- MODAL EDIT --}}

                        <div
                            class="modal fade"
                            id="edit{{ $kupon->id }}"
                            tabindex="-1"
                        >

                            <div class="modal-dialog modal-lg modal-dialog-centered">

                                <div class="modal-content">

                                    <div class="modal-header">

                                        <h5 class="modal-title">
                                            <i class="bi bi-pencil-square me-2"></i>
                                            Edit Promo
                                        </h5>

                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"
                                        ></button>

                                    </div>

                                    <form
                                        action="{{ route('kupons.update', $kupon->id) }}"
                                        method="POST"
                                    >

                                        @csrf
                                        @method('PUT')

                                        <div class="modal-body">

                                            <div class="row g-3">

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">
                                                        Kode Promo
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="code"
                                                        class="form-control"
                                                        value="{{ $kupon->code }}"
                                                        required
                                                    >
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">
                                                        Jenis
                                                    </label>

                                                    <select
                                                        name="jenis"
                                                        class="form-select"
                                                        required
                                                    >

                                                        <option
                                                            value="persen"
                                                            {{ $kupon->jenis == 'persen' ? 'selected' : '' }}
                                                        >
                                                            Persentase
                                                        </option>

                                                        <option
                                                            value="nominal"
                                                            {{ $kupon->jenis == 'nominal' ? 'selected' : '' }}
                                                        >
                                                            Nominal
                                                        </option>

                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">
                                                        Nilai Promo
                                                    </label>

                                                    <input
                                                        type="number"
                                                        name="value"
                                                        class="form-control"
                                                        value="{{ $kupon->value }}"
                                                        min="0"
                                                        required
                                                    >
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">
                                                        Kuota
                                                    </label>

                                                    <input
                                                        type="number"
                                                        name="kuota"
                                                        class="form-control"
                                                        value="{{ $kupon->kuota }}"
                                                        min="1"
                                                        required
                                                    >
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">
                                                        Terpakai
                                                    </label>

                                                    <input
                                                        type="number"
                                                        name="terpakai"
                                                        class="form-control"
                                                        value="{{ $kupon->terpakai }}"
                                                        min="0"
                                                        required
                                                    >
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">
                                                        Minimal Pembelian
                                                    </label>

                                                    <input
                                                        type="number"
                                                        name="minimal_pembelian"
                                                        class="form-control"
                                                        value="{{ $kupon->minimal_pembelian }}"
                                                        min="0"
                                                        required
                                                    >
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">
                                                        Mulai Aktif
                                                    </label>

                                                    <input
                                                        type="datetime-local"
                                                        name="active_at"
                                                        class="form-control"
                                                        value="{{ \Carbon\Carbon::parse($kupon->active_at)->format('Y-m-d\TH:i') }}"
                                                        required
                                                    >
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">
                                                        Tanggal Berakhir
                                                    </label>

                                                    <input
                                                        type="datetime-local"
                                                        name="expired_at"
                                                        class="form-control"
                                                        value="{{ \Carbon\Carbon::parse($kupon->expired_at)->format('Y-m-d\TH:i') }}"
                                                        required
                                                    >
                                                </div>

                                            </div>

                                        </div>

                                        <div class="modal-footer">

                                            <button
                                                type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal"
                                            >
                                                Batal
                                            </button>

                                            <button
                                                type="submit"
                                                class="btn btn-green"
                                            >
                                                <i class="bi bi-save me-1"></i>
                                                Simpan
                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                    @empty

                        <tr>
                            <td
                                colspan="10"
                                class="text-center py-5"
                            >
                                <i class="bi bi-ticket-perforated fs-1 text-muted"></i>

                                <h5 class="fw-bold mt-3">
                                    Belum ada promo
                                </h5>

                                <p class="text-muted mb-0">
                                    Silakan tambahkan promo baru.
                                </p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- MODAL TAMBAH --}}

<div
    class="modal fade"
    id="tambahModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    <i class="bi bi-ticket-perforated me-2"></i>
                    Tambah Promo
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <form
                action="{{ route('kupons.store') }}"
                method="POST"
            >

                @csrf

                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label fw-bold">
                                Kode Promo
                            </label>

                            <input
                                type="text"
                                name="code"
                                class="form-control"
                                placeholder="Contoh: HEMAT20"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-bold">
                                Jenis Promo
                            </label>

                            <select
                                name="jenis"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih Jenis --
                                </option>

                                <option value="persen">
                                    Persentase (%)
                                </option>

                                <option value="nominal">
                                    Nominal (Rp)
                                </option>

                            </select>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-bold">
                                Nilai Promo
                            </label>

                            <input
                                type="number"
                                name="value"
                                class="form-control"
                                placeholder="Contoh: 20"
                                min="0"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-bold">
                                Kuota
                            </label>

                            <input
                                type="number"
                                name="kuota"
                                class="form-control"
                                placeholder="Contoh: 100"
                                min="1"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-bold">
                                Minimal Pembelian
                            </label>

                            <input
                                type="number"
                                name="minimal_pembelian"
                                class="form-control"
                                placeholder="Contoh: 100000"
                                min="0"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-bold">
                                Mulai Aktif
                            </label>

                            <input
                                type="datetime-local"
                                name="active_at"
                                class="form-control"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-bold">
                                Tanggal Berakhir
                            </label>

                            <input
                                type="datetime-local"
                                name="expired_at"
                                class="form-control"
                                required
                            >

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn btn-green"
                    >
                        <i class="bi bi-plus-circle me-1"></i>
                        Tambah Promo
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    function confirmSubmit(event, message) {
        event.preventDefault();

        const form = event.target;

        Swal.fire({
            title: 'Konfirmasi',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });

        return false;
    }

</script>

</body>
</html>
