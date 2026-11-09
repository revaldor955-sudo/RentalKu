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
            background: #f3f7f6;
            color: #29494a;
            min-height: 100vh;
        }

        .tracking-card {
            background: white;
            border: 1px solid #e5eeee;
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(30, 70, 65, .05);
        }

        .tracking-icon {
            width: 65px;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            border-radius: 18px;
            background: #e6f2ef;
            color: #28766e;
            font-size: 30px;
        }

        .page-title {
            font-size: 23px;
            font-weight: 800;
            color: #24575c;
        }

        .info-label {
            font-size: 11px;
            color: #87999a;
        }

        .info-value {
            font-size: 14px;
            font-weight: 700;
            color: #24575c;
        }

        .info-box {
            background: #f6f9f8;
            border-radius: 10px;
            padding: 13px;
            height: 100%;
        }

        .btn-start {
            background: #28766e;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-weight: 700;
            width: 100%;
        }

        .btn-start:hover {
            background: #205e58;
            color: white;
        }

        .btn-stop {
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-weight: 700;
            width: 100%;
        }

        .btn-stop:hover {
            background: #bb2d3b;
            color: white;
        }

        .status-box {
            background: #f6f9f8;
            border-radius: 10px;
            padding: 15px;
            font-size: 12px;
        }

        .coordinate {
            font-size: 13px;
            font-weight: 700;
            color: #28766e;
            word-break: break-word;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <div class="tracking-card">

                <div class="text-center mb-4">
                    <div class="tracking-icon mb-3">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>

                    <h4 class="page-title mb-1">Pengirim GPS RentalKu</h4>
                    <p class="text-secondary small mb-0">
                        Pengiriman koordinat lokasi mobil secara otomatis.
                    </p>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="info-box">
                            <div class="info-label mb-1">Nama Mobil</div>
                            <div class="info-value">
                                {{ $rental->mobil->name ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="info-box">
                            <div class="info-label mb-1">Nomor Plat</div>
                            <div class="info-value">
                                {{ $rental->mobil->plate_number ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="info-box">
                            <div class="info-label mb-1">Customer</div>
                            <div class="info-value">
                                {{ $rental->user->name ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="status-box mb-3">
                    <div class="fw-bold mb-2">
                        <i class="bi bi-activity"></i> Status Pelacakan
                    </div>
                    <div id="statusText" class="text-secondary">
                        Pelacakan belum dimulai.
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="info-box">
                            <div class="info-label mb-2">Latitude</div>
                            <div class="coordinate" id="latitude">Belum tersedia</div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="info-box">
                            <div class="info-label mb-2">Longitude</div>
                            <div class="coordinate" id="longitude">Belum tersedia</div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="button" class="btn-start" id="startButton" onclick="mulaiPelacakan()">
                        <i class="bi bi-play-fill"></i> Mulai Pelacakan
                    </button>

                    <button type="button" class="btn-stop" id="stopButton" onclick="hentikanPelacakan()" disabled>
                        <i class="bi bi-stop-fill"></i> Hentikan Pelacakan
                    </button>

                                  <a href="{{ route('customer.dashboard') }}"
                        class="btn btn-light border py-2">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="alert alert-info mt-4 mb-0 small">
                    <i class="bi bi-info-circle"></i>
                    Izinkan akses lokasi pada HP. Halaman harus tetap terbuka dan perangkat harus memiliki koneksi internet selama pengiriman koordinat.
                </div>

            </div>

        </div>
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
    const startButton = document.getElementById('startButton');
    const stopButton = document.getElementById('stopButton');

    function tampilkanStatus(pesan) {
        statusText.textContent = pesan;
    }

    function mulaiPelacakan() {
        if (!window.isSecureContext) {
            tampilkanStatus('Akses GPS membutuhkan HTTPS atau localhost yang aman.');
            return;
        }

        if (!navigator.geolocation) {
            tampilkanStatus('Browser tidak mendukung fitur GPS.');
            return;
        }

        if (watchId !== null) {
            return;
        }

        tampilkanStatus('Meminta izin akses lokasi...');

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

                tampilkanStatus(pesan);
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

        document.getElementById('latitude').textContent = latitude.toFixed(7);
        document.getElementById('longitude').textContent = longitude.toFixed(7);

        sedangMengirim = true;
        tampilkanStatus('Mengirim koordinat ke RentalKu...');

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
                throw new Error(hasil.message || 'Koordinat gagal dikirim.');
            }

            waktuKirimTerakhir = sekarang;

            tampilkanStatus(
                'Lokasi berhasil dikirim pada ' +
                new Date().toLocaleTimeString('id-ID')
            );

        } catch (error) {
            tampilkanStatus(error.message);
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

        tampilkanStatus('Pelacakan telah dihentikan.');
    }
</script>

</body>
</html>
