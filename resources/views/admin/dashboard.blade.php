<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin - RentalKu</title>

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

        /* Sidebar variables and base styles are in admin-sidebar.blade.php */

        .page-content {
            padding: 24px;
        }

        @media (max-width: 1024px) {
            .page-content {
                padding: 16px;
            }
        }

        .hero {
            margin-top: 0;
            border-radius: 24px;

            padding: 40px;

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

        .hero-icon {
            font-size: 120px;
            opacity: .12;
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

            box-shadow:
                0 10px 25px rgba(0,0,0,.06);
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

            border-bottom: 1px solid #e9ecef;
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

        .page-content footer {
            margin-top: 70px;
        }

        .main-content {
            display: flex;
            flex-direction: column;
        }

        .page-content {
            flex: 1;
        }

    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>


<body>

{{-- Sidebar Layout --}}
@include('layouts.partials.admin-sidebar')

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

<div class="hero mb-4">

    <div class="row align-items-center">

        <div class="col-lg-8">

            <span
                class="badge bg-light text-success px-3 py-2 mb-3"
            >

                <i class="bi bi-shield-check"></i>

                Administrator

            </span>


            <h1>

                Selamat datang,
                {{ Auth::user()->name }} 👋

            </h1>


            <p class="mt-3 mb-4">

                Kelola seluruh sistem RentalKu melalui
                dashboard administrator. Mulai dari kendaraan,
                pengguna, fasilitas, promo, banner hingga
                operasional rental.

            </p>

        </div>


        <div class="col-lg-4 text-center d-none d-lg-block">

            <i class="bi bi-speedometer2 hero-icon"></i>

        </div>

    </div>

</div>


<div class="row g-4 mb-4">

    {{-- USERS --}}
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="text-muted">
                        Total Pengguna
                    </div>
                    <div class="stat-number">
                        {{ $totalUsers }}
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- MOBIL --}}
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

    {{-- TERSEDIA --}}
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

    {{-- CABANG --}}
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="text-muted">
                        Total Cabang
                    </div>
                    <div class="stat-number">
                        {{ $totalCabang }}
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-building"></i>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <div class="text-muted">
                        Tersedia
                    </div>
                    <div class="stat-number text-success">
                        {{ $mobilTersedia }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon">
                    <i class="bi bi-key"></i>
                </div>
                <div>
                    <div class="text-muted">
                        Sedang Disewa
                    </div>
                    <div class="stat-number">
                        {{ $mobilDisewa }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon">
                    <i class="bi bi-tools"></i>
                </div>
                <div>
                    <div class="text-muted">
                        Maintenance
                    </div>
                    <div class="stat-number">
                        {{ $mobilMaintenance }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<section class="mb-5" id="laporan">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="section-title mb-1">
                Laporan Pendapatan
            </h3>
            <p class="text-muted mb-0">
                Periode {{ \Carbon\Carbon::parse($dari)->translatedFormat('d M Y') }}
                s/d {{ \Carbon\Carbon::parse($sampai)->translatedFormat('d M Y') }}.
            </p>
        </div>
        <a
            href="{{ route('laporan.index') }}"
            class="btn btn-green"
        >
            Laporan Lengkap
            <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="row g-4 mb-4">

        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted">
                            Pendapatan Bersih
                        </div>
                        <div class="stat-number text-success" data-countup="{{ $laporan['pendapatanBersih'] }}" data-prefix="Rp ">
                            Rp 0
                        </div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted">
                            Pembayaran
                        </div>
                        <div class="stat-number" data-countup="{{ $laporan['totalPembayaran'] }}" data-prefix="Rp ">
                            Rp 0
                        </div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-credit-card"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted">
                            Denda
                        </div>
                        <div class="stat-number" data-countup="{{ $laporan['totalDenda'] }}" data-prefix="Rp ">
                            Rp 0
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
                            Kompensasi
                        </div>
                        <div class="stat-number text-danger" data-countup="{{ $laporan['totalKompensasi'] }}" data-prefix="Rp ">
                            Rp 0
                        </div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-arrow-return-left"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">

        <div class="col-lg-8">
            <div class="table-card p-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-bar-chart me-1"></i>
                    Tren Pendapatan Harian
                </h5>
                <div style="position:relative;height:190px;">
                    <canvas id="trenChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="table-card p-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-pie-chart me-1"></i>
                    Per Metode Pembayaran
                </h5>
                @forelse ($laporan['perMetode'] as $m)
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
                    <p class="text-muted mb-0">Belum ada transaksi periode ini.</p>
                @endforelse
            </div>
        </div>

    </div>

</section>


<section class="mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="section-title mb-1">
                Mobil Terbaru
            </h3>

            <p class="text-muted mb-0">
                Kendaraan terbaru yang ditambahkan.
            </p>
        </div>

        <a
            href="{{ route('mobils.index') }}"
            class="btn btn-green"
        >
            Lihat Semua
            <i class="bi bi-arrow-right ms-1"></i>
        </a>

    </div>

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
                                Brand
                            </th>
                            <th>
                                Cabang
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
                                    <div class="d-flex align-items-center gap-3">
                                        @if($mobil->image)
                                            <img
                                                src="{{ asset($mobil->image) }}"
                                                width="55"
                                                height="42"
                                                style="object-fit:cover;border-radius:10px;"
                                                alt="{{ $mobil->name }}"
                                            >
                                        @else
                                            <div
                                                class="bg-light d-flex align-items-center justify-content-center"
                                                style="width:55px;height:42px;border-radius:10px;"
                                            >
                                                <i class="bi bi-car-front text-secondary"></i>
                                            </div>
                                        @endif
                                        <strong>
                                            {{ $mobil->name }}
                                        </strong>
                                    </div>
                                </td>
                                <td>
                                    {{ $mobil->brand->name ?? '-' }}
                                </td>
                                <td>
                                    {{ $mobil->cabang->name ?? '-' }}
                                </td>
                                <td>
                                    {{ $mobil->tahun }}
                                </td>
                                <td>
                                    Rp
                                    {{ number_format($mobil->harga_perhari, 0, ',', '.') }}
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
            <div class="text-center p-5">
                <i class="bi bi-car-front fs-1 text-muted"></i>
                <h5 class="fw-bold mt-3">
                    Belum ada data mobil
                </h5>
                <p class="text-muted">
                    Data mobil akan muncul setelah ditambahkan.
                </p>
            </div>
        @endif
    </div>
</section>


<section class="mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="section-title mb-1">
                Pengguna Terbaru
            </h3>
            <p class="text-muted mb-0">
                Pengguna terbaru yang terdaftar di RentalKu.
            </p>
        </div>
    </div>

    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="px-4 py-3">
                            Pengguna
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Role
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="px-4">
                                <strong>
                                    {{ $user->name }}
                                </strong>
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                @if($user->roles_id == 1)
                                    <span class="badge bg-dark">
                                        Admin
                                    </span>
                                @elseif($user->roles_id == 2)
                                    <span class="badge bg-primary">
                                        Staff
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        Customer
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="3"
                                class="text-center text-muted py-4"
                            >
                                Belum ada pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

</div>

{{-- Footer --}}
<footer class="bg-white border-top py-4 mt-auto">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-6">
                <div class="fw-bold">
                    Rental<span class="text-success">ku</span>.
                </div>
                <small class="text-muted">
                    Administrator Dashboard
                </small>
            </div>
            <div class="col-md-6 text-md-end">
                <small class="text-muted">
                    &copy; {{ date('Y') }} RentalKu. All rights reserved.
                </small>
            </div>
        </div>
    </div>
</footer>

</div>

{{-- Chart Laporan (animasi sekali saat pertama terlihat) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const section = document.getElementById('laporan');
    if (!section || typeof Chart === 'undefined') return;

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const tren = @json($laporan['tren']);
    let started = false;

    function countUp(el) {
        const target = parseFloat(el.dataset.countup || '0');
        const prefix = el.dataset.prefix || '';
        const done = prefix + Math.round(target).toLocaleString('id-ID');
        if (reduceMotion || !target) {
            el.textContent = done;
            return;
        }
        const dur = 1200;
        const t0 = performance.now();
        function tick(t) {
            const p = Math.min((t - t0) / dur, 1);
            const eased = 1 - Math.pow(1 - p, 3);
            el.textContent = prefix + Math.round(target * eased).toLocaleString('id-ID');
            if (p < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    function start() {
        if (started) return;
        started = true;
        section.querySelectorAll('[data-countup]').forEach(countUp);
        new Chart(document.getElementById('trenChart'), {
            type: 'bar',
            data: {
                labels: tren.map(t => t.tanggal),
                datasets: [{
                    data: tren.map(t => t.total),
                    backgroundColor: '#198754',
                    borderRadius: 6,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: reduceMotion ? false : {
                    duration: 1200,
                    easing: 'easeOutQuart',
                    delay: (ctx) => ctx.dataIndex * 60,
                },
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    y: {
                        ticks: {
                            callback: v => 'Rp ' + Number(v).toLocaleString('id-ID'),
                        },
                    },
                },
            },
        });
    }

    if (reduceMotion || !('IntersectionObserver' in window)) {
        start();
        return;
    }
    const obs = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (e.isIntersecting) {
                start();
                obs.disconnect();
            }
        });
    }, { threshold: 0.25 });
    obs.observe(section);
});
</script>

{{-- Bootstrap JS --}}
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>