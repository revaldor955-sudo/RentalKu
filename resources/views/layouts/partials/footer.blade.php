<footer id="footer-section">

    <div class="container">

        <div class="row g-3">

            <div class="col-lg-5">

                <div class="brand">
                    Rental<span>ku</span>.
                </div>

                <p class="mt-3">
                    Platform rental mobil yang membantu kamu
                    menemukan kendaraan yang nyaman, aman,
                    dan sesuai kebutuhan perjalanan.
                </p>

                <div class="d-flex gap-3 mt-4">

                    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" aria-label="WhatsApp">
                        <i class="bi bi-whatsapp fs-5"></i>
                    </a>

                </div>

            </div>

            <div class="col-6 col-lg-2">

                <div class="footer-title">
                    Navigasi
                </div>

                <div class="d-flex flex-column gap-2">

                    <a href="{{ url('/') }}">Beranda</a>
                    <a href="{{ url('/#mobil') }}">Mobil</a>
                    <a href="{{ url('/#tentang') }}">Tentang Kami</a>
                    <a href="{{ url('/#faq') }}">FAQ</a>

                </div>

            </div>

            <div class="col-6 col-lg-2">

                <div class="footer-title">
                    Layanan
                </div>

                <div class="d-flex flex-column gap-2">

                    <a href="{{ url('/#mobil') }}">Rental Mobil</a>
                    <a href="{{ url('/#cara-rental') }}">Dengan Supir</a>
                    <a href="{{ url('/#cara-rental') }}">Tanpa Supir</a>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="footer-title">
                    Hubungi Kami
                </div>

                <div class="d-flex flex-column gap-3">

                    <div>
                        <i class="bi bi-geo-alt me-2"></i>
                        Pontianak, Kalimantan Barat
                    </div>

                    <div>
                        <i class="bi bi-telephone me-2"></i>
                        +62 812-3456-7890
                    </div>

                    <div>
                        <i class="bi bi-envelope me-2"></i>
                        info@rentalku.com
                    </div>

                </div>

            </div>

        </div>

        <hr class="border-secondary my-3">

        <div class="text-center">

            <small class="text-secondary">
                © {{ date('Y') }} Rentalku. All Rights Reserved.
            </small>

        </div>

    </div>

</footer>