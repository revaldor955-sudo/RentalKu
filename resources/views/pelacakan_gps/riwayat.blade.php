<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Lokasi Mobil - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background: #f4f7f8;
            color: #000;
        }

        .page-content {
            padding: 24px;
        }

        @media (max-width: 1024px) {
            .page-content {
                padding: 16px;
            }
        }

        .page-title {
            font-size: 24px;
            font-weight: 800;
            color: #000;
        }

        .page-subtitle {
            font-size: 12px;
            color: #000;
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
            color: #000;
            margin-bottom: 7px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 700;
            color: #000;
        }

        .table thead th {
            background: #f1f7f5;
            color: #000;
            font-size: 11px;
            font-weight: 700;
            padding: 14px;
            white-space: nowrap;
        }

        .table tbody td {
            font-size: 12px;
            padding: 14px;
            vertical-align: middle;
            color: #000;
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
            color: #000;
            padding: 7px 10px;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 600;
        }

        .pager-bar {
            background: #fff;
            border: 1px solid #edf0ee;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .05);
            padding: 12px 16px;
            font-size: 14px;
        }

        .pager-select {
            width: auto;
            border-radius: 10px;
            font-size: 13px;
            height: 34px;
            padding: 6px 28px 6px 10px;
        }

        .pager-jump {
            width: 72px;
            border-radius: 10px;
            text-align: center;
            font-size: 13px;
            height: 34px;
            padding: 6px 8px;
        }

        .pager-btn {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            color: #1f2937;
            font-weight: 600;
            background: #fff;
            font-size: 13px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
        }

        .pager-btn:hover {
            border-color: #198754;
            color: #198754;
            background: #f5f7f6;
        }

        .pager-btn.disabled {
            opacity: .4;
            pointer-events: none;
        }

        .pager-next {
            background: #198754;
            border-color: #198754;
            color: #fff;
        }

        .pager-next:hover {
            background: #146c43;
            border-color: #146c43;
            color: #fff;
        }

    </style>
</head>
<body>

@include('layouts.partials.sidebar')

<div class="page-content">
<div class="container-fluid px-4">

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
            <h6 class="fw-bold mb-1" style="color:#000">
                Daftar Riwayat Koordinat
            </h6>
            <p class="page-subtitle mb-0">
                Jumlah catatan lokasi: {{ $totalRiwayat }}
            </p>
        </div>

        <div class="table-responsive">
            <table id="riwayat-table" class="table table-hover align-middle mb-0">
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
                    {{-- Diisi oleh DataTables (server-side) --}}
                </tbody>
            </table>
        </div>

        <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3"
            id="riwayat-pager">

            <div class="text-secondary small" id="riwayat-info">
                Menampilkan 0–0 dari 0 data
            </div>

            <div class="d-flex flex-wrap align-items-center gap-2">
                <select id="riwayat-len"
                    class="form-select form-select-sm pager-select"
                    aria-label="Jumlah per halaman">
                    <option value="10">10 / halaman</option>
                    <option value="20">20 / halaman</option>
                    <option value="50">50 / halaman</option>
                    <option value="100">100 / halaman</option>
                    <option value="custom">Custom</option>
                </select>

                <input type="number" id="riwayat-custom"
                    class="form-control form-control-sm pager-jump"
                    min="1" max="500" value="10"
                    aria-label="Jumlah custom per halaman">

                <span class="text-secondary" id="riwayat-page">
                    Halaman 1 / 1
                </span>
            </div>

            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm pager-btn"
                    id="riwayat-first">First</button>

                <button type="button" class="btn btn-sm pager-btn"
                    id="riwayat-prev" aria-label="Halaman sebelumnya">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <button type="button" class="btn btn-sm pager-btn pager-next"
                    id="riwayat-next" aria-label="Halaman berikutnya">
                    <i class="bi bi-chevron-right"></i>
                </button>

                <button type="button" class="btn btn-sm pager-btn"
                    id="riwayat-last">Last</button>
            </div>
        </div>

    </div>

</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.8/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(function () {
    const riwayatTable = $('#riwayat-table').DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        pageLength: 10,
        lengthChange: false,
        info: false,
        dom: 'frt',
        ajax: {
            url: '{{ route('pelacakan-gps.riwayat.data', $rental->id) }}',
            type: 'GET',
        },
        columns: [{
                data: null,
                orderable: false,
                searchable: false,
                width: '60px',
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            {
                data: 'latitude',
                render: function (data) {
                    return '<span class="coordinate-badge">' + data + '</span>';
                },
            },
            {
                data: 'longitude',
                render: function (data) {
                    return '<span class="coordinate-badge">' + data + '</span>';
                },
            },
            {
                data: 'tanggal',
            },
            {
                data: 'waktu',
            },
            {
                data: 'maps_url',
                orderable: false,
                searchable: false,
                render: function (data) {
                    return '<a href="' + data + '" target="_blank" rel="noopener noreferrer" class="btn-main">' +
                        '<i class="bi bi-geo-alt"></i> Lihat Peta</a>';
                },
            },
        ],
        order: [
            [3, 'desc']
        ],
        language: {
            processing: 'Memproses...',
            search: 'Cari:',
            loadingRecords: 'Memuat...',
            zeroRecords: 'Tidak ditemukan data yang cocok',
            emptyTable: 'Belum ada riwayat lokasi',
        },
    });

    function renderRiwayatPager() {
        const info = riwayatTable.page.info();

        const total = info.recordsDisplay;
        const start = total ? info.start + 1 : 0;
        const end = total ? info.end : 0;
        const pages = info.pages || 1;
        const page = total ? info.page + 1 : 0;

        $('#riwayat-info').text(
            'Menampilkan ' + start + '–' + end + ' dari ' + total + ' data'
        );

        $('#riwayat-page').text(
            'Halaman ' + page + ' / ' + pages
        );

        $('#riwayat-first, #riwayat-prev')
            .toggleClass('disabled', info.page <= 0);

        $('#riwayat-next, #riwayat-last')
            .toggleClass('disabled', info.page >= pages - 1 || total === 0);
    }

    riwayatTable.on('draw.dt', renderRiwayatPager);

    $('#riwayat-first').on('click', function () {
        riwayatTable.page('first').draw('page');
    });

    $('#riwayat-prev').on('click', function () {
        riwayatTable.page('previous').draw('page');
    });

    $('#riwayat-next').on('click', function () {
        riwayatTable.page('next').draw('page');
    });

    $('#riwayat-last').on('click', function () {
        riwayatTable.page('last').draw('page');
    });

    $('#riwayat-len').on('change', function () {
        if ($(this).val() === 'custom') {
            $('#riwayat-custom').focus();
            return;
        }

        const jumlah = Number($(this).val());

        $('#riwayat-custom').val(jumlah);
        riwayatTable.page.len(jumlah).draw();
    });

    $('#riwayat-custom').on('change', function () {
        let jumlah = parseInt($(this).val(), 10) || 1;
        jumlah = Math.min(Math.max(jumlah, 1), 500);

        $(this).val(jumlah);

        if (['10', '20', '50', '100'].includes(String(jumlah))) {
            $('#riwayat-len').val(String(jumlah));
        } else {
            $('#riwayat-len').val('custom');
        }

        riwayatTable.page.len(jumlah).draw();
    });

    renderRiwayatPager();
});
</script>

</body>
</html>
