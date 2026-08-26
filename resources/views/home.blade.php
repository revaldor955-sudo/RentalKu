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


    <script>
        // Search box landing: validasi pasangan tanggal + pencarian AJAX
        // (partial hasil diganti tanpa reload, URL tetap disinkronkan).
        (function () {
            var form = document.querySelector('.search-card form');
            if (!form) return;

            var mulai = form.elements.tanggal_mulai;
            var selesai = form.elements.tanggal_selesai;
            var cabangEl = form.elements.cabang;
            var tombol = form.querySelector('button[type="submit"]');
            var kontainer = document.getElementById('hasil-pencarian');

            // ---------- Validasi ----------

            // Batasi tanggal selesai minimal mengikuti tanggal mulai
            function sinkronMin() {
                selesai.min = mulai.value || '';
            }
            mulai.addEventListener('change', sinkronMin);
            sinkronMin();

            // Return pesan error, atau '' jika valid.
            function pesanError() {
                var adaMulai = mulai.value !== '';
                var adaSelesai = selesai.value !== '';

                selesai.setCustomValidity('');

                if (adaMulai !== adaSelesai) {
                    return 'Lengkapi kedua tanggal (mulai dan selesai) atau kosongkan keduanya.';
                }
                if (adaSelesai && selesai.value < mulai.value) {
                    return 'Tanggal selesai tidak boleh sebelum tanggal mulai.';
                }
                return '';
            }

            function valid() {
                var pesan = pesanError();
                if (pesan !== '') {
                    selesai.setCustomValidity(pesan);
                    selesai.reportValidity();
                    return false;
                }
                return true;
            }

            // ---------- Pencarian AJAX ----------

            // Bangun query string dari field terisi saja agar URL bersih.
            function bangunQuery() {
                var params = new URLSearchParams();
                if (cabangEl.value !== '') params.set('cabang', cabangEl.value);
                if (mulai.value !== '') params.set('tanggal_mulai', mulai.value);
                if (selesai.value !== '') params.set('tanggal_selesai', selesai.value);
                return params.toString();
            }

            var sedangCari = false;

            function cari(url, dorongRiwayat, gulirKeGrid) {
                if (sedangCari) return;
                sedangCari = true;
                tombol.disabled = true;
                tombol.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mencari...';

                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(function (res) {
                        if (!res.ok) throw new Error('HTTP ' + res.status);
                        return res.text();
                    })
                    .then(function (html) {
                        kontainer.innerHTML = html;
                        if (dorongRiwayat) history.pushState(null, '', url);
                        // Konten menyusut (reset / lebih sedikit): pastikan
                        // pengguna tidak terdampar di area kosong bawah.
                        if (gulirKeGrid) {
                            document.getElementById('mobil').scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    })
                    .catch(function () {
                        // AJAX gagal (jaringan/server): jatuh ke submit normal.
                        window.location.href = url;
                    })
                    .then(function () {
                        sedangCari = false;
                        tombol.disabled = false;
                        tombol.innerHTML = '<i class="bi bi-search me-2"></i>Cari Mobil';
                    });
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                if (!valid()) return;

                var query = bangunQuery();

                // Tidak ada filter sama sekali: kembali ke tampilan default polos.
                if (query === '') {
                    cari(form.action, true, false);
                    return;
                }

                cari(form.action + '?' + query, true, false);
            });

            // Link reset / lihat-sedikit / load-more / reset-cta di area hasil
            // ikut AJAX, supaya tidak memicu reload setelah pencarian.
            document.addEventListener('click', function (e) {
                var link = e.target.closest('#hasil-pencarian [data-search-link]');
                if (!link) return;
                e.preventDefault();
                cari(link.href, true, link.hasAttribute('data-search-top'));
            });

            // Tombol back/forward browser: muat ulang hasil sesuai URL.
            window.addEventListener('popstate', function () {
                cari(window.location.href, false, false);
            });
        })();
    </script>

@endsection
