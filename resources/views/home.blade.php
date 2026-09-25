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

                        <div class="col-lg-3">

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

                        <div class="col-lg-3">

                            <div class="search-label">
                                Tanggal Mulai
                            </div>

                            <input type="date" name="tanggal_mulai" value="{{ $mulai?->toDateString() }}"
                                min="{{ now()->toDateString() }}" class="form-control search-input">

                        </div>

                        <div class="col-lg-3">

                            <div class="search-label">
                                Tanggal Selesai
                            </div>

                            <input type="date" name="tanggal_selesai" value="{{ $selesai?->toDateString() }}"
                                min="{{ now()->toDateString() }}" class="form-control search-input">

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

            <div id="hasil-pencarian">
                @include('home.partials.hasil-pencarian')
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

    {{-- Statistik / Counter Section --}}
    <section class="py-5" style="background-color: var(--primary); color: white;">
        <div class="container">
            <div class="row text-center g-4">
            <div class="col-6 col-md-3">
                <h2 class="fw-bold display-5 mb-1">{{ $totalMobil }}+</h2>
                <p class="mb-0 opacity-75">Mobil Tersedia</p>
            </div>
            <div class="col-6 col-md-3">
                <h2 class="fw-bold display-5 mb-1">{{ $totalPuas }}+</h2>
                <p class="mb-0 opacity-75">Pelanggan Puas</p>
            </div>
            <div class="col-6 col-md-3">
                <h2 class="fw-bold display-5 mb-1">24/7</h2>
                <p class="mb-0 opacity-75">Layanan Support</p>
            </div>
            <div class="col-6 col-md-3">
                <h2 class="fw-bold display-5 mb-1">{{ $ratingRata ?: '4.9' }}</h2>
                <p class="mb-0 opacity-75">Rating Rata-rata</p>
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
                        🔥 PROMO SPESIAL
                    </span>
                </div>
                <div class="col-auto text-center d-none d-md-block">
                    <span class="fw-semibold" style="color: var(--primary-dark);">
                        Diskon hingga 20% untuk rental mingguan — Berakhir dalam:
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
                    <a href="#mobil" class="btn btn-sm fw-bold" style="background-color: var(--primary); color: white; border-radius: 20px;">
                        Klaim Sekarang →
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="cara-rental">

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

    <script>
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
            var $mulai = $(form.elements.tanggal_mulai);
            var $selesai = $(form.elements.tanggal_selesai);
            var $cabangEl = $(form.elements.cabang);
            var $tombol = $form.find('button[type="submit"]');
            var $kontainer = $('#hasil-pencarian');

            function sinkronMin() {
                $selesai.attr('min', $mulai.val() || '');
            }
            $mulai.on('change', sinkronMin);
            sinkronMin();

            function pesanError() {
                var adaMulai = $mulai.val() !== '';
                var adaSelesai = $selesai.val() !== '';

                $selesai[0].setCustomValidity('');

                if (adaMulai !== adaSelesai) {
                    return 'Lengkapi kedua tanggal (mulai dan selesai) atau kosongkan keduanya.';
                }
                if (adaSelesai && $selesai.val() < $mulai.val()) {
                    return 'Tanggal selesai tidak boleh sebelum tanggal mulai.';
                }
                return '';
            }

            function valid() {
                var pesan = pesanError();
                if (pesan !== '') {
                    $selesai[0].setCustomValidity(pesan);
                    $selesai[0].reportValidity();
                    return false;
                }
                return true;
            }

            function bangunQuery() {
                var params = new URLSearchParams();
                if ($cabangEl.val() !== '') params.set('cabang', $cabangEl.val());
                if ($mulai.val() !== '') params.set('tanggal_mulai', $mulai.val());
                if ($selesai.val() !== '') params.set('tanggal_selesai', $selesai.val());
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

                if (!valid()) return;

                var query = bangunQuery();

                if (query === '') {
                    cari(form.action, true, false);
                    return;
                }

                cari(form.action + '?' + query, true, false);
            });

            $(document).on('click', '#hasil-pencarian [data-search-link]', function (e) {
                e.preventDefault();
                var $link = $(this);
                cari($link.attr('href'), true, $link.attr('data-search-top') !== undefined);
            });

            $(window).on('popstate', function () {
                cari(window.location.href, false, false);
            });
        });
    </script>

@endsection
