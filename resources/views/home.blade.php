@extends('layouts.landing')

@section('title', 'Rentalku - Rental Mobil Terpercaya')

@section('content')

    <section class="hero">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">

                {{-- Slide default --}}
                <div class="carousel-item active hero-slide" style="background-image: url('{{ asset('images/banners/hero-jalan-palem.jpg') }}');" onerror="this.style.backgroundImage='url(data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1200 600%22%3E%3Crect fill=%22%23E8F0F1%22 width=%221200%22 height=%22600%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 font-family=%22Arial%22 font-size=%2224%22 fill=%22%232C666E%22%3EBanner tidak tersedia%3C/text%3E%3C/svg%3E)'">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="hero-content">
                            <div class="hero-badge">
                                <i class="bi bi-patch-check-fill"></i>
                                {{ $landingSettings['hero_badge'] ?? 'Rental mobil mudah & terpercaya' }}
                            </div>
                            <h1>
                                @if(!empty($landingSettings['hero_title']))
                                    {{ $landingSettings['hero_title'] }}
                                @else
                                    Perjalanan lebih mudah
                                    dengan <span>Rentalku.</span>
                                @endif
                            </h1>
                            <p>
                                {{ $landingSettings['hero_description'] ?? 'Temukan mobil yang sesuai kebutuhanmu. Pilih kendaraan, tentukan tanggal rental, dan lakukan rental dengan mudah secara online.' }}
                            </p>
                            <div class="hero-buttons">
                                <a href="#mobil" class="btn btn-hero btn-hero-primary">
                                    <i class="bi bi-car-front me-2"></i>
                                    Lihat Mobil
                                </a>
                                <a href="#cara-rental" class="btn btn-hero btn-hero-outline">
                                    Cara Rental
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Slide dari database --}}
                @foreach ($banners as $banner)
                    <div class="carousel-item hero-slide" style="background-image: url('{{ asset($banner->gambar) }}');" onerror="this.style.backgroundImage='url(data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1200 600%22%3E%3Crect fill=%22%23E8F0F1%22 width=%221200%22 height=%22600%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 font-family=%22Arial%22 font-size=%2224%22 fill=%22%232C666E%22%3E{{ htmlspecialchars($banner->judul) }}%3C/text%3E%3C/svg%3E)'">
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <div class="hero-content">
                                <div class="hero-badge">
                                    <i class="bi bi-megaphone-fill"></i>
                                    Promo Spesial
                                </div>
                                <h1>{{ $banner->judul }}</h1>
                                <p>{{ $banner->description }}</p>
                                <div class="hero-buttons">
                                    @if ($banner->link)
                                        <a href="{{ $banner->link }}" class="btn btn-hero btn-hero-primary"
                                           @if (str_starts_with($banner->link, 'http')) target="_blank" rel="noopener" @endif>
                                            Selengkapnya
                                            <i class="bi bi-arrow-right ms-2"></i>
                                        </a>
                                    @endif
                                    <a href="#mobil" class="btn btn-hero btn-hero-outline">
                                        <i class="bi bi-car-front me-2"></i>
                                        Lihat Mobil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            {{-- Indikator --}}
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                @foreach ($banners as $i => $banner)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $i + 1 }}" aria-label="Banner: {{ $banner->judul }}"></button>
                @endforeach
            </div>

            {{-- Navigasi --}}
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" aria-label="Slide sebelumnya">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" aria-label="Slide berikutnya">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    <section class="search-box">

        <div class="container">

            <div class="search-card">

                <form action="{{ route('home') }}" method="GET">

                    <div class="row g-3 align-items-end">

                        <div class="col-lg-4">

                            <div class="search-label">
                                Lokasi Pengambilan
                            </div>

                            <select name="cabang" class="form-select search-input" aria-label="Pilih cabang">

                                <option value="">
                                    Pilih cabang
                                </option>

                                @foreach ($cabangs as $item)

                                    <option value="{{ $item->id }}" @selected($cabangAktif?->id == $item->id)>
                                        {{ $item->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-lg-4">

                            <div class="search-label" id="status-label">
                                Status Mobil
                            </div>

                            <select name="status" aria-labelledby="status-label" class="form-select search-input">

                                <option value="tersedia" @selected($statusInput !== 'tidak_tersedia')>
                                    Tersedia
                                </option>

                                <option value="tidak_tersedia" @selected($statusInput === 'tidak_tersedia')>
                                    Tidak Tersedia
                                </option>

                            </select>

                        </div>

                        <div class="col-lg-4">

                            <button type="submit" class="btn btn-rent w-100 py-3">
                                <i class="bi bi-search me-2"></i>
                                Cari Mobil
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </section>

    <section class="section" id="mobil">

        <div class="container">

            <div id="daftar-mobil">
                @include('home.partials.daftar-mobil')
            </div>

        </div>

    </section>

    <section class="section section-light">

        <div class="container">

            <div class="text-center mb-5">

                <div class="text-success fw-bold mb-2">
                    {{ $landingSettings['brand_badge'] ?? 'BRAND PILIHAN' }}
                </div>

                <h2 class="section-title">
                    {{ $landingSettings['brand_title'] ?? 'Pilihan brand untukmu' }}
                </h2>

                <p class="section-subtitle mx-auto">
                    {{ $landingSettings['brand_description'] ?? 'Berbagai pilihan merek kendaraan tersedia untuk memenuhi kebutuhan perjalananmu.' }}
                </p>

            </div>

            <div class="row g-3 justify-content-center">

                @forelse($brands as $brand)
                    <div class="col-6 col-md-4 col-lg-2">

                        <div class="brand-card">

                            <div
                                class="brand-logo mx-auto d-flex align-items-center justify-content-center bg-light rounded-circle">
                                <i class="bi bi-car-front fs-4 text-success"></i>
                            </div>

                            <div class="fw-bold">
                                {{ $brand->name }}
                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12 text-center text-secondary">
                        Belum ada brand.
                    </div>
                @endforelse

            </div>

        </div>

    </section>

    <section class="section" id="tentang">

        <div class="container">

            <div class="row align-items-center g-5">

                <div class="col-lg-5">

                    <div class="text-success fw-bold mb-2">
                        {{ $landingSettings['about_badge'] ?? 'KENAPA RENTALKU?' }}
                    </div>

                    <h2 class="section-title">
                        {{ $landingSettings['about_title'] ?? 'Rental mobil tanpa ribet.' }}
                    </h2>

                    <p class="section-subtitle">
                        {{ $landingSettings['about_description'] ?? 'Kami menghadirkan pengalaman rental mobil yang praktis dengan proses pemesanan yang mudah dan transparan.' }}
                    </p>

                    <a href="#mobil" class="btn btn-rent mt-4">
                        Mulai Rental
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>

                </div>

                <div class="col-lg-7">

                    <div class="row g-4">

                        <div class="col-md-6">

                            <div class="feature-card">

                                <div class="feature-icon">
                                    <i class="bi {{ $landingSettings['about_feature_1_icon'] ?? 'bi-shield-check' }}"></i>
                                </div>

                                <h5>
                                    {{ $landingSettings['about_feature_1_title'] ?? 'Aman & Terpercaya' }}
                                </h5>

                                <p>
                                    {{ $landingSettings['about_feature_1_desc'] ?? 'Data kendaraan dan proses rental dikelola dengan sistem yang terstruktur.' }}
                                </p>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="feature-card">

                                <div class="feature-icon">
                                    <i class="bi {{ $landingSettings['about_feature_2_icon'] ?? 'bi-lightning-charge' }}"></i>
                                </div>

                                <h5>
                                    {{ $landingSettings['about_feature_2_title'] ?? 'Proses Cepat' }}
                                </h5>

                                <p>
                                    {{ $landingSettings['about_feature_2_desc'] ?? 'Rental mobil dapat dilakukan dengan mudah melalui website.' }}
                                </p>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="feature-card">

                                <div class="feature-icon">
                                    <i class="bi {{ $landingSettings['about_feature_3_icon'] ?? 'bi-wallet2' }}"></i>
                                </div>

                                <h5>
                                    {{ $landingSettings['about_feature_3_title'] ?? 'Harga Transparan' }}
                                </h5>

                                <p>
                                    {{ $landingSettings['about_feature_3_desc'] ?? 'Kamu dapat melihat harga rental sebelum melakukan rental.' }}
                                </p>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="feature-card">

                                <div class="feature-icon">
                                    <i class="bi {{ $landingSettings['about_feature_4_icon'] ?? 'bi-headset' }}"></i>
                                </div>

                                <h5>
                                    {{ $landingSettings['about_feature_4_title'] ?? 'Layanan Support' }}
                                </h5>

                                <p>
                                    {{ $landingSettings['about_feature_4_desc'] ?? 'Hubungi tim Rentalku jika membutuhkan bantuan selama proses rental.' }}
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    {{-- Statistik / Counter Section --}}
    <section class="py-5" style="background-color: var(--primary); color: white;">
        <div class="container">
            <div class="row text-center g-4">
            <div class="col-6 col-md-3">
                <h2 class="fw-bold display-5 mb-1">{{ !empty($landingSettings['stats_mobil_value']) ? $landingSettings['stats_mobil_value'] . '+' : $totalMobil . '+' }}</h2>
                <p class="mb-0 opacity-75">{{ $landingSettings['stats_mobil_label'] ?? 'Mobil Tersedia' }}</p>
            </div>
            <div class="col-6 col-md-3">
                <h2 class="fw-bold display-5 mb-1">{{ !empty($landingSettings['stats_pelanggan_value']) ? $landingSettings['stats_pelanggan_value'] . '+' : $totalPuas . '+' }}</h2>
                <p class="mb-0 opacity-75">{{ $landingSettings['stats_pelanggan_label'] ?? 'Pelanggan Puas' }}</p>
            </div>
            <div class="col-6 col-md-3">
                <h2 class="fw-bold display-5 mb-1">{{ $landingSettings['stats_support_value'] ?? '24/7' }}</h2>
                <p class="mb-0 opacity-75">{{ $landingSettings['stats_support_label'] ?? 'Layanan Support' }}</p>
            </div>
            <div class="col-6 col-md-3">
                <h2 class="fw-bold display-5 mb-1">{{ !empty($landingSettings['stats_rating_value']) ? $landingSettings['stats_rating_value'] : ($ratingRata ?: '4.9') }}</h2>
                <p class="mb-0 opacity-75">{{ $landingSettings['stats_rating_label'] ?? 'Rating Rata-rata' }}</p>
            </div>
            </div>
        </div>
    </section>

    {{-- Promo Urgency Banner --}}
    <section class="py-3" style="background: linear-gradient(135deg, #E8F0F1 0%, #F0EDEE 100%);">
        <div class="container">
            <div class="row align-items-center justify-content-center g-3">
                <div class="col-auto text-center">
                    <span class="badge rounded-pill px-3 py-2" style="background-color: var(--primary); font-size: 0.85rem;">
                        {{ $landingSettings['promo_title'] ?? '🔥 PROMO SPESIAL' }}
                    </span>
                </div>
                <div class="col-auto text-center d-none d-md-block">
                    <span class="fw-semibold" style="color: var(--primary-dark);">
                        {{ $landingSettings['promo_description'] ?? 'Diskon hingga 20% untuk rental mingguan — Berakhir dalam:' }}
                    </span>
                </div>
                <div class="col-auto">
                    <div id="countdownTimer" class="d-flex gap-2 fw-bold" style="color: var(--primary-dark); font-size: 1rem;">
                        <span class="bg-white rounded px-2 py-1 shadow-sm"><span id="cdHours">23</span>j</span>
                        <span class="bg-white rounded px-2 py-1 shadow-sm"><span id="cdMinutes">59</span>m</span>
                        <span class="bg-white rounded px-2 py-1 shadow-sm"><span id="cdSeconds">59</span>d</span>
                    </div>
                </div>
                <div class="col-auto">
                    <a href="{{ $landingSettings['promo_button_url'] ?? '#mobil' }}" class="btn btn-sm fw-bold" style="background-color: var(--primary); color: white; border-radius: 20px;">
                        {{ $landingSettings['promo_button_label'] ?? 'Klaim Sekarang →' }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="cara-rental">

        <div class="container">

            <div class="text-center mb-5">

                <div class="text-success fw-bold mb-2">
                    {{ $landingSettings['steps_badge'] ?? 'CARA RENTAL' }}
                </div>

                <h2 class="section-title">
                    {{ $landingSettings['steps_title'] ?? 'Rental mobil dalam beberapa langkah' }}
                </h2>

                <p class="section-subtitle mx-auto">
                    {{ $landingSettings['steps_description'] ?? 'Proses sederhana untuk mendapatkan mobil yang kamu butuhkan.' }}
                </p>

            </div>

            <div class="row g-5">

                <div class="col-md-6 col-lg-3">

                    <div class="step-card">

                        <div class="step-number">
                            01
                        </div>

                        <h5>
                            Pilih Mobil
                        </h5>

                        <p>
                            Cari dan pilih kendaraan sesuai
                            kebutuhan perjalananmu.
                        </p>

                    </div>

                </div>

                <div class="col-md-6 col-lg-3">

                    <div class="step-card">

                        <div class="step-number">
                            02
                        </div>

                        <h5>
                            Tentukan Jadwal
                        </h5>

                        <p>
                            Tentukan tanggal mulai dan selesai
                            rental mobil.
                        </p>

                    </div>

                </div>

                <div class="col-md-6 col-lg-3">

                    <div class="step-card">

                        <div class="step-number">
                            03
                        </div>

                        <h5>
                            Lakukan Rental
                        </h5>

                        <p>
                            Isi data rental dan pilih layanan
                            dengan atau tanpa supir.
                        </p>

                    </div>

                </div>

                <div class="col-md-6 col-lg-3">

                    <div class="step-card">

                        <div class="step-number">
                            04
                        </div>

                        <h5>
                            Siap Berangkat
                        </h5>

                        <p>
                            Setelah pembayaran dikonfirmasi,
                            mobil siap digunakan.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>

    @if ($ratings->count())

        <section class="section section-light" id="testimoni">

            <div class="container">

                <div class="text-center mb-5">

                    <div class="text-success fw-bold mb-2">
                        {{ $landingSettings['testimonial_badge'] ?? 'TESTIMONI' }}
                    </div>

                    <h2 class="section-title">
                        {{ $landingSettings['testimonial_title'] ?? 'Apa kata pelanggan?' }}
                    </h2>

                    <p class="section-subtitle mx-auto">
                        {{ $landingSettings['testimonial_description'] ?? 'Ribuan pelanggan telah mempercayakan perjalanan mereka kepada Rentalku.' }}
                    </p>

                </div>

                <div class="row g-4">

                    @foreach ($ratings as $rating)
                        <div class="col-md-6 col-lg-4">

                            <div class="rating-card">

                                <div class="stars">

                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rating->rating)
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor

                                </div>

                                <div class="rating-text">
                                    "{{ $rating->ulasan ?? 'Pelayanan sangat baik.' }}"
                                </div>

                                <div class="user-info">

                                    @if ($rating->foto_user)
                                        <img src="{{ asset('storage/' . $rating->foto_user) }}" class="user-avatar" alt="{{ $rating->nama }}" loading="lazy">
                                    @else
                                        <div class="user-avatar d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    @endif

                                    <div>

                                        <div class="fw-bold">
                                            {{ $rating->nama }}
                                        </div>

                                        <small class="text-secondary">
                                            {{ $rating->nama_mobil }}
                                        </small>

                                    </div>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

        </section>

    @endif

    <section class="section faq" id="faq">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-8">

                    <div class="text-center mb-5">

                        <div class="text-success fw-bold mb-2">
                            FAQ
                        </div>

                        <h2 class="section-title">
                            {{ $landingSettings['faq_title'] ?? 'Pertanyaan yang sering ditanyakan' }}
                        </h2>

                        @if(!empty($landingSettings['faq_description']))
                        <p class="text-secondary mt-3">
                            {{ $landingSettings['faq_description'] }}
                        </p>
                        @endif

                    </div>

                    <div class="accordion" id="faqAccordion">

                        @forelse($faqs as $key => $faq)
                            <div class="accordion-item">

                                <h2 class="accordion-header">

                                    <button class="accordion-button {{ $key !== 0 ? 'collapsed' : '' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq{{ $faq->id }}">
                                        {{ $faq->pertanyaan }}
                                    </button>

                                </h2>

                                <div id="faq{{ $faq->id }}"
                                    class="accordion-collapse collapse {{ $key === 0 ? 'show' : '' }}"
                                    data-bs-parent="#faqAccordion">

                                    <div class="accordion-body text-secondary">
                                        {{ $faq->jawaban }}
                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="text-center text-secondary">
                                Belum ada FAQ.
                            </div>
                        @endforelse

                    </div>

                </div>

            </div>

        </div>

    </section>

    <section class="section faq" id="sk">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-8">

                    <div class="text-center mb-5">

                        <div class="text-success fw-bold mb-2">
                            SYARAT & KETENTUAN
                        </div>

                        <h2 class="section-title">
                            Kebijakan Penggunaan Layanan
                        </h2>

                        <p class="section-subtitle mx-auto">
                            Silakan baca dengan seksama sebelum menggunakan layanan Rentalku.
                        </p>

                    </div>

                    <div class="accordion" id="skAccordion">

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#sk1">
                                    Syarat Umum Rental
                                </button>
                            </h2>
                            <div id="sk1" class="accordion-collapse collapse show" data-bs-parent="#skAccordion">
                                <div class="accordion-body text-secondary">
                                    <ul>
                                        <li>Penyewa harus berusia minimal 21 tahun dengan SIM yang masih berlaku.</li>
                                        <li>Penyewa bertanggung jawab penuh terhadap kendaraan selama masa rental.</li>
                                        <li>Pembayaran dapat dilakukan melalui transfer bank, kartu kredit, atau e-wallet.</li>
                                        <li>Deposit awal diperlukan sebagai jaminan untuk keamanan kendaraan.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sk2">
                                    Tanggung Jawab Penyewa
                                </button>
                            </h2>
                            <div id="sk2" class="accordion-collapse collapse" data-bs-parent="#skAccordion">
                                <div class="accordion-body text-secondary">
                                    <ul>
                                        <li>Penyewa wajib memeriksa kondisi kendaraan sebelum memulai rental.</li>
                                        <li>Dilarang menggunakan kendaraan untuk aktivitas ilegal atau berbahaya.</li>
                                        <li>Penyewa menanggung biaya perbaikan jika terjadi kerusakan akibat kelalaian.</li>
                                        <li>Kendaraan harus dikembalikan dalam kondisi bersih dan sesuai waktu perjanjian.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sk3">
                                    Kebijakan Pembatalan & Pengembalian
                                </button>
                            </h2>
                            <div id="sk3" class="accordion-collapse collapse" data-bs-parent="#skAccordion">
                                <div class="accordion-body text-secondary">
                                    <ul>
                                        <li>Pembatalan lebih dari 48 jam sebelum tanggal rental: refund 100%.</li>
                                        <li>Pembatalan 24-48 jam: refund 50%.</li>
                                        <li>Pembatalan kurang dari 24 jam: tidak ada refund.</li>
                                        <li>Keterlambatan pengembalian akan dikenakan denda Rp 200.000 per jam.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sk4">
                                    Asuransi & Ganti Rugi
                                </button>
                            </h2>
                            <div id="sk4" class="accordion-collapse collapse" data-bs-parent="#skAccordion">
                                <div class="accordion-body text-secondary">
                                    <ul>
                                        <li>Semua kendaraan dilindungi asuransi dasar. Asuransi tambahan dapat ditambahkan dengan biaya terpisah.</li>
                                        <li>Kerusakan akibat kelalaian penyewa menjadi tanggung jawab penyewa (sesuai estimasi bengkel resmi).</li>
                                        <li>Kehilangan atau pencurian kendaraan: penyewa bertanggung jawab penuh.</li>
                                        <li>Kerusakan ringan yang sudah tercakup dalam asuransi akan ditanggung Rentalku.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sk5">
                                    Kebijakan Privasi & Data
                                </button>
                            </h2>
                            <div id="sk5" class="accordion-collapse collapse" data-bs-parent="#skAccordion">
                                <div class="accordion-body text-secondary">
                                    <ul>
                                        <li>Data pribadi penyewa dijaga keamanannya sesuai standar industri.</li>
                                        <li>Rentalku tidak membagikan data pribadi kepada pihak ketiga tanpa persetujuan.</li>
                                        <li>Data transaksi disimpan untuk keperluan administrasi dan audit.</li>
                                        <li>Penyewa berhak mengajukan penghapusan data sesuai peraturan perlindungan data yang berlaku.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <style>
        #kontak {
            background-color: #f8f9fa;
            padding: 80px 0;
            border-top: 1px solid #eef2f0;
            border-bottom: 1px solid #eef2f0;
        }
        .contact-form {
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .contact-form .form-control {
            min-height: 48px;
            border-color: #d9e1e2;
            border-radius: 10px;
            transition: border-color .2s ease, box-shadow .2s ease;
        }
        .contact-form .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(44, 102, 110, .15);
        }
        .contact-form textarea.form-control {
            min-height: 120px;
        }
        .contact-form .is-invalid {
            border-color: #dc3545;
        }
        .contact-form .is-valid {
            border-color: #198754;
            padding-right: 2.75rem;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.25l2.974 3L8 2.193z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right .75rem center;
            background-size: 16px 16px;
        } 
        .contact-form textarea.is-valid {
            background-position: right .75rem top .75rem;
        }
        .contact-error-summary {
            border-left: 4px solid #dc3545;
        }
        .contact-error-summary a {
            color: #842029;
            text-decoration: underline;
        }
        .contact-field-error {
            color: #b02a37;
            font-size: .875rem;
            margin-top: 6px;
        }
        .contact-form button[disabled] {
            cursor: wait;
            opacity: .8;
        }
        .cta-banner {
            margin-top: 40px;
        }
        .cta {
            margin-bottom: 40px;
        }
    </style>

    {{-- Contact Form Section --}}
    <section class="section" id="kontak">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-8">

                    <div class="text-center mb-5">

                        <div class="text-success fw-bold mb-2">
                            HUBUNGI KAMI
                        </div>

                        <h2 class="section-title">
                            Ada pertanyaan?
                        </h2>

                        <p class="section-subtitle mx-auto">
                            Kami siap membantu Anda. Hubungi tim Rentalku atau isi form di bawah.
                        </p>

                    </div>

                    <div class="row g-4">

                        <div class="col-md-6">

                            <div class="contact-info">

                                <div class="contact-item mb-4">

                                    <div class="contact-icon">
                                        <i class="bi bi-telephone"></i>
                                    </div>

                                    <div>

                                        <h5>Telepon</h5>

                                        <p class="text-muted">+62 812-3456-7890</p>

                                    </div>

                                </div>

                                <div class="contact-item mb-4">

                                    <div class="contact-icon">
                                        <i class="bi bi-envelope"></i>
                                    </div>

                                    <div>

                                        <h5>Email</h5>

                                        <p class="text-muted">info@rentalku.com</p>

                                    </div>

                                </div>

                                <div class="contact-item">

                                    <div class="contact-icon">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>

                                    <div>

                                        <h5>Lokasi</h5>

                                        <p class="text-muted">Pontianak, Kalimantan Barat</p>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

@if(session('success'))

    <div id="contactSuccessFlag" class="d-none" data-message="{{ session('success') }}"></div>

@endif


@if($errors->any())

    <div class="alert alert-danger alert-dismissible fade show mb-4">

        <strong>
            Pesan belum dapat dikirim.
        </strong>

        <ul class="mb-0 mt-2">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

@endif                            

<form
    id="contactForm"
    action="{{ route('contact.store') }}"
    method="POST"
    class="contact-form"
    novalidate
>
                                @csrf

                                @if($errors->any())
                                    <div id="contactErrorSummary" class="alert alert-danger contact-error-summary" role="alert" tabindex="-1" aria-labelledby="contactErrorTitle">
                                        <h3 id="contactErrorTitle" class="h6 fw-bold">Periksa kembali data Anda</h3>
                                        <ul class="mb-0 ps-3">
                                            @foreach($errors->keys() as $field)
                                                <li><a href="#contact_{{ $field }}">{{ $errors->first($field) }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="mb-3">

                                    <label for="contact_name" class="form-label">Nama Lengkap</label>

<input
    type="text"
    class="form-control @error('nama') is-invalid @enderror"
    id="contact_name"
    name="nama"
    value="{{ old('nama') }}"
    placeholder="Nama Anda"
    autocomplete="name"
    required
    aria-describedby="contact_name_error"
>
                                    <p id="contact_name_error" class="contact-field-error @if(!$errors->has('nama')) d-none @endif" role="alert">@error('nama'){{ $message }}@enderror</p>
                                </div>

                                <div class="mb-3">

                                    <label for="contact_email" class="form-label">Email</label>

<input
    type="email"
    class="form-control @error('email') is-invalid @enderror"
    id="contact_email"
    name="email"
    value="{{ old('email') }}"
    placeholder="Email Anda"
    autocomplete="email"
    required
    aria-describedby="contact_email_error"
>
                                    <p id="contact_email_error" class="contact-field-error @if(!$errors->has('email')) d-none @endif" role="alert">@error('email'){{ $message }}@enderror</p>
                                </div>

                                <div class="mb-3">

                                    <label for="contact_subject" class="form-label">Subjek</label>

<input
    type="text"
    class="form-control @error('subjek') is-invalid @enderror"
    id="contact_subject"
    name="subjek"
    value="{{ old('subjek') }}"
    placeholder="Subjek pesan"
    required
    aria-describedby="contact_subject_error"
>
                                    <p id="contact_subject_error" class="contact-field-error @if(!$errors->has('subjek')) d-none @endif" role="alert">@error('subjek'){{ $message }}@enderror</p>
                                </div>

                                <div class="mb-3">

                                    <label for="contact_message" class="form-label">Pesan</label>

<textarea
    class="form-control @error('pesan') is-invalid @enderror"
    id="contact_message"
    name="pesan"
    rows="4"
    placeholder="Tuliskan pesan Anda..."
    required
    aria-describedby="contact_message_error"
>{{ old('pesan') }}</textarea>
                                    <p id="contact_message_error" class="contact-field-error @if(!$errors->has('pesan')) d-none @endif" role="alert">@error('pesan'){{ $message }}@enderror</p>
                                </div>

                                <button type="submit" class="btn btn-rent w-100" id="contactSubmitButton">
                                    <span class="contact-submit-label">Kirim Pesan</span>
                                    <span class="contact-submit-loading d-none"><span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Mengirim...</span>
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

        <div class="container">

            <div class="cta">

                <div class="row align-items-center">

                    <div class="col-lg-8">

                        <h2 class="fw-bold">
                            Siap memulai perjalananmu?
                        </h2>

                        <p class="mt-3 mb-0">
                            Pilih mobil favoritmu dan lakukan rental
                            dengan mudah bersama Rentalku.
                        </p>

                    </div>

                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                        <a href="#mobil" class="btn btn-light px-4 py-3 fw-bold">
                            Cari Mobil Sekarang
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <script>
        (function () {
            var form = document.getElementById('contactForm');
            if (!form) return;

            var fields = [
                { input: 'contact_name', error: 'contact_name_error', label: 'Nama lengkap', max: 100, type: 'text' },
                { input: 'contact_email', error: 'contact_email_error', label: 'Email', max: 150, type: 'email' },
                { input: 'contact_subject', error: 'contact_subject_error', label: 'Subjek', max: 200, type: 'text' },
                { input: 'contact_message', error: 'contact_message_error', label: 'Pesan', max: 5000, type: 'text' }
            ];

            function validateField(field) {
                var input = document.getElementById(field.input);
                var error = document.getElementById(field.error);
                var value = input.value.trim();
                var message = '';

                if (!value) message = field.label + ' wajib diisi.';
                else if (field.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) message = 'Format email tidak valid.';
                else if (value.length > field.max) message = field.label + ' maksimal ' + field.max + ' karakter.';

                input.classList.toggle('is-invalid', !!message);
                input.classList.toggle('is-valid', !message && !!value);
                error.textContent = message;
                error.classList.toggle('d-none', !message);
                return !message;
            }

            fields.forEach(function (field) {
                var input = document.getElementById(field.input);
                input.addEventListener('blur', function () { validateField(field); });
                input.addEventListener('change', function () { validateField(field); });
                input.addEventListener('input', function () {
                    validateField(field);
                });
            });

            // Browser autofill can populate values after this script starts.
            // Removed: autofill is optional, form validates on blur/change/input

            form.addEventListener('submit', function (event) {
                var valid = fields.map(validateField).every(Boolean);
                if (!valid) {
                    event.preventDefault();
                    var firstInvalid = form.querySelector('.is-invalid');
                    if (firstInvalid) firstInvalid.focus();
                    return;
                }

                var button = document.getElementById('contactSubmitButton');
                button.disabled = true;
                button.setAttribute('aria-busy', 'true');
                button.querySelector('.contact-submit-label').classList.add('d-none');
                button.querySelector('.contact-submit-loading').classList.remove('d-none');
            });

            var summary = document.getElementById('contactErrorSummary');
            if (summary) summary.focus();

            var success = form.parentElement.querySelector('.alert-success');
            if (success) {
                success.setAttribute('tabindex', '-1');
                success.setAttribute('role', 'status');
                success.focus();
            }

            var successFlag = document.getElementById('contactSuccessFlag');
            if (successFlag) {
                var msg = successFlag.getAttribute('data-message') || 'Pesan berhasil dikirim!';
                function showSwal() {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: msg,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#2c666e'
                        });
                    }
                }
                if (document.readyState === 'complete') showSwal();
                else window.addEventListener('load', showSwal);
            }
        })();

        $(function () {
            // Countdown promo urgency
            function startCountdown() {
                var end = new Date();
                end.setHours(23, 59, 59, 999);

                function pad(n) {
                    return n < 10 ? '0' + n : n;
                }

                function tick() {
                    var diff = end - new Date();
                    if (diff <= 0) diff = 0;
                    var h = Math.floor(diff / (1000 * 60 * 60));
                    var m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    var s = Math.floor((diff % (1000 * 60)) / 1000);
                    $('#cdHours').text(pad(h));
                    $('#cdMinutes').text(pad(m));
                    $('#cdSeconds').text(pad(s));
                }

                tick();
                setInterval(tick, 1000);
            }
            startCountdown();

            var $form = $('.search-card form');
            if (!$form.length) return;

            var form = $form[0];
            var $statusEl = $(form.elements.status);
            var $cabangEl = $(form.elements.cabang);
            var $tombol = $form.find('button[type="submit"]');
            var $kontainer = $('#daftar-mobil');

            function bangunQuery() {
                var params = new URLSearchParams();
                if ($cabangEl.val() !== '') params.set('cabang', $cabangEl.val());
                if ($statusEl.val() !== '') params.set('status', $statusEl.val());
                return params.toString();
            }

            var sedangCari = false;

            function cari(url, dorongRiwayat, gulirKeGrid) {
                if (sedangCari) return;
                sedangCari = true;
                $tombol.prop('disabled', true);
                $tombol.html('<span class="spinner-border spinner-border-sm me-2"></span>Mencari...');

                $.ajax({
                    url: url,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .done(function (html) {
                    $kontainer.html(html);
                    if (dorongRiwayat) history.pushState(null, '', url);
                    if (gulirKeGrid) {
                        $('#mobil')[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                })
                .fail(function () {
                    window.location.href = url;
                })
                .always(function () {
                    sedangCari = false;
                    $tombol.prop('disabled', false);
                    $tombol.html('<i class="bi bi-search me-2"></i>Cari Mobil');
                });
            }

            $form.on('submit', function (e) {
                e.preventDefault();

                var query = bangunQuery();

                if (query === '') {
                    cari(form.action, true, false);
                    return;
                }

                cari(form.action + '?' + query, true, false);
            });

            $(document).on('click', '#daftar-mobil [data-search-link]', function (e) {
                e.preventDefault();
                var $link = $(this);
                cari($link.attr('href'), true, $link.attr('data-search-top') !== undefined);
            });

            $(window).on('popstate', function () {
                cari(window.location.href, false, false);
            });
        });

        // Modal detail mobil — card + button trigger
        $(document).on('click', '.car-card[data-mobil-id], button[data-mobil-id]', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var mobilId = $(this).data('mobil-id');
            var modalEl = document.getElementById('mobilDetailModal');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            var $body = $('#mobilDetailModal .modal-body');

            $body.html('<div class="text-center py-5"><div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            modal.show();

            $.ajax({
                url: '/mobils/' + mobilId,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                method: 'GET'
            })
            .done(function (html) {
                $body.html(html);
            })
            .fail(function () {
                $body.html('<div class="alert alert-danger m-3"><i class="bi bi-exclamation-circle me-2"></i>Gagal memuat detail mobil.</div>');
            });
        });

        // Popup form sewa (SweetAlert) — untuk user yang login
        @auth
        window.openSewaPopup = function() {
            var $template = $('#sewaFormTemplate');
            if (!$template.length) return;

            if ($('.mobil-modal .mm-badge-available').length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Mobil sedang tidak tersedia.',
                });
                return;
            }

            bootstrap.Modal.getOrCreateInstance(document.getElementById('mobilDetailModal')).hide();

            var $carTitle = $('.mobil-modal .mm-title');

            Swal.fire({
                title: $carTitle.length ? $carTitle.text().trim() : 'Sewa Mobil',
                html: $template.html(),
                width: 600,
                showConfirmButton: false,
                didOpen: function() {
                    var $form = $('#swal2-html-container form#sewaForm');
                    if (!$form.length) $form = $('#swal2-html-container form').first();
                    if (!$form.length) return;

                    $form.on('submit', function(event) {
                        event.preventDefault();
                        var formData = new FormData($form[0]);
                        Swal.showLoading();

                        $.ajax({
                            url: $form.attr('action'),
                            method: 'POST',
                            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                            data: formData,
                            processData: false,
                            contentType: false
                        })
                        .done(function(data, textStatus, xhr) {
                            Swal.hideLoading();
                            if (xhr.status !== 200) {
                                var firstError = data.errors ? Object.values(data.errors).flat()[0] : (data.message || 'Terjadi kesalahan.');
                                Swal.fire({ icon: 'error', title: 'Gagal', text: firstError });
                                return;
                            }
                            Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message || 'Pengajuan sewa berhasil.', confirmButtonText: 'OK' })
                                .then(function() { window.location.href = '{{ route('customer.dashboard') }}'; });
                        })
                        .fail(function() {
                            Swal.hideLoading();
                            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Koneksi bermasalah. Silakan coba lagi.' });
                        });
                    });

                    // Supir profile card toggle
                    var supirSelect = document.querySelector('#supirSelectModal');
                    if (supirSelect) {
                        supirSelect.addEventListener('change', function() {
                            var card = document.querySelector('#supirProfileCardModal');
                            var opt = this.options[this.selectedIndex];
                            if (!card) return;
                            if (this.value === '') {
                                card.style.display = 'none';
                            } else {
                                document.querySelector('#supirNameModal').innerText = opt.dataset.name;
                                document.querySelector('#supirPhoneModal').innerText = opt.dataset.phone;
                                document.querySelector('#supirTarifModal').innerText = opt.dataset.tarif;
                                document.querySelector('#supirImgModal').src = opt.dataset.image;
                                card.style.display = 'block';
                            }
                        });
                    }
                }
            });
        };
        @endauth
    </script>

    {{-- Modal Detail Mobil --}}
    <div class="modal fade" id="mobilDetailModal" tabindex="-1" aria-labelledby="mobilDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title" id="mobilDetailLabel">Detail Mobil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                    <!-- Content loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>

@endsection
