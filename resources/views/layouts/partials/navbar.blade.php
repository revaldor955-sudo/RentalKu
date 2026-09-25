<nav class="navbar navbar-expand-lg fixed-top shadow-sm" id="mainNavbar" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); transition: transform 0.15s ease-out; transform: translateY(-100%);">

    <div class="container">

        <a class="navbar-brand" href="{{ url('/') }}">
            Rental<span>ku</span>.
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
        >
            <i class="bi bi-list"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">
                        Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#mobil">
                        Mobil
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#tentang">
                        Tentang Kami
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#cara-rental">
                        Cara Rental
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#faq">
                        FAQ
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#kontak">
                        Kontak
                    </a>
                </li>

            </ul>

            <div class="d-flex gap-2 align-items-center">

    @auth

        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf

            <button
                type="submit"
                class="btn btn-light border rounded-3 px-3 fw-semibold"
            >
                Keluar
            </button>
        </form>

    @else

        <a
            href="{{ route('login') }}"
            class="btn btn-light border rounded-3 px-3 fw-semibold"
        >
            Masuk
        </a>

        <a
            href="{{ route('register') }}"
            class="btn btn-rent"
        >
            Daftar
        </a>

    @endauth

</div>

        </div>

    </div>

</nav>