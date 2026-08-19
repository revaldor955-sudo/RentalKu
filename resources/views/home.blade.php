@extends('layouts.landing')

@section('title', 'Rentalku - Rental Mobil Terpercaya')

@section('content')

    <section class="hero">

        <div class="container">

            <div class="hero-content">

                <div class="hero-badge">
                    <i class="bi bi-patch-check-fill"></i>
                    Rental mobil mudah & terpercaya
                </div>

                <h1>
                    Perjalanan lebih mudah
                    dengan <span>Rentalku.</span>
                </h1>

                <p>
                    Temukan mobil yang sesuai kebutuhanmu.
                    Pilih kendaraan, tentukan tanggal rental,
                    dan lakukan rental dengan mudah secara online.
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

    </section>


    <section class="search-box">

        <div class="container">

            <div class="search-card">

                <form action="#" method="GET">

                    <div class="row g-3 align-items-end">

                        <div class="col-lg-3">

                            <div class="search-label">
                                Lokasi Pengambilan
                            </div>

                            <select class="form-select search-input">
                                <option selected>
                                    Pilih cabang
                                </option>

                                <option>
                                    Pontianak
                                </option>

                            </select>

                        </div>

                        <div class="col-lg-3">

                            <div class="search-label">
                                Tanggal Mulai
                            </div>

                            <input type="date" class="form-control search-input">

                        </div>

                        <div class="col-lg-3">

                            <div class="search-label">
                                Tanggal Selesai
                            </div>

                            <input type="date" class="form-control search-input">

                        </div>

                        <div class="col-lg-3">

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

            <div class="d-flex justify-content-between align-items-end mb-5">

                <div>

                    <div class="text-success fw-bold mb-2">
                        PILIH KENDARAAN
                    </div>

                    <h2 class="section-title">
                        Mobil pilihan untuk perjalananmu
                    </h2>

                    <p class="section-subtitle">
                        Pilih kendaraan yang sesuai dengan kebutuhan
                        dan budget perjalananmu.
                    </p>

                </div>

                <a href="#" class="btn btn-outline-dark d-none d-md-block">
                    Lihat Semua
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>

            </div>


            <div class="row g-4">

                @forelse($mobils as $mobil)
                    <div class="col-md-6 col-lg-4">

                        <div class="car-card">

                            @if ($mobil->fotoMobils->isNotEmpty())
                                <img src="{{ $mobil->fotoMobils->first()->url }}" class="car-image"
                                    alt="{{ $mobil->name }}">
                            @elseif($mobil->image)
                                <img src="{{ asset($mobil->image) }}" class="car-image" alt="{{ $mobil->name }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=900&q=80"
                                    class="car-image" alt="{{ $mobil->name }}">
                            @endif


                            <div class="car-content">

                                <div class="car-brand">
                                    {{ $mobil->brand->name ?? '-' }}
                                </div>

                                <div class="car-title">
                                    {{ $mobil->name }}
                                </div>


                                <div class="car-info mb-4">

                                    <span>
                                        <i class="bi bi-people me-1"></i>
                                        {{ $mobil->kapasitas }}
                                    </span>

                                    <span>
                                        <i class="bi bi-gear me-1"></i>
                                        {{ ucfirst($mobil->transmisi) }}
                                    </span>

                                    <span>
                                        <i class="bi bi-geo-alt me-1"></i>
                                        {{ $mobil->cabang->name ?? '-' }}
                                    </span>

                                </div>


                                <div class="d-flex justify-content-between align-items-center">

                                    <div>

                                        <div class="car-price">

                                            Rp {{ number_format($mobil->harga_perhari, 0, ',', '.') }}

                                            <small>
                                                /hari
                                            </small>

                                        </div>

                                    </div>

                                    <a href="{{ route('mobils.show', $mobil->id) }}" class="btn btn-rent">
                                        Detail
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12">

                        <div class="text-center py-5">

                            <div class="mb-3">
                                <i class="bi bi-car-front fs-1 text-secondary"></i>
                            </div>

                            <h5>
                                Belum ada mobil tersedia
                            </h5>

                            <p class="text-secondary">
                                Data mobil akan muncul di sini setelah
                                ditambahkan melalui dashboard admin.
                            </p>

                        </div>

                    </div>
                @endforelse

            </div>

        </div>

    </section>


    <section class="section section-light">

        <div class="container">

            <div class="text-center mb-5">

                <div class="text-success fw-bold mb-2">
                    BRAND PILIHAN
                </div>

                <h2 class="section-title">
                    Pilihan brand untukmu
                </h2>

                <p class="section-subtitle mx-auto">
                    Berbagai pilihan merek kendaraan tersedia
                    untuk memenuhi kebutuhan perjalananmu.
                </p>

            </div>


            <div class="row g-3 justify-content-center">

                @forelse($brands as $brand)
                    <div class="col-6 col-md-4 col-lg-2">

                        <div class="brand-card">

                            @if ($brand->logo)
                                <img src="{{ asset('storage/' . $brand->logo) }}" class="brand-logo" alt="{{ $brand->name }}">
                            @else
                                <div
                                    class="brand-logo mx-auto d-flex align-items-center justify-content-center bg-light rounded-circle">
                                    <i class="bi bi-car-front fs-4 text-success"></i>
                                </div>
                            @endif

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
                        KENAPA RENTALKU?
                    </div>

                    <h2 class="section-title">
                        Rental mobil tanpa ribet.
                    </h2>

                    <p class="section-subtitle">
                        Kami menghadirkan pengalaman rental mobil
                        yang praktis dengan proses pemesanan yang
                        mudah dan transparan.
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
                                    <i class="bi bi-shield-check"></i>
                                </div>

                                <h5>
                                    Aman & Terpercaya
                                </h5>

                                <p>
                                    Data kendaraan dan proses rental
                                    dikelola dengan sistem yang terstruktur.
                                </p>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="feature-card">

                                <div class="feature-icon">
                                    <i class="bi bi-lightning-charge"></i>
                                </div>

                                <h5>
                                    Proses Cepat
                                </h5>

                                <p>
                                    Rental mobil dapat dilakukan
                                    dengan mudah melalui website.
                                </p>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="feature-card">

                                <div class="feature-icon">
                                    <i class="bi bi-wallet2"></i>
                                </div>

                                <h5>
                                    Harga Transparan
                                </h5>

                                <p>
                                    Kamu dapat melihat harga rental
                                    sebelum melakukan rental.
                                </p>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="feature-card">

                                <div class="feature-icon">
                                    <i class="bi bi-headset"></i>
                                </div>

                                <h5>
                                    Layanan Support
                                </h5>

                                <p>
                                    Hubungi tim Rentalku jika membutuhkan
                                    bantuan selama proses rental.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <section class="section section-light" id="cara-rental">

        <div class="container">

            <div class="text-center mb-5">

                <div class="text-success fw-bold mb-2">
                    CARA RENTAL
                </div>

                <h2 class="section-title">
                    Rental mobil dalam beberapa langkah
                </h2>

                <p class="section-subtitle mx-auto">
                    Proses sederhana untuk mendapatkan mobil
                    yang kamu butuhkan.
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


    @if ($banners->count())

        <section class="section">

            <div class="container">

                <div id="promoCarousel" class="carousel slide" data-bs-ride="carousel">

                    <div class="carousel-inner">

                        @foreach ($banners as $key => $banner)
                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">

                                <div class="promo">

                                    <img src="{{ asset('storage/' . $banner->gambar) }}" alt="{{ $banner->judul }}">

                                    <div class="promo-content">

                                        <div class="mb-2 text-success fw-bold">
                                            RENTALKU
                                        </div>

                                        <h2 class="display-6 fw-bold">
                                            {{ $banner->judul }}
                                        </h2>

                                        <p class="mt-3">
                                            {{ $banner->description }}
                                        </p>
                                        

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>


                    @if ($banners->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>

                        <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    @endif

                </div>

            </div>

        </section>

    @endif


    @if ($ratings->count())

        <section class="section section-light">

            <div class="container">

                <div class="text-center mb-5">

                    <div class="text-success fw-bold mb-2">
                        TESTIMONI
                    </div>

                    <h2 class="section-title">
                        Apa kata pelanggan?
                    </h2>

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
                                        <img src="{{ asset('storage/' . $rating->foto_user) }}" class="user-avatar">
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
                            Pertanyaan yang sering ditanyakan
                        </h2>

                    </div>


                    <div class="accordion" id="faqAccordion">

                        @forelse($faqs as $key => $faq)
                            <div class="accordion-item">

                                <h2 class="accordion-header">

                                    <button class="accordion-button {{ $key !== 0 ? 'collapsed' : '' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faq{{ $faq->id_faq }}">
                                        {{ $faq->pertanyaan }}
                                    </button>

                                </h2>

                                <div id="faq{{ $faq->id_faq }}"
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


    <section class="section">

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

@endsection
