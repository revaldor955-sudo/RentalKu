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
        body {
            background: #f5f7f6;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
            margin: 0;
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
            box-shadow: 0 8px 25px rgba(0, 0, 0, .04);
        }

        .summary-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #edf0ee;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .04);
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

        /* Kop laporan hanya muncul saat dicetak */
        .print-header {
            display: none;
        }

        @media print {

            body {
                background: white;
            }

            .navbar,
            .no-print {
                display: none !important;
            }

            .print-header {
                display: block;
                text-align: center;
                margin-bottom: 24px;
            }

            .page-card,
            .summary-card {
                box-shadow: none;
                border: 1px solid #dee2e6;
                border-radius: 0;
            }

        }

        .table thead th {
            background: #f8faf9;
            color: #6c757d;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
            border-bottom: 1px solid #e9ecef;
            padding: 12px 16px;
        }

        /* Sidebar layout base styles are in admin-sidebar.blade.php */

        .page-content {
            padding: 24px;
        }

        @media (max-width: 1024px) {
            .page-content {
                padding: 16px;
            }
        }
    </style>

</head>

<body>

{{-- Sidebar Layout --}}
@include('layouts.partials.sidebar')

<script>
    // Inject navbar into sidebar layout
    document.addEventListener('DOMContentLoaded', function() {
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

{{-- Page Content --}}
<div class="page-content">

<div class="container-fluid px-4">

    {{-- Kop laporan khusus cetak --}}
    <div class="print-header">
        <h2 class="fw-bold mb-1">Laporan Pendapatan RentalKu.</h2>
        <p class="mb-1">
            Periode: {{ \Carbon\Carbon::parse($dari)->translatedFormat('d F Y') }}
            &mdash; {{ \Carbon\Carbon::parse($sampai)->translatedFormat('d F Y') }}
        </p>
        <small class="text-muted">
            Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}
        </small>
    </div>


    <div class="mb-4 no-print">

        <div class="d-flex justify-content-between align-items-center mb-1">
            <h2 class="fw-bold mb-0">
                Laporan
            </h2>

        </div>

        <p class="text-muted mb-0">
            Laporan pendapatan dari pembayaran berstatus Disetujui.
        </p>

    </div>


    {{-- Filter periode --}}
    <form method="GET" action="{{ route('laporan.index') }}" class="page-card p-4 mb-4 no-print">

        <div class="row g-3 align-items-end">

            <div class="col-md-4">

                <label for="dari" class="form-label fw-semibold small">Dari Tanggal</label>

                <input type="date" class="form-control" id="dari" name="dari"
                    value="{{ $dari }}">

            </div>

            <div class="col-md-4">

                <label for="sampai" class="form-label fw-semibold small">Sampai Tanggal</label>

                <input type="date" class="form-control" id="sampai" name="sampai"
                    value="{{ $sampai }}">

            </div>

            <div class="col-md-4 d-flex gap-2">

                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-funnel me-1"></i>
                    Terapkan
                </button>

                <a href="{{ route('laporan.index') }}" class="btn btn-light border px-4">
                    Reset
                </a>

            </div>

        </div>

    </form>


    {{-- Kartu ringkasan --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="summary-card p-4">
                <div class="text-muted small">Pendapatan Bersih</div>
                <div class="fw-bold fs-4 text-success">
                    Rp {{ number_format($pendapatanBersih, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="summary-card p-4">
                <div class="text-muted small">Pembayaran</div>
                <div class="fw-bold fs-5">
                    Rp {{ number_format($totalPembayaran, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="summary-card p-4">
                <div class="text-muted small">Denda</div>
                <div class="fw-bold fs-5">
                    Rp {{ number_format($totalDenda, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="summary-card p-4">
                <div class="text-muted small">Kompensasi</div>
                <div class="fw-bold fs-5 text-danger">
                    Rp {{ number_format($totalKompensasi, 0, ',', '.') }}
                </div>
            </div>
        </div>

    </div>


    {{-- grafik + breakdown metode --}}
    <div class="row g-3 mb-4">
            <div class="col-lg-8">
                <div class="page-card p-4 no-print">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-bar-chart me-1"></i> Tren Pendapatan Harian
                    </h5>
                    <canvas id="trenChart" height="110"></canvas>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="page-card p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-bar-chart me-1"></i> Per Metode Pembayaran
                    </h5>

                    @forelse ($perMetode as $m)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span>
                                {{ $m['metode'] }}
                                <small class="text-muted">({{ $m['jumlah'] }}x)</small>
                            </span>
                            <span class="fw-semibold">
                                Rp {{ number_format($m['total'], 0, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted">Tidak ada data.</p>
                    @endforelse
                </div>
            </div>
        </div>


        @php
            // Gabungkan 3 sumber jadi satu aliran kas, urut tanggal.
            // Kompensasi diberi nilai negatif karena uang keluar.
            $arus = collect()
                ->merge($pembayarans->map(fn ($p) => [
                    'tanggal' => $p->tanggal_bayar,
                    'jenis'   => 'Pembayaran',
                    'ket'     => $p->metodePembayaran->name ?? '-',
                    'penyewa' => $p->rental->user->name ?? '-',
                    'mobil'   => $p->rental->mobil?->name,
                    'plat'    => $p->rental->mobil?->plate_number,
                    'jumlah'  => $p->jumlah,
                ]))
                ->merge($dendas->map(fn ($d) => [
                    'tanggal' => $d->created_at,
                    'jenis'   => 'Denda ' . $d->jenis,
                    'ket'     => '-',
                    'penyewa' => $d->rental->user->name ?? '-',
                    'mobil'   => $d->rental->mobil?->name,
                    'plat'    => $d->rental->mobil?->plate_number,
                    'jumlah'  => $d->nominal,
                ]))
                ->merge($kompensasis->map(fn ($k) => [
                    'tanggal' => $k->tanggal,
                    'jenis'   => 'Kompensasi',
                    'ket'     => $k->alasan,
                    'penyewa' => $k->rental->user->name ?? '-',
                    'mobil'   => $k->mobil?->name,
                    'plat'    => null,
                    'jumlah'  => - $k->nominal,
                ]))
                ->sortBy('tanggal');
        @endphp
        
        @if ($arus->isNotEmpty())
            <div class="page-card p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="text-muted small">
                                <th style="width: 50px;">No</th>
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
                                        : (str_starts_with($a['jenis'], 'Denda') ? 'warning text-dark' : 'danger');
                                @endphp

                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($a['tanggal'])->translatedFormat('d M Y') }}
                                    </td>

                                    <td><span class="badge bg-{{ $badge }}">{{ $a['jenis'] }}</span></td>

                                    <td>{{ $a['penyewa'] }}</td>

                                    <td>
                                        {{ $a['mobil'] ?? '-' }}
                                        @if ($a['plat'])
                                            <small class="text-muted">({{ $a['plat'] }})</small>
                                        @endif
                                    </td>

                                    <td class="small text-muted">{{ $a['ket'] }}</td>

                                    <td class="text-end fw-semibold {{ $a['jumlah'] < 0 ? 'text-danger' : '' }}">
                                        {{ $a['jumlah'] < 0 ? '−' : '' }}Rp {{ number_format(abs($a['jumlah']), 0, ',', '.') }}
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="6" class="text-end">Pendapatan Bersih</td>
                                <td class="text-end">
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

                    <h4 class="fw-bold">
                        Tidak Ada Data
                    </h4>

                    <p class="text-muted mb-0">
                        Belum ada transaksi pada periode
                        {{ \Carbon\Carbon::parse($dari)->translatedFormat('d M Y') }} s/d
                        {{ \Carbon\Carbon::parse($sampai)->translatedFormat('d M Y') }}.
                    </p>

                </div>

            </div>
        @endif


        {{-- Tombol cetak --}}
        @if ($arus->isNotEmpty())
            <div class="text-center mt-4 no-print">

                <button type="button" class="btn btn-success px-5" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>
                    Cetak Laporan
                </button>

            </div>
        @endif


</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const tren = @json($tren);

    new Chart(document.getElementById('trenChart'), {
        type: 'bar',
        data: {
            labels: tren.map(t => t.tanggal),
            datasets: [{
                data: tren.map(t => t.total),
                backgroundColor: '#198754',
                borderRadius: 6
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: v => 'Rp ' + v.toLocaleString('id-ID')
                    }
                }
            }
        }
    });
</script>

{{-- Bootstrap JS: dibutuhkan modal profil di navbar --}}
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>