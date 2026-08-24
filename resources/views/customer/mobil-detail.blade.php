<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
       {{ $mobil->name ?? 'Detail Mobil' }} - RentalKu
    </title>

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
            background: #f6f8f7;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1f2937;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #eee;
        }

        .brand {
            font-size: 25px;
            font-weight: 800;
            color: #1f2937;
        }

        .brand span {
            color: #198754;
        }

        .back-btn {
            color: #198754;
            text-decoration: none;
            font-weight: 600;
        }

        .back-btn:hover {
            color: #146c43;
        }

        .detail-card {
            background: white;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(0,0,0,.06);
        }

        .car-photo {
            width: 100%;
            height: 470px;
            object-fit: cover;
            object-position: center;
            border-radius: 18px;
            display: block;
        }

        .detail-content {
            padding: 40px;
        }

        .badge-available {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e8f7ef;
            color: #198754;
            padding: 8px 14px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
        }

        .badge-unavailable {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fde8e8;
            color: #dc3545;
            padding: 8px 14px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
        }

        .car-title {
            font-size: 34px;
            font-weight: 800;
            margin-top: 18px;
            margin-bottom: 10px;
        }

        .car-subtitle {
            color: #6b7280;
            font-size: 15px;
        }

        .price-box {
            background: #f1faf5;
            border-radius: 18px;
            padding: 20px;
            margin-top: 25px;
        }

        .price-label {
            color: #6b7280;
            font-size: 14px;
        }

        .price {
            color: #198754;
            font-size: 28px;
            font-weight: 800;
        }

        .price span {
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
        }

        .spec-card {
            background: #f8faf9;
            border: 1px solid #edf0ee;
            border-radius: 16px;
            padding: 17px;
            height: 100%;
        }

        .spec-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #e8f7ef;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            margin-bottom: 10px;
        }

        .spec-title {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .spec-value {
            font-weight: 700;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            color: #4b5563;
        }

        .feature i {
            color: #198754;
        }

        .btn-rental {
            background: #198754;
            color: white;
            border: none;
            border-radius: 13px;
            padding: 14px 25px;
            font-weight: 700;
            width: 100%;
        }

        .btn-rental:hover {
            background: #146c43;
            color: white;
        }

        .btn-back {
            border: 1px solid #dfe5e1;
            background: white;
            color: #374151;
            border-radius: 13px;
            padding: 13px 20px;
            font-weight: 600;
        }

        .btn-back:hover {
            background: #f5f7f6;
        }

        .section-title {
            font-weight: 800;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {

            .car-photo {
                height: 280px;
            }

            .detail-content {
                padding: 25px;
            }

            .car-title {
                font-size: 27px;
            }

        }

    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

{{-- NAVBAR --}}
<nav class="navbar">
    <div class="container py-3">

        <div class="d-flex align-items-center justify-content-between">

            <a href="{{ url('/') }}" class="text-decoration-none brand">
                Rental<span>ku</span>.
            </a>

            <div class="d-flex align-items-center gap-3">

                @auth

                    <span class="d-none d-md-block">
                        <i class="bi bi-person-circle"></i>
                        {{ Auth::user()->name }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-box-arrow-right"></i>
                            Keluar
                        </button>
                    </form>

                @else

                    <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        Masuk
                    </a>

                    <a href="{{ route('register') }}" class="btn btn-success btn-sm">
                        Daftar
                    </a>

                @endauth

            </div>

        </div>

    </div>
</nav>


<div class="container py-4">

    {{-- KEMBALI --}}
    <div class="mb-4">

        <a href="{{ route('customer.dashboard') }}" class="back-btn">

            <i class="bi bi-arrow-left me-2"></i>

            Kembali ke Dashboard

        </a>

    </div>


    {{-- DETAIL --}}
    <div class="detail-card">

        <div class="row g-0">

            {{-- FOTO --}}
            <div class="col-lg-6 p-3 p-md-4">

               @if($mobil->image)
    <img
        src="{{ asset($mobil->image) }}"
        class="car-photo"
        alt="{{ $mobil->name }}"
    >
@else
    <img
        src="https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg"
        class="car-photo"
        alt="Mobil Rental"
    >
@endif

            </div>


            {{-- INFORMASI --}}
            <div class="col-lg-6">

                <div class="detail-content">

                    @if($mobil->status === 'Tersedia')

    <span class="badge-available">

        <i class="bi bi-check-circle-fill"></i>

        Tersedia untuk disewa

    </span>

@else

    <span class="badge-unavailable">

        <i class="bi bi-x-circle-fill"></i>

        Tidak Tersedia untuk disewa

    </span>

@endif


                    <h1 class="car-title">

                    {{ $mobil->name }}

                    </h1>


                   <p class="car-subtitle">
    <i class="bi bi-car-front me-1"></i>

    {{ $mobil->brand->name ?? '-' }}

    ·

    {{ $mobil->tipeMobil->name ?? '-' }}
</p>


                    {{-- HARGA --}}
                    <div class="price-box">

                        <div class="price-label">
                            Harga sewa mulai dari
                        </div>

                        <div class="price">

                            Rp
{{ number_format($mobil->harga_perhari, 0, ',', '.') }}

                            <span>/ hari</span>

                        </div>

                    </div>


                   
                   {{-- SPESIFIKASI --}}
<div class="row g-3 mt-2">

    <div class="col-6">

        <div class="spec-card">

            <div class="spec-icon">
                <i class="bi bi-award"></i>
            </div>

            <div class="spec-title">
                Brand
            </div>

            <div class="spec-value">
                {{ $mobil->brand->name ?? '-' }}
            </div>

        </div>

    </div>


    <div class="col-6">

        <div class="spec-card">

            <div class="spec-icon">
                <i class="bi bi-car-front"></i>
            </div>

            <div class="spec-title">
                Tipe Mobil
            </div>

            <div class="spec-value">
                {{ $mobil->tipeMobil->name ?? '-' }}
            </div>

        </div>

    </div>


    <div class="col-6">

        <div class="spec-card">

            <div class="spec-icon">
                <i class="bi bi-people"></i>
            </div>

            <div class="spec-title">
                Kapasitas
            </div>

            <div class="spec-value">
                {{ $mobil->kapasitas }} Orang
            </div>

        </div>

    </div>


    <div class="col-6">

        <div class="spec-card">

            <div class="spec-icon">
                <i class="bi bi-gear"></i>
            </div>

            <div class="spec-title">
                Transmisi
            </div>

            <div class="spec-value">
                {{ $mobil->transmisi }}
            </div>

        </div>

    </div>


    <div class="col-6">

        <div class="spec-card">

            <div class="spec-icon">
                <i class="bi bi-palette"></i>
            </div>

            <div class="spec-title">
                Warna
            </div>

            <div class="spec-value">
                {{ $mobil->warna }}
            </div>

        </div>

    </div>


    <div class="col-6">

        <div class="spec-card">

            <div class="spec-icon">
                <i class="bi bi-calendar3"></i>
            </div>

            <div class="spec-title">
                Tahun
            </div>

            <div class="spec-value">
                {{ $mobil->tahun }}
            </div>

        </div>

    </div>

<div class="col-6">

    <div class="spec-card">

        <div class="spec-icon">
            <i class="bi bi-wallet2"></i>
        </div>

        <div class="spec-title">
            Deposit
        </div>

        <div class="spec-value">
            Rp {{ number_format($mobil->deposit, 0, ',', '.') }}
        </div>

    </div>

</div>

<div class="col-6">

    <div class="spec-card">

        <div class="spec-icon">
            <i class="bi bi-geo-alt"></i>
        </div>

        <div class="spec-title">
            Cabang
        </div>

        <div class="spec-value">
            {{ $mobil->cabang->name ?? '-' }}
        </div>

    </div>

</div>

</div>


                    {{-- BUTTON --}}
                   <div class="mt-4">

    @if($mobil->status === 'Tersedia')

        @auth

            <button
                type="button"
                class="btn btn-rental d-flex align-items-center justify-content-center"
                onclick="openSewaPopup()">

                <i class="bi bi-calendar-check me-2"></i>

                Sewa Sekarang

            </button>

        @else

            <a
                href="{{ route('login') }}"
                class="btn btn-rental d-flex align-items-center justify-content-center text-decoration-none">

                <i class="bi bi-box-arrow-in-right me-2"></i>

                Masuk untuk Sewa

            </a>

        @endauth

    @else

        <button
            type="button"
            class="btn btn-secondary w-100"
            style="border-radius: 13px; padding: 14px 25px;"
            disabled>

            <i class="bi bi-x-circle me-2"></i>

            Mobil Tidak Tersedia

        </button>

    @endif

</div>


                    <div class="text-center mt-3">

                        <small class="text-muted">

                            <i class="bi bi-shield-check me-1"></i>

                            Rental aman dan terpercaya bersama RentalKu

                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- INFORMASI TAMBAHAN --}}
    <div class="row mt-5 g-4">

        <div class="col-lg-7">

            <div class="bg-white rounded-4 p-4">

                <h4 class="section-title">
                    Tentang Mobil
                </h4>

               <p class="text-muted mb-0">

    {{ $mobil->description ?? 'Belum ada deskripsi mobil.' }}

</p>

            </div>

        </div>


        <div class="col-lg-5">

    <div class="bg-white rounded-4 p-4">

        <h4 class="section-title">
            Fasilitas
        </h4>

        @forelse($mobil->fasilitas as $fasilitas)

            <div class="feature">

                <i class="bi bi-check-circle-fill"></i>

                {{ $fasilitas->name }}

            </div>

        @empty

            <p class="text-muted mb-0">
                Belum ada fasilitas.
            </p>

        @endforelse

    </div>

</div>

{{-- FORM SEWA (server-rendered, di-inject ke SweetAlert) --}}
<div id="sewaFormTemplate" class="d-none">

    <form
        action="{{ route('rentals.store', $mobil->id) }}"
        method="POST"
        id="sewaForm">

        @csrf

        <div class="row g-3 text-start">

            <div class="col-md-6">

                <label class="form-label fw-semibold">
                    Cabang Ambil
                </label>

                <select
                    name="cabang_ambil_id"
                    class="form-select"
                    required>

                    <option value="" disabled selected>
                        Pilih cabang ambil
                    </option>

                    @foreach($cabangs as $cabang)

                        <option
                            value="{{ $cabang->id }}"
                            @selected(old('cabang_ambil_id', $mobil->cabang_id) == $cabang->id)>
                            {{ $cabang->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-6">

                <label class="form-label fw-semibold">
                    Cabang Kembali
                </label>

                <select
                    name="cabang_kembali_id"
                    class="form-select"
                    required>

                    <option value="" disabled selected>
                        Pilih cabang kembali
                    </option>

                    @foreach($cabangs as $cabang)

                        <option
                            value="{{ $cabang->id }}"
                            @selected(old('cabang_kembali_id', $mobil->cabang_id) == $cabang->id)>
                            {{ $cabang->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-6">

                <label class="form-label fw-semibold">
                    Tanggal Mulai
                </label>

                <input
                    type="date"
                    name="tanggal_mulai"
                    class="form-control"
                    min="{{ date('Y-m-d') }}"
                    value="{{ old('tanggal_mulai') }}"
                    required>

            </div>

            <div class="col-md-6">

                <label class="form-label fw-semibold">
                    Tanggal Selesai
                </label>

                <input
                    type="date"
                    name="tanggal_selesai"
                    class="form-control"
                    min="{{ date('Y-m-d') }}"
                    value="{{ old('tanggal_selesai') }}"
                    required>

            </div>

            <div class="col-12">

                <label class="form-label fw-semibold">
                    Catatan
                </label>

                <textarea
                    name="catatan"
                    class="form-control"
                    rows="3"
                    placeholder="Catatan tambahan jika diperlukan...">{{ old('catatan') }}</textarea>

            </div>

            <div class="col-12">

                <div class="alert alert-success py-2 mb-0">

                    <small>
                        <i class="bi bi-info-circle me-1"></i>
                        Harga: Rp {{ number_format($mobil->harga_perhari, 0, ',', '.') }}/hari.
                        Deposit Rp {{ number_format($mobil->deposit, 0, ',', '.') }}
                        ditambahkan ke total.
                    </small>

                </div>

            </div>

            <div class="col-12">

                <button type="submit" class="btn btn-success w-100 py-2">
                    <i class="bi bi-calendar-check me-1"></i>
                    Ajukan Sewa
                </button>

            </div>

        </div>

    </form>

</div>

<script
    src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    function openSewaPopup() {

        const template = document.getElementById('sewaFormTemplate');

        Swal.fire({
            title: 'Sewa {{ $mobil->name }}',
            html: template.innerHTML,
            width: 600,
            showConfirmButton: false,
            didOpen: () => {

                const form = document.querySelector('#swal2-html-container form');

                form.addEventListener('submit', async function (event) {

                    event.preventDefault();

                    const submitBtn = form.querySelector('button[type="submit"]');

                    // Tombol submit bawaan SweetAlert tidak dipakai; form submit
                    // dilempar ke server lewat fetch (tetap server-side).
                    const formData = new FormData(form);

                    Swal.showLoading();

                    try {

                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        Swal.hideLoading();

                        if (!response.ok) {

                            const firstError = data.errors
                                ? Object.values(data.errors).flat()[0]
                                : (data.message ?? 'Terjadi kesalahan.');

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: firstError,
                            });

                            return;
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message ?? 'Pengajuan sewa mobil berhasil dibuat.',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            window.location.href = '{{ route('customer.dashboard') }}';
                        });

                    } catch (error) {

                        Swal.hideLoading();

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Koneksi bermasalah. Silakan coba lagi.',
                        });
                    }
                });
            }
        });
    }

</script>

</body>
</html>