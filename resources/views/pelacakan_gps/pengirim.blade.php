
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pengirim GPS - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background: #f1f6f5;
            color: #29494a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 35px 15px;
        }

        .main-wrapper {
            width: 100%;
            max-width: 650px;
        }

        .brand-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            padding: 0 5px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .brand-icon {
            width: 43px;
            height: 43px;
            border-radius: 13px;
            background: #28766e;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
        }

        .brand-name {
            font-size: 19px;
            font-weight: 800;
            color: #24575c;
            margin: 0;
        }

        .brand-subtitle {
            font-size: 10px;
            color: #8b9d9d;
            margin: 2px 0 0;
            letter-spacing: 1px;
        }

        .secure-label {
            background: #e4f3ed;
            color: #23805f;
            border-radius: 30px;
            padding: 8px 13px;
            font-size: 10px;
            font-weight: 700;
        }

        .tracking-card {
            background: #fff;
            border: 1px solid #e6eeee;
            border-radius: 23px;
            overflow: hidden;
            box-shadow: 0 15px 45px rgba(30, 70, 65, .08);
        }

        .hero-section {
            background: linear-gradient(135deg, #24575c, #28766e);
            padding: 35px 30px 32px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before,
        .hero-section::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(255,255,255,.10);
            border-radius: 50%;
        }

        .hero-section::before {
            width: 190px;
            height: 190px;
            top: -100px;
            right: -45px;
        }

        .hero-section::after {
            width: 140px;
            height: 140px;
            bottom: -90px;
            left: -30px;
        }

        .gps-icon {
            width: 75px;
            height: 75px;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 34px;
            position: relative;
            z-index: 1;
        }

        .hero-section h4 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .hero-section p {
            color: rgba(255,255,255,.78);
            font-size: 12px;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .card-content {
            padding: 27px;
        }

        .section-heading {
            font-size: 12px;
            font-weight: 800;
            color: #24575c;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-heading i {
            color: #28766e;
            font-size: 17px;
        }

        .vehicle-box {
            background: #f5f9f8;
            border: 1px solid #e8f0ee;
            border-radius: 14px;
            padding: 16px;
            height: 100%;
            transition: .2s;
        }

        .vehicle-box:hover {
            border-color: #b9d9d1;
            background: #f0f8f5;
        }

        .info-icon {
            width: 34px;
            height: 34px;
            background: #e2f0ec;
            color: #28766e;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            margin-bottom: 11px;
        }

        .info-label {
            font-size: 10px;
            color: #91a1a0;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 13px;
            font-weight: 800;
            color: #24575c;
            overflow-wrap: anywhere;
        }

        .status-card {
            background: #f7f9f9;
            border: 1px solid #e9efee;
            border-radius: 15px;
            padding: 18px;
            margin-top: 25px;
        }

        .status-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .status-title {
            font-size: 12px;
            font-weight: 800;
            color: #24575c;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 11px;
            border-radius: 30px;
            background: #e9eeee;
            color: #718181;
            font-size: 10px;
            font-weight: 700;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            background: #98a5a5;
            border-radius: 50%;
        }

        .status-badge.active {
            background: #e2f5e9;
            color: #23804e;
        }

        .status-badge.active .status-dot {
            background: #25a55a;
            animation: pulse 1.5s infinite;
        }

        .status-badge.error {
            background: #fff0f0;
            color: #c44747;
        }

        .status-badge.error .status-dot {
            background: #dc3545;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(37,165,90,.5); }
            70% { box-shadow: 0 0 0 7px rgba(37,165,90,0); }
            100% { box-shadow: 0 0 0 0 rgba(37,165,90,0); }
        }

        .status-message {
            font-size: 12px;
            color: #718181;
            line-height: 1.7;
            margin: 0;
        }

        .coordinate-section {
            margin-top: 25px;
        }

        .coordinate-box {
            background: #f5f9f8;
            border: 1px solid #e8f0ee;
            border-radius: 14px;
            padding: 17px;
            height: 100%;
        }

        .coordinate-heading {
            display: flex;
            align-items: center;
            gap: 7px;
            color: #879a99;
            font-size: 10px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .coordinate-heading i {
            color: #28766e;
            font-size: 15px;
        }

        .coordinate-value {
            font-size: 13px;
            color: #28766e;
            font-weight: 800;
            word-break: break-all;
        }

        .coordinate-note {
            font-size: 10px;
            color: #a0adad;
            margin-top: 7px;
        }

        .action-section {
            margin-top: 27px;
        }

        .btn-start,
        .btn-stop {
            border: none;
            border-radius: 12px;
            padding: 14px;
            width: 100%;
            font-size: 12px;
            font-weight: 800;
            transition: .2s;
        }

        .btn-start {
            background: #28766e;
            color: white;
            box-shadow: 0 5px 14px rgba(40,118,110,.18);
        }

        .btn-start:hover:not(:disabled) {
            background: #205e58;
            color: white;
            transform: translateY(-2px);
        }

        .btn-stop {
            background: #fff0f0;
            color: #d44949;
            border: 1px solid #f5dada;
        }

        .btn-stop:hover:not(:disabled) {
            background: #dc3545;
            color: white;
        }

        .btn-start:disabled,
        .btn-stop:disabled {
            opacity: .45;
            cursor: not-allowed;
        }

        .btn-back {
            display: block;
            text-decoration: none;
            text-align: center;
            background: #f5f8f7;
            border: 1px solid #e7eeee;
            border-radius: 12px;
            padding: 13px;
            color: #526d6b;
            font-size: 12px;
            font-weight: 700;
            transition: .2s;
        }

        .btn-back:hover {
            background: #eaf2ef;
            color: #24575c;
        }

        .notice-box {
            display: flex;
            gap: 12px;
            background: #edf6f9;
            border: 1px solid #dcecf1;
            border-radius: 13px;
            padding: 15px;
            margin-top: 23px;
        }

        .notice-icon {
            font-size: 19px;
            color: #3986a0;
        }

        .notice-title {
            font-size: 11px;
            font-weight: 800;
            color: #36778b;
            margin-bottom: 4px;
        }

        .notice-text {
            font-size: 10px;
            line-height: 1.7;
            color: #668b98;
            margin: 0;
        }

        .footer-text {
            text-align: center;
            color: #9aabaa;
            font-size: 10px;
            margin-top: 20px;
        }

        @media (max-width: 576px) {
            body {
                padding: 20px 12px;
                align-items: flex-start;
            }

            .brand-name {
                font-size: 16px;
            }

            .hero-section {
                padding: 30px 20px;
            }

            .hero-section h4 {
                font-size: 19px;
            }

            .card-content {
                padding: 20px 17px;
            }

            .secure-label {
                font-size: 9px;
                padding: 7px 9px;
            }

            .info-value {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

<div class="main-wrapper">

    <div class="brand-header">
        <div class="brand-logo">
            <div class="brand-icon">
                <i class="bi bi-car-front-fill"></i>
            </div>
            <div>
                <h5 class="brand-name">RentalKu</h5>
                <p class="brand-subtitle">CAR RENTAL MANAGEMENT</p>
            </div>
        </div>

        <div class="secure-label">
            <i class="bi bi-shield-check me-1"></i>
            GPS CONNECT
        </div>
    </div>

    <div class="tracking-card">

        <div class="hero-section">
            <div class="gps-icon">
                <i class="bi bi-geo-alt-fill"></i>
            </div>

            <h4>Pengirim GPS</h4>
            <p>Kirim koordinat lokasi kendaraan secara langsung ke sistem RentalKu.</p>
        </div>

        <div class="card-content">

            <div class="section-heading">
                <i class="bi bi-car-front-fill"></i>
                INFORMASI PENYEWAAN
            </div>

            <div class="row g-3">

                <div class="col-6">
                    <div class="vehicle-box">
                        <div class="info-icon">
                            <i class="bi bi-car-front"></i>
                        </div>
                        <div class="info-label">Nama Mobil</div>
                        <div class="info-value">
                            {{ $rental->mobil->name ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="vehicle-box">
                        <div class="info-icon">
                            <i class="bi bi-card-text"></i>
                        </div>
                        <div class="info-label">Nomor Plat</div>
                        <div class="info-value">
                            {{ $rental->mobil->plate_number ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="vehicle-box">
                        <div class="info-icon">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="info-label">Nama Customer</div>
                        <div class="info-value">
                            {{ $rental->user->name ?? '-' }}
                        </div>
                    </div>
                </div>

            </div>

            <div class="status-card">

                <div class="status-header">
                    <div class="status-title">
                        <i class="bi bi-activity me-1"></i>
                        Status Pelacakan
                    </div>

                    <div class="status-badge" id="statusBadge">
                        <span class="status-dot"></span>
                        <span id="statusLabel">OFFLINE</span>
                    </div>
                </div>

                <p class="status-message" id="statusText">
                    Pelacakan belum dimulai. Tekan tombol mulai untuk mengirim koordinat lokasi kendaraan.
                </p>

            </div>

            <div class="coordinate-section">

                <div class="section-heading">
                    <i class="bi bi-crosshair"></i>
                    KOORDINAT LOKASI
                </div>

                <div class="row g-3">

                    <div class="col-6">
                        <div class="coordinate-box">
                            <div class="coordinate-heading">
                                <i class="bi bi-geo"></i>
                                LATITUDE
                            </div>

                            <div class="coordinate-value" id="latitude">
                                Belum tersedia
                            </div>

                            <div class="coordinate-note">
                                Garis lintang
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="coordinate-box">
                            <div class="coordinate-heading">
                                <i class="bi bi-geo-alt"></i>
                                LONGITUDE
                            </div>

                            <div class="coordinate-value" id="longitude">
                                Belum tersedia
                            </div>

                            <div class="coordinate-note">
                                Garis bujur
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="action-section">

                <div class="d-grid gap-3">

                    <button type="button"
                        class="btn-start"
                        id="startButton"
                        onclick="mulaiPelacakan()">

                        <i class="bi bi-play-circle-fill me-2"></i>
                        Mulai Pelacakan GPS
                    </button>

                    <button type="button"
                        class="btn-stop"
                        id="stopButton"
                        onclick="hentikanPelacakan()"
                        disabled>

                        <i class="bi bi-stop-circle-fill me-2"></i>
                        Hentikan Pelacakan
                    </button>

                    <a href="{{ route('customer.dashboard') }}"
                        class="btn-back">

                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali ke Dashboard
                    </a>

                </div>

            </div>

            <div class="notice-box">
                <div class="notice-icon">
                    <i class="bi bi-info-circle-fill"></i>
                </div>

                <div>
                    <div class="notice-title">Informasi Pengiriman GPS</div>
                    <p class="notice-text">
                        Izinkan akses lokasi pada browser atau HP.
                        Pastikan koneksi internet tersedia dan halaman
                        pengirim GPS tetap terbuka selama proses pengiriman.
                    </p>
                </div>
            </div>

        </div>
    </div>

    <div class="footer-text">
        &copy; {{ date('Y') }} RentalKu. Sistem Pengelolaan Rental Mobil.
    </div>

</div>

<script>
    const rentalId = {{ $rental->id }};
    const kirimUrl = @json(route('customer.gps.terima-lokasi', $rental->id));
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    let watchId = null;
    let waktuKirimTerakhir = 0;
    let sedangMengirim = false;

    const statusText = document.getElementById('statusText');
    const statusBadge = document.getElementById('statusBadge');
    const statusLabel = document.getElementById('statusLabel');

    const startButton = document.getElementById('startButton');
    const stopButton = document.getElementById('stopButton');

    function tampilkanStatus(pesan, tipe = 'normal') {
        statusText.textContent = pesan;

        statusBadge.className = 'status-badge';

        if (tipe === 'active') {
            statusBadge.classList.add('active');
            statusLabel.textContent = 'ONLINE';
        } else if (tipe === 'error') {
            statusBadge.classList.add('error');
            statusLabel.textContent = 'GAGAL';
        } else {
            statusLabel.textContent = 'OFFLINE';
        }
    }

    function mulaiPelacakan() {

        if (!window.isSecureContext) {
            tampilkanStatus(
                'Akses GPS membutuhkan HTTPS atau localhost yang aman.',
                'error'
            );
            return;
        }

        if (!navigator.geolocation) {
            tampilkanStatus(
                'Browser tidak mendukung fitur GPS.',
                'error'
            );
            return;
        }

        if (watchId !== null) {
            return;
        }

        tampilkanStatus('Meminta izin akses lokasi...', 'normal');

        watchId = navigator.geolocation.watchPosition(
            kirimKoordinat,

            function(error) {

                let pesan = 'Gagal mengambil lokasi.';

                if (error.code === 1) {
                    pesan = 'Izin lokasi ditolak. Aktifkan izin lokasi pada browser.';
                } else if (error.code === 2) {
                    pesan = 'Lokasi perangkat belum tersedia.';
                } else if (error.code === 3) {
                    pesan = 'Waktu pengambilan lokasi habis. Coba kembali.';
                }

                tampilkanStatus(pesan, 'error');

                startButton.disabled = false;
                stopButton.disabled = true;

                if (watchId !== null) {
                    navigator.geolocation.clearWatch(watchId);
                    watchId = null;
                }
            },

            {
                enableHighAccuracy: true,
                maximumAge: 5000,
                timeout: 20000
            }
        );

        startButton.disabled = true;
        stopButton.disabled = false;
    }

    async function kirimKoordinat(position) {

        const sekarang = Date.now();

        if (sekarang - waktuKirimTerakhir < 10000 || sedangMengirim) {
            return;
        }

        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;

        document.getElementById('latitude').textContent =
            latitude.toFixed(7);

        document.getElementById('longitude').textContent =
            longitude.toFixed(7);

        sedangMengirim = true;

        tampilkanStatus('Mengirim koordinat ke sistem RentalKu...', 'normal');

        try {

            const response = await fetch(kirimUrl, {
                method: 'POST',
                credentials: 'same-origin',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },

                body: JSON.stringify({
                    latitude: latitude,
                    longitude: longitude
                })
            });

            const hasil = await response.json();

            if (!response.ok) {
                throw new Error(
                    hasil.message || 'Koordinat gagal dikirim.'
                );
            }

            waktuKirimTerakhir = sekarang;

            tampilkanStatus(
                'Lokasi berhasil dikirim pada ' +
                new Date().toLocaleTimeString('id-ID'),
                'active'
            );

        } catch (error) {

            tampilkanStatus(error.message, 'error');

        } finally {

            sedangMengirim = false;

        }
    }

    function hentikanPelacakan() {

        if (watchId !== null) {
            navigator.geolocation.clearWatch(watchId);
            watchId = null;
        }

        startButton.disabled = false;
        stopButton.disabled = true;

        tampilkanStatus(
            'Pelacakan telah dihentikan.',
            'normal'
        );
    }
</script>

</body>
</html>
