<footer>
    <div class="container py-3">
        <div class="row g-3">
            <div class="col-lg-4">
                <a href="{{ url('/') }}" class="text-decoration-none footer-brand">
                    Rental<span>ku</span>.
                </a>
                <p class="footer-text mt-2 mb-0">Solusi rental mobil yang nyaman, mudah, dan terpercaya untuk perjalananmu.</p>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="text-white fw-bold mb-2">Menu</h6>
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ route('customer.dashboard') }}" class="footer-text text-decoration-none">Dashboard</a></li>
                    <li><a href="{{ route('customer.riwayat') }}" class="footer-text text-decoration-none">Riwayat</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-6">
                <h6 class="text-white fw-bold mb-2">Kontak</h6>
                <p class="footer-text mb-1">Pontianak, Kalimantan Barat</p>
                <p class="footer-text mb-0">+62 812-3456-7890</p>
            </div>
            <div class="col-lg-3">
                <h6 class="text-white fw-bold mb-2">Ikuti Kami</h6>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
        </div>
        <hr class="footer-line my-3">
        <div class="text-center">
            <p class="footer-text mb-0">&copy; 2026 RentalKu. Semua hak dilindungi.</p>
        </div>
    </div>
</footer>