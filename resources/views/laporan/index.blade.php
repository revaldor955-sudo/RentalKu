
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: #f5f7f6;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            color: #1f2937;
        }

        .page-content {
            padding: 24px;
        }

        .page-title {
            font-weight: 800;
            color: #1f2937;
        }

        .page-card,
        .summary-card {
            background: #fff;
            border-radius: 18px;
            border: 1px solid #edf0ee;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .04);
        }

        .summary-card {
            height: 100%;
            padding: 22px;
        }

        .summary-label {
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .summary-value {
            font-size: 21px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .summary-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #e9f7ef;
            color: #198754;
            font-size: 20px;
            margin-bottom: 14px;
        }

        .report-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: #e9f7ef;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            margin: auto;
        }

        .section-title {
            font-weight: 800;
            color: #1f2937;
        }

        .table thead th {
            background: #f0f7f2;
            color: #475569;
            font-size: 11px;
            text-transform: uppercase;
            white-space: nowrap;
            border-bottom: 1px solid #dce8df;
            padding: 14px 12px;
        }

        .table tbody td {
            padding: 13px 12px;
            vertical-align: middle;
            font-size: 12px;
        }

        .table tfoot td {
            background: #f0f7f2;
            padding: 14px 12px;
        }

        .print-header,
        .print-footer {
            display: none;
        }

        .filter-card {
            padding: 22px;
        }

        .btn-success {
            font-weight: 700;
        }

        .method-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 13px 0;
            border-bottom: 1px solid #edf0ee;
        }

        .method-item:last-child {
            border-bottom: 0;
        }

        .method-name {
            font-size: 12px;
            font-weight: 600;
        }

        .method-total {
            font-size: 12px;
            font-weight: 800;
            text-align: right;
            white-space: nowrap;
        }

        @media (max-width: 1024px) {
            .page-content {
                padding: 16px;
            }
        }

        @media (max-width: 576px) {
            .page-content {
                padding: 12px;
            }

            .summary-card {
                padding: 16px;
            }

            .summary-value {
                font-size: 17px;
            }
        }

        /* PENGATURAN CETAK LAPORAN */
        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        @media print {
            html,
            body {
                width: 100%;
                background: #fff !important;
                color: #1f2937 !important;
                font-family: Arial, sans-serif !important;
                font-size: 10px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            body {
                margin: 0 !important;
            }

            .no-print,
            .navbar,
            .sidebar,
            aside,
            .offcanvas,
            .modal,
            .btn,
            button,
            form {
                display: none !important;
            }

            #mainContent {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: none !important;
            }

            .page-content {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }

            .container-fluid {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: none !important;
            }

            .print-header {
                display: block !important;
                text-align: center;
                margin-bottom: 18px;
                padding-bottom: 13px;
                border-bottom: 3px double #198754;
                page-break-after: avoid;
                break-after: avoid;
            }

            .print-brand {
                font-size: 12px;
                font-weight: 800;
                letter-spacing: 3px;
                color: #198754 !important;
                margin-bottom: 5px;
            }

            .print-header h2 {
                font-size: 21px;
                font-weight: 800;
                margin: 0 0 8px !important;
                color: #1f2937 !important;
            }

            .print-header p {
                font-size: 10px;
                margin-bottom: 5px !important;
            }

            .print-header small {
                font-size: 9px;
                color: #64748b !important;
            }

            .summary-card,
            .page-card {
                background: #fff !important;
                border: 1px solid #d7dfd9 !important;
                border-radius: 6px !important;
                box-shadow: none !important;
            }

            .summary-card {
                padding: 12px !important;
                min-height: 0;
            }

            .summary-icon {
                display: none !important;
            }

            .summary-label {
                font-size: 9px !important;
                margin-bottom: 6px !important;
            }

            .summary-value {
                font-size: 15px !important;
                line-height: 1.4;
            }

            .row {
                --bs-gutter-x: 9px;
                --bs-gutter-y: 9px;
            }

            .mb-4 {
                margin-bottom: 12px !important;
            }

            .p-4 {
                padding: 12px !important;
            }

            .section-title,
            h5 {
                font-size: 12px !important;
            }

            .table-responsive {
                overflow: visible !important;
            }

            table {
                width: 100% !important;
                border-collapse: collapse !important;
                font-size: 9px !important;
                margin-bottom: 0 !important;
            }

            .table thead {
                display: table-header-group;
            }

            .table tfoot {
                display: table-row-group;
            }

            .table thead th {
                background: #e8f3ec !important;
                color: #1f2937 !important;
                border: 1px solid #cbd5ce !important;
                padding: 8px 6px !important;
                font-size: 8px !important;
                font-weight: 700 !important;
                white-space: normal !important;
            }

            .table tbody td,
            .table tfoot td {
                border: 1px solid #d9dfdb !important;
                padding: 7px 6px !important;
                vertical-align: top !important;
                overflow-wrap: anywhere;
                font-size: 9px !important;
            }

            .table tbody tr {
                break-inside: avoid;
                page-break-inside: avoid;
            }

            .table tbody tr:nth-child(even) {
                background: #f8faf9 !important;
            }

            .badge {
                color: #1f2937 !important;
                background: #edf2ee !important;
                border: 1px solid #cbd5ce;
                font-size: 8px !important;
                white-space: normal;
            }

            .text-success {
                color: #167347 !important;
            }

            .text-danger {
                color: #b42318 !important;
            }

            .text-muted {
                color: #5f6b65 !important;
            }

            .method-item {
                padding: 8px 0;
            }

            .method-name,
            .method-total {
                font-size: 9px !important;
            }

            #trenChart {
                display: none !important;
            }

            .print-footer {
                display: block !important;
                margin-top: 15px;
                padding-top: 7px;
                border-top: 1px solid #cbd5ce;
                color: #64748b !important;
                text-align: center;
                font-size: 8px;
            }

            .report-icon {
                width: 55px;
                height: 55px;
                font-size: 25px;
            }

            a {
                text-decoration: none !important;
                color: inherit !important;
            }
        }
    </style>
