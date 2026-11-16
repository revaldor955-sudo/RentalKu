
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelacakan GPS - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

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

       .gps-content {
    width: 100%;
    min-width: 0;
}

        .page-title {
            font-size: 25px;
            font-weight: 800;
            color: #000;
        }

        .page-subtitle {
            color: #000;
            font-size: 13px;
        }

        .stat-card {
            background: #fff;
            border-radius: 15px;
            padding: 22px;
            border: 1px solid #e8eeee;
            height: 100%;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            background: #e6f2ef;
            color: #24776c;
        }

        .stat-number {
            font-size: 25px;
            font-weight: 800;
            color: #000;
        }

        .stat-label {
            font-size: 12px;
            color: #000;
        }

        .content-card {
            background: #fff;
            border-radius: 15px;
            border: 1px solid #e8eeee;
            padding: 22px;
            height: 100%;
        }

        .section-title {
            font-size: 16px;
            font-weight: 800;
            color: #000;
        }

        .section-description {
            font-size: 12px;
            color: #000;
        }

        #map {
            height: 430px;
            width: 100%;
            border-radius: 12px;
            z-index: 1;
        }

        .rental-item {
            border: 1px solid #e9eeee;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 13px;
        }

        .car-icon {
            width: 43px;
            height: 43px;
            border-radius: 10px;
            background: #e6f2ef;
            color: #24776c;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 21px;
        }

        .car-name {
            font-size: 14px;
            font-weight: 700;
            color: #000;
        }

        .car-detail {
            font-size: 11px;
            color: #000;
        }

        .coordinate-text {
            font-size: 11px;
            color: #000;
            margin-top: 8px;
            word-break: break-word;
        }

        .btn-map {
            background: #e6f2ef;
            color: #24776c;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .btn-map:hover {
            background: #d5e9e4;
            color: #205e58;
        }

        .badge-running {
            background: #e3f4e9;
            color: #23834b;
            font-size: 10px;
            padding: 6px 9px;
            border-radius: 20px;
        }

        .empty-state {
            text-align: center;
            padding: 35px 15px;
            color: #000;
        }

        .empty-state i {
            font-size: 38px;
            color: #b5c9c6;
        }

        @media (max-width: 991px) {
            #map {
                height: 350px;
            }
        }
    </style>
</head>
<body>

@include('layouts.partials.sidebar')

<div class="page-content">
<div class="container-fluid px-4">

