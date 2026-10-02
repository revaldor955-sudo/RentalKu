<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hubungi Kami - RentalKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body {
            background: #f5f7f8;
            font-family: Arial, Helvetica, sans-serif;
        }

        .page-header {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        .page-title {
            font-weight: 700;
            color: #172033;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
            height: 100%;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #e8f5f2;
            color: #2c666e;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .table-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        .table thead th {
            color: #667085;
            font-size: 13px;
            text-transform: uppercase;
            border-bottom: 1px solid #e9ecef;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .status {
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-belum {
            background: #fff3cd;
            color: #856404;
        }

        .status-dibaca {
            background: #cff4fc;
            color: #055160;
        }

        .status-dibalas {
            background: #d1e7dd;
            color: #0f5132;
        }

        .btn-rental {
            background: #2c666e;
            color: white;
            border: none;
        }

        .btn-rental:hover {
            background: #24555c;
            color: white;
        }

    </style>

</head>

<body>

<div class="container-fluid py-4 px-4">

    {{-- Header --}}
    <div class="page-header">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <div class="text-success fw-bold mb-1">
                    HUBUNGI KAMI
                </div>

                <h2 class="page-title mb-1">
                    Pesan Pengunjung
                </h2>

                <p class="text-muted mb-0">
                    Kelola pertanyaan dan pesan dari pengunjung RentalKu.
                </p>

            </div>

        </div>

    </div>


    {{-- Alert --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Statistik --}}
    <div class="row g-4 mb-4">

        <div class="col-md-4">

            <div class="stat-card">

                <div class="d-flex align-items-center gap-3">

                    <div class="stat-icon">
                        <i class="bi bi-envelope"></i>
                    </div>

                    <div>

                        <div class="text-muted small">
                            Total Pesan
                        </div>

                        <h3 class="fw-bold mb-0">
                            {{ $totalPesan }}
                        </h3>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="stat-card">

                <div class="d-flex align-items-center gap-3">

                    <div class="stat-icon">
                        <i class="bi bi-envelope-exclamation"></i>
                    </div>

                    <div>

                        <div class="text-muted small">
                            Belum Dibaca
                        </div>

                        <h3 class="fw-bold mb-0">
                            {{ $belumDibaca }}
                        </h3>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="stat-card">

                <div class="d-flex align-items-center gap-3">

                    <div class="stat-icon">
                        <i class="bi bi-reply"></i>
                    </div>

                    <div>

                        <div class="text-muted small">
                            Sudah Dibalas
                        </div>

                        <h3 class="fw-bold mb-0">
                            {{ $sudahDibalas }}
                        </h3>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Table --}}
    <div class="table-card">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h5 class="fw-bold mb-1">
                    Daftar Pesan
                </h5>

                <small class="text-muted">
                    Pesan yang dikirim melalui halaman Hubungi Kami.
                </small>

            </div>

        </div>


        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Pengunjung</th>

                        <th>Email</th>

                        <th>Subjek</th>

                        <th>Status</th>

                        <th>Tanggal</th>

                        <th class="text-center">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($contacts as $contact)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>

                                <div class="fw-semibold">
                                    {{ $contact->nama }}
                                </div>

                            </td>

                            <td>
                                {{ $contact->email }}
                            </td>

                            <td>

                                <div style="max-width: 250px;">
                                    {{ $contact->subjek }}
                                </div>

                            </td>

                            <td>

                                @if($contact->status === 'Belum Dibaca')

                                    <span class="status status-belum">
                                        Belum Dibaca
                                    </span>

                                @elseif($contact->status === 'Dibaca')

                                    <span class="status status-dibaca">
                                        Dibaca
                                    </span>

                                @else

                                    <span class="status status-dibalas">
                                        Dibalas
                                    </span>

                                @endif

                            </td>

                            <td>

                                {{ $contact->created_at->format('d/m/Y H:i') }}

                            </td>

                            <td class="text-center">

                                <a
                                    href="{{ route('contacts.show', $contact) }}"
                                    class="btn btn-sm btn-rental"
                                >

                                    <i class="bi bi-eye me-1"></i>

                                    Detail

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5 text-muted"
                            >

                                <i
                                    class="bi bi-envelope-open"
                                    style="font-size: 40px;"
                                ></i>

                                <div class="mt-2">
                                    Belum ada pesan dari pengunjung.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>