</head>

<body>

@php
    $adaArus = $pembayarans->isNotEmpty()
        || $dendas->isNotEmpty()
        || $kompensasis->isNotEmpty();
@endphp

@include('layouts.partials.sidebar', ['tampilkanCetak' => $adaArus])

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mainContent = document.getElementById('mainContent');
    const pageContent = mainContent?.querySelector('.page-content');

    if (mainContent && pageContent) {
        const navbar = document.querySelector('header.topbar');

        if (navbar) {
            mainContent.insertBefore(navbar, pageContent);
        }
    }
});
</script>

<div class="page-content">
<div class="container-fluid px-4">

    <!-- KOP KHUSUS CETAK -->
    <div class="print-header">
        <div class="print-brand">RENTALKU</div>
        <h2>Laporan Pendapatan</h2>

        <p>
            <strong>Periode:</strong>
            {{ \Carbon\Carbon::parse($dari)->translatedFormat('d F Y') }}
            sampai
            {{ \Carbon\Carbon::parse($sampai)->translatedFormat('d F Y') }}
        </p>

        <small>
            Dicetak pada:
            {{ now()->translatedFormat('d F Y, H:i') }} WIB
        </small>
    </div>

    <!-- JUDUL HALAMAN -->
    <div class="mb-4 no-print">
        <h2 class="fw-bold mb-1">Laporan Pendapatan</h2>
        <p class="text-muted mb-0">
            Ringkasan pendapatan, pembayaran, denda, dan kompensasi RentalKu.
        </p>
    </div>

    <!-- FILTER PERIODE -->
    <form method="GET" action="{{ route('laporan.index') }}"
          class="page-card filter-card mb-4 no-print">

        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="dari" class="form-label fw-semibold small">
                    Dari Tanggal
                </label>
                <input type="date" class="form-control" id="dari"
                       name="dari" value="{{ $dari }}">
            </div>

            <div class="col-md-4">
                <label for="sampai" class="form-label fw-semibold small">
                    Sampai Tanggal
                </label>
                <input type="date" class="form-control" id="sampai"
                       name="sampai" value="{{ $sampai }}">
            </div>

            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-funnel me-1"></i> Terapkan
                </button>

                <a href="{{ route('laporan.index') }}"
                   class="btn btn-light border px-4">
                    Reset
                </a>
            </div>
        </div>
    </form>

    <!-- RINGKASAN KEUANGAN -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="summary-card">
                <div class="summary-icon">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div class="summary-label">Pendapatan Bersih</div>
                <div class="summary-value text-success">
                    Rp {{ number_format($pendapatanBersih, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="summary-card">
                <div class="summary-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="summary-label">Total Pembayaran</div>
                <div class="summary-value">
                    Rp {{ number_format($totalPembayaran, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="summary-card">
                <div class="summary-icon">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div class="summary-label">Total Denda</div>
                <div class="summary-value">
                    Rp {{ number_format($totalDenda, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="summary-card">
                <div class="summary-icon">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </div>
                <div class="summary-label">Total Kompensasi</div>
                <div class="summary-value text-danger">
                    Rp {{ number_format($totalKompensasi, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <!-- GRAFIK DAN METODE PEMBAYARAN -->
    <div class="row g-3 mb-4">
        <div class="col-lg-8 no-print">
            <div class="page-card p-4">
                <h5 class="section-title mb-3">
                    <i class="bi bi-bar-chart-line me-1"></i>
                    Tren Pendapatan Harian
                </h5>
                <div id="trenChart"></div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="page-card p-4 h-100">
                <h5 class="section-title mb-3">
                    <i class="bi bi-credit-card me-1"></i>
                    Per Metode Pembayaran
                </h5>

                @forelse ($perMetode as $m)
                    <div class="method-item">
                        <div class="method-name">
                            {{ $m['metode'] }}
                            <div class="text-muted small">
                                {{ $m['jumlah'] }} transaksi
                            </div>
                        </div>

                        <div class="method-total">
                            Rp {{ number_format($m['total'], 0, ',', '.') }}
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">Tidak ada data pembayaran.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- SIAPKAN DATA ARUS KAS -->
    @php
        $arus = collect()
            ->merge($pembayarans->map(fn ($p) => [
                'tanggal' => $p->tanggal_bayar,
                'jenis' => 'Pembayaran',
                'ket' => $p->metodePembayaran->name ?? '-',
                'penyewa' => $p->rental->user->name ?? '-',
                'mobil' => $p->rental->mobil?->name,
                'plat' => $p->rental->mobil?->plate_number,
                'jumlah' => $p->jumlah,
            ]))
            ->merge($dendas->map(fn ($d) => [
                'tanggal' => $d->created_at,
                'jenis' => 'Denda ' . $d->jenis,
                'ket' => '-',
                'penyewa' => $d->rental->user->name ?? '-',
                'mobil' => $d->rental->mobil?->name,
                'plat' => $d->rental->mobil?->plate_number,
                'jumlah' => $d->nominal,
            ]))
            ->merge($kompensasis->map(fn ($k) => [
                'tanggal' => $k->tanggal,
                'jenis' => 'Kompensasi',
                'ket' => $k->alasan,
                'penyewa' => $k->rental->user->name ?? '-',
                'mobil' => $k->mobil?->name,
                'plat' => null,
                'jumlah' => -$k->nominal,
            ]))
            ->sortBy('tanggal')
            ->values();
    @endphp

    <!-- TABEL TRANSAKSI -->
    @if ($arus->isNotEmpty())
        <div class="page-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="section-title mb-1">Rincian Transaksi</h5>
                    <p class="text-muted small mb-0">
                        Daftar transaksi pada periode laporan yang dipilih.
                    </p>
                </div>

                <span class="badge text-bg-light border no-print">
                    {{ $arus->count() }} transaksi
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 45px;">No</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Penyewa</th>
                            <th>Mobil</th>
                            <th>Keterangan</th>
                            <th class="text-end">Jumlah</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($arus as $a)
                            @php
                                $badge = str_starts_with($a['jenis'], 'Pembayaran')
                                    ? 'success'
                                    : (str_starts_with($a['jenis'], 'Denda')
                                        ? 'warning text-dark'
                                        : 'danger');
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($a['tanggal'])->translatedFormat('d M Y') }}
                                </td>

                                <td>
                                    <span class="badge bg-{{ $badge }}">
                                        {{ $a['jenis'] }}
                                    </span>
                                </td>

                                <td>{{ $a['penyewa'] }}</td>

                                <td>
                                    {{ $a['mobil'] ?? '-' }}
                                    @if ($a['plat'])
                                        <small class="text-muted d-block">
                                            {{ $a['plat'] }}
                                        </small>
                                    @endif
                                </td>

                                <td>{{ $a['ket'] }}</td>

                                <td class="text-end fw-bold {{ $a['jumlah'] < 0 ? 'text-danger' : '' }}">
                                    {{ $a['jumlah'] < 0 ? '−' : '' }}Rp
                                    {{ number_format(abs($a['jumlah']), 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="6" class="text-end">
                                Pendapatan Bersih
                            </td>
                            <td class="text-end text-success">
                                Rp {{ number_format($pendapatanBersih, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @else
        <div class="page-card p-4">
            <div class="text-center py-5">
                <div class="report-icon mb-4">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                </div>

                <h4 class="fw-bold">Tidak Ada Data</h4>

                <p class="text-muted mb-0">
                    Belum ada transaksi pada periode
                    {{ \Carbon\Carbon::parse($dari)->translatedFormat('d M Y') }}
                    sampai
                    {{ \Carbon\Carbon::parse($sampai)->translatedFormat('d M Y') }}.
                </p>
            </div>
        </div>
    @endif

    <div class="print-footer">
        RentalKu — Laporan Pendapatan
        <span class="mx-2">|</span>
        Dokumen laporan yang dicetak dari sistem.
    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    const tren = @json($tren);
    const reduceMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    ).matches;

    const chartElement = document.getElementById('trenChart');

    if (chartElement) {
        const options = {
            series: [{
                name: 'Pendapatan',
                data: tren.map(t => [
                    new Date(t.tanggal).getTime(),
                    Number(t.total)
                ])
            }],
            chart: {
                type: 'area',
                height: 300,
                zoom: {
                    type: 'x',
                    enabled: true,
                    autoScaleYaxis: true
                },
                toolbar: {
                    autoSelected: 'zoom'
                },
                fontFamily: 'inherit',
                animations: {
                    enabled: !reduceMotion
                }
            },
            colors: ['#198754'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.35,
                    opacityTo: 0.03,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                type: 'datetime',
                labels: {
                    datetimeUTC: false
                }
            },
            yaxis: {
                labels: {
                    formatter: val =>
                        'Rp ' + Math.round(val).toLocaleString('id-ID')
                }
            },
            tooltip: {
                x: {
                    format: 'dd MMM yyyy'
                },
                y: {
                    formatter: val =>
                        'Rp ' + Math.round(val).toLocaleString('id-ID')
                }
            },
            noData: {
                text: 'Belum ada data pendapatan'
            }
        };

        new ApexCharts(chartElement, options).render();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