<div class="gps-content">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="page-title mb-1">Pelacakan GPS</h4>
            <p class="page-subtitle mb-0">Pantau titik lokasi mobil yang sedang dirental.</p>
        </div>

        <div>
            <span class="badge text-bg-light border p-2">
                <i class="bi bi-geo-alt-fill text-success"></i>
                Sistem Pelacakan Mobil
            </span>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label mb-2">Mobil Sedang Dirental</div>
                        <div class="stat-number">{{ $rentals->count() }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-car-front-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label mb-2">Koordinat Tersimpan</div>
                        <div class="stat-number">{{ $lokasis->count() }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label mb-2">Belum Ada Koordinat</div>
                        <div class="stat-number">{{ max(0, $rentals->count() - $lokasis->count()) }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-geo"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">

        <div class="col-lg-8">
            <div class="content-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="section-title mb-1">Peta Lokasi Mobil</h6>
                        <p class="section-description mb-0">Titik koordinat mobil yang sudah disimpan.</p>
                    </div>

                    <button type="button" class="btn-map" onclick="refreshMap()">
                        <i class="bi bi-arrow-clockwise"></i> Perbarui Peta
                    </button>
                </div>

                <div id="map"></div>

                <div class="mt-3 d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle text-success"></i>
                    <span class="section-description">
                        Pilih tombol Lihat Lokasi pada daftar mobil untuk melihat titiknya di peta.
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="content-card">
                <div class="mb-3">
                    <h6 class="section-title mb-1">Daftar Mobil Rental</h6>
                    <p class="section-description mb-0">Mobil dengan status rental berjalan.</p>
                </div>

                @forelse ($rentals as $rental)

                    @php
                        $lokasi = $lokasis->firstWhere('rental_id', $rental->id);
                    @endphp

                    <div class="rental-item">

                        <div class="d-flex align-items-start gap-3">
                            <div class="car-icon">
                                <i class="bi bi-car-front-fill"></i>
                            </div>

                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between gap-2">
                                    <div class="car-name">
                                        {{ $rental->mobil->name ?? 'Mobil tidak tersedia' }}
                                    </div>
                                    <span class="badge-running">Sedang Dirental</span>
                                </div>

                                <div class="car-detail mt-1">
                                    <i class="bi bi-person"></i>
                                    {{ $rental->user->name ?? '-' }}
                                </div>

                                <div class="car-detail mt-1">
                                    <i class="bi bi-card-text"></i>
                                    {{ $rental->mobil->plate_number ?? '-' }}
                                </div>

                                @if ($lokasi)
                                    <div class="coordinate-text">
                                        <i class="bi bi-geo-alt-fill text-success"></i>
                                        {{ $lokasi->latitude }}, {{ $lokasi->longitude }}
                                    </div>
                                @else
                                    <div class="coordinate-text text-danger">
                                        <i class="bi bi-exclamation-circle"></i>
                                        Koordinat belum tersedia
                                    </div>
                                @endif

                                <div class="mt-2">
                                    <span id="gps-status-{{ $rental->id }}"
                                        class="badge rounded-pill
                                        @if (!$lokasi)
                                            text-bg-warning
                                        @elseif ($lokasi->updated_at && $lokasi->updated_at->gte(now()->subSeconds(30)))
                                            text-bg-success
                                        @else
                                            text-bg-secondary
                                        @endif">

                                        @if (!$lokasi)
                                            Belum Ada Lokasi
                                        @elseif ($lokasi->updated_at && $lokasi->updated_at->gte(now()->subSeconds(30)))
                                            GPS Aktif
                                        @else
                                            Tidak Ada Pembaruan
                                        @endif
                                    </span>
                                </div>

                                <div class="car-detail mt-2" id="gps-time-{{ $rental->id }}">
                                    @if ($lokasi)
                                        Terakhir diperbarui:
                                        {{ $lokasi->updated_at->format('d/m/Y H:i:s') }}
                                    @else
                                        Belum ada waktu pembaruan
                                    @endif
                                </div>

                                <div class="d-flex flex-wrap gap-2 mt-3">

                                    @if ($lokasi)
                                        <button type="button"
                                            class="btn-map"
                                            onclick="lihatLokasi({{ (float) $lokasi->latitude }}, {{ (float) $lokasi->longitude }}, {{ $rental->id }})">
                                            <i class="bi bi-map"></i> Lihat Lokasi
                                        </button>
                                    @endif

                                    <a href="{{ route('pelacakan-gps.riwayat', $rental->id) }}"
                                        class="btn-map text-decoration-none">
                                        <i class="bi bi-clock-history"></i> Riwayat Lokasi
                                    </a>

                                    <form action="{{ route('pelacakan-gps.hapus', $rental->id) }}"
                                        method="POST"
                                        class="form-hapus-gps">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm"
                                            style="border-radius: 8px; font-size: 11px; font-weight: 600; padding: 8px 12px;">
                                            <i class="bi bi-trash3"></i> Hapus
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>

                @empty

                    <div class="empty-state">
                        <i class="bi bi-car-front"></i>
                        <h6 class="mt-3 fw-bold">Belum Ada Mobil Dirental</h6>
                        <p class="small mb-0">Mobil dengan status Berjalan akan muncul di sini.</p>
                    </div>

                @endforelse

            </div>
        </div>

    </div>

</div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.querySelectorAll('.form-hapus-gps').forEach(function (form) {
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        Swal.fire({
            title: 'Hapus Data GPS?',
            text: 'Koordinat dan seluruh riwayat lokasi rental ini akan dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(function (result) {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

const dataUrl = @json(route('pelacakan-gps.data'));

const map = L.map('map').setView([-0.0263, 109.3425], 12);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

const markers = {};

function buatPopup(lokasi) {
    const popup = document.createElement('div');

    const nama = document.createElement('strong');
    nama.textContent = lokasi.mobil;

    const plat = document.createElement('div');
    plat.textContent = 'Plat: ' + lokasi.plat;

    const customer = document.createElement('div');
    customer.textContent = 'Customer: ' + lokasi.customer;

    const waktu = document.createElement('div');
    waktu.textContent = lokasi.updated_at
        ? 'Pembaruan: ' + new Date(lokasi.updated_at).toLocaleString('id-ID')
        : 'Belum ada pembaruan';

    popup.append(nama, plat, customer, waktu);

    return popup;
}

function perbaruiStatus(lokasi) {
    const id = String(lokasi.rental_id);

    const statusElement =
        document.getElementById('gps-status-' + id);

    const waktuElement =
        document.getElementById('gps-time-' + id);

    if (statusElement) {
        if (lokasi.gps_status === 'aktif') {
            statusElement.className =
                'badge rounded-pill text-bg-success';

            statusElement.textContent = 'GPS Aktif';
        } else {
            statusElement.className =
                'badge rounded-pill text-bg-danger';

            statusElement.textContent = 'GPS Tidak Aktif';
        }
    }

    if (waktuElement && lokasi.updated_at) {
        const waktu = new Date(lokasi.updated_at);

        waktuElement.textContent =
            'Terakhir diperbarui: ' +
            waktu.toLocaleString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
    }
}

async function refreshMap() {
    try {
        const response = await fetch(dataUrl, {
            headers: {
                'Accept': 'application/json'
            },
            credentials: 'same-origin',
            cache: 'no-store'
        });

        if (!response.ok) {
            throw new Error('Gagal mengambil data koordinat.');
        }

        const data = await response.json();

        const rentalAktif = [];

        data.forEach(function (lokasi) {
            const id = String(lokasi.rental_id);

            perbaruiStatus(lokasi);

            if (
                lokasi.latitude === null ||
                lokasi.longitude === null ||
                lokasi.latitude === '' ||
                lokasi.longitude === ''
            ) {
                return;
            }

            const latitude = Number(lokasi.latitude);
            const longitude = Number(lokasi.longitude);

            if (
                !Number.isFinite(latitude) ||
                !Number.isFinite(longitude) ||
                latitude < -90 ||
                latitude > 90 ||
                longitude < -180 ||
                longitude > 180
            ) {
                return;
            }

            const posisi = [latitude, longitude];

            rentalAktif.push(id);

            if (markers[id]) {
                markers[id].setLatLng(posisi);
                markers[id].setPopupContent(buatPopup(lokasi));
            } else {
                markers[id] = L.marker(posisi).addTo(map);
                markers[id].bindPopup(buatPopup(lokasi));
            }
        });

        Object.keys(markers).forEach(function (id) {
            if (!rentalAktif.includes(id)) {
                map.removeLayer(markers[id]);
                delete markers[id];
            }
        });

    } catch (error) {
        console.error('Pelacakan GPS:', error);
    }
}

function lihatLokasi(latitude, longitude, rentalId) {
    latitude = Number(latitude);
    longitude = Number(longitude);

    if (
        !Number.isFinite(latitude) ||
        !Number.isFinite(longitude)
    ) {
        alert('Koordinat lokasi tidak valid.');
        return;
    }

    map.invalidateSize();
    map.setView([latitude, longitude], 17);

    const id = String(rentalId);

    if (markers[id]) {
        markers[id].openPopup();
    } else {
        markers[id] = L.marker([latitude, longitude]).addTo(map);
        markers[id].bindPopup('Lokasi mobil rental').openPopup();
    }
}

refreshMap();

setInterval(refreshMap, 10000);

setTimeout(function () {
    map.invalidateSize();
}, 300);
</script>

</body>
</html>
