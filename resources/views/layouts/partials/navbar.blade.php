<nav class="navbar navbar-expand-lg fixed-top shadow-sm" id="mainNavbar" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); transition: transform 0.2s ease-out;">

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
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ url('/') }}">
                        Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/#mobil') }}">
                        Mobil
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('katalog.index', 'mobils.show') ? 'active' : '' }}" href="{{ route('katalog.index') }}">
                        Katalog
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/#tentang') }}">
                        Tentang Kami
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/#cara-rental') }}">
                        Cara Rental
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/#faq') }}">
                        FAQ
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/#kontak') }}">
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
            class="btn px-3 py-2 fw-semibold d-flex align-items-center gap-2 nav-btn-ghost"
        >
            <i class="bi bi-box-arrow-in-right"></i>
            Masuk
        </a>

        <a
            href="{{ route('register') }}"
            class="btn px-3 py-2 fw-semibold d-flex align-items-center gap-2 nav-btn-ghost"
        >
            <i class="bi bi-person-plus"></i>
            Daftar
        </a>

    @endauth

</div>

        </div>

    </div>

</nav>