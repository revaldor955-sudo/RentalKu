<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Lokasi Mobil - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background: #f4f7f8;
            color: #263b3d;
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }

        .page-title {
            font-size: 24px;
            font-weight: 800;
            color: #24575c;
        }

        .page-subtitle {
            font-size: 12px;
            color: #829194;
        }

        .content-card {
            background: #fff;
            border: 1px solid #e8eeee;
            border-radius: 15px;
            padding: 24px;
        }

        .info-card {
            background: #fff;
            border: 1px solid #e8eeee;
            border-radius: 13px;
            padding: 18px;
            height: 100%;
        }

        .info-label {
            font-size: 11px;
            color: #89999b;
            margin-bottom: 7px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 700;
            color: #24575c;
        }

        .table thead th {
            background: #f1f7f5;
            color: #496466;
            font-size: 11px;
            font-weight: 700;
            padding: 14px;
            white-space: nowrap;
        }

        .table tbody td {
            font-size: 12px;
            padding: 14px;
            vertical-align: middle;
            color: #52696a;
        }

        .btn-main {
            background: #28766e;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 9px 15px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-main:hover {
            background: #205e58;
            color: #fff;
        }

        .coordinate-badge {
            background: #e6f2ef;
            color: #24776c;
            padding: 7px 10px;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 45px 15px;
            color: #89999b;
        }

        .empty-state i {
            font-size: 40px;
            color: #b5c9c6;
        }

        @media (max-width: 991px) {
            .main-content {
                margin-left: 0;
                padding: 20px 14px;
            }
        }
    </style>
</head>
<body>

@include('layouts.partials.sidebar')

<div class="main-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h4 class="page-title mb-1">Riwayat Lokasi Mobil</h4>
            <p class="page-subtitle mb-0">Catatan perubahan koordinat lokasi mobil rental.</p>
        </div>

        <a href="{{ route('pelacakan-gps.index') }}" class="btn-main">
            <i class="bi bi-arrow-left"></i> Kembali ke Pelacakan GPS
        </a>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="info-card">
                <div class="info-label">Nama Mobil</div>
                <div class="info-value">
                    {{ $rental->mobil->name ?? '-' }}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="info-card">
                <div class="info-label">Nomor Plat</div>
                <div class="info-value">
                    {{ $rental->mobil->plate_number ?? '-' }}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="info-card">
                <div class="info-label">Nama Customer</div>
                <div class="info-value">
                    {{ $rental->user->name ?? '-' }}
                </div>
            </div>
        </div>

    </div>

    <div class="content-card">

        <div class="mb-4">
            <h6 class="fw-bold mb-1" style="color:#24575c">
                Daftar Riwayat Koordinat
            </h6>
            <p class="page-subtitle mb-0">
                Jumlah catatan lokasi: {{ $riwayats->count() }}
            </p>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Peta</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($riwayats as $riwayat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <span class="coordinate-badge">
                                    {{ $riwayat->latitude }}
                                </span>
                            </td>

                            <td>
                                <span class="coordinate-badge">
                                    {{ $riwayat->longitude }}
                                </span>
                            </td>

                            <td>
                                {{ $riwayat->created_at->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ $riwayat->created_at->format('H:i:s') }}
                            </td>

                            <td>
                                <a href="https://www.google.com/maps?q={{ $riwayat->latitude }},{{ $riwayat->longitude }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn-main">
                                    <i class="bi bi-geo-alt"></i> Lihat Peta
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-geo"></i>
                                    <h6 class="fw-bold mt-3">Belum Ada Riwayat Lokasi</h6>
                                    <p class="small mb-0">
                                        Riwayat akan muncul setelah koordinat mobil disimpan.
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
