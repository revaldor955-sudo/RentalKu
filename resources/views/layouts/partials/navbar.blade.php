<nav class="rk-navbar" id="rkNavbar">

    <div class="container rk-navbar-inner">

        {{-- LOGO --}}
        <a class="rk-logo" href="{{ url('/') }}">
            Rental<span>ku</span><b>.</b>
        </a>

        {{-- DESKTOP MENU --}}
        <div class="rk-desktop-menu">

            <a href="{{ url('/') }}" class="rk-nav-link">
                <span>01</span>
                Beranda
            </a>

            <a href="{{ url('/#mobil') }}" class="rk-nav-link">
                <span>02</span>
                Mobil
            </a>

            <a href="{{ url('/#tentang') }}" class="rk-nav-link">
                <span>03</span>
                Tentang Kami
            </a>

            <a href="{{ url('/#cara-rental') }}" class="rk-nav-link">
                <span>04</span>
                Cara Rental
            </a>

            <a href="{{ url('/#faq') }}" class="rk-nav-link">
                <span>05</span>
                FAQ
            </a>

            <a href="{{ url('/#kontak') }}" class="rk-nav-link">
                <span>06</span>
                Kontak
            </a>

        </div>


        {{-- DESKTOP AUTH --}}
        <div class="rk-navbar-actions">

            @auth

                <div class="rk-user">

                    <div class="rk-user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>

                    <div class="rk-user-name">
                        Halo, {{ Auth::user()->name }}
                    </div>

                </div>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf

                    <button type="submit" class="rk-logout">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Keluar</span>
                    </button>
                </form>

            @else

                <a href="{{ route('login') }}" class="rk-login">
                    Masuk
                </a>

                <a href="{{ route('register') }}" class="rk-register">
                    Daftar Sekarang
                    <i class="bi bi-arrow-up-right"></i>
                </a>

            @endauth

        </div>


        {{-- MOBILE BUTTON --}}
        <button
            type="button"
            class="rk-menu-button"
            id="rkMenuButton"
            aria-label="Buka menu"
            aria-expanded="false"
        >
            <span></span>
            <span></span>
        </button>

    </div>


    {{-- MOBILE MENU --}}
    <div class="rk-mobile-menu" id="rkMobileMenu">

        <div class="rk-mobile-menu-inner">

            <div class="rk-mobile-menu-label">
                MENU
            </div>

            <a href="{{ url('/') }}" class="rk-mobile-link">
                <span>01</span>
                <strong>Beranda</strong>
                <i class="bi bi-arrow-up-right"></i>
            </a>

            <a href="{{ url('/#mobil') }}" class="rk-mobile-link">
                <span>02</span>
                <strong>Mobil</strong>
                <i class="bi bi-arrow-up-right"></i>
            </a>

            <a href="{{ url('/#tentang') }}" class="rk-mobile-link">
                <span>03</span>
                <strong>Tentang Kami</strong>
                <i class="bi bi-arrow-up-right"></i>
            </a>

            <a href="{{ url('/#cara-rental') }}" class="rk-mobile-link">
                <span>04</span>
                <strong>Cara Rental</strong>
                <i class="bi bi-arrow-up-right"></i>
            </a>

            <a href="{{ url('/#faq') }}" class="rk-mobile-link">
                <span>05</span>
                <strong>FAQ</strong>
                <i class="bi bi-arrow-up-right"></i>
            </a>

            <a href="{{ url('/#kontak') }}" class="rk-mobile-link">
                <span>06</span>
                <strong>Kontak</strong>
                <i class="bi bi-arrow-up-right"></i>
            </a>


            <div class="rk-mobile-auth">

                @auth

                    <div class="rk-mobile-user">

                        <div class="rk-user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        <div>
                            <small>Login sebagai</small>
                            <strong>{{ Auth::user()->name }}</strong>
                        </div>

                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="rk-mobile-logout">
                            <i class="bi bi-box-arrow-right"></i>
                            Keluar
                        </button>
                    </form>

                @else

                    <div class="rk-mobile-buttons">

                        <a href="{{ route('login') }}" class="rk-mobile-login">
                            Masuk
                        </a>

                        <a href="{{ route('register') }}" class="rk-mobile-register">
                            Daftar Sekarang
                            <i class="bi bi-arrow-up-right"></i>
                        </a>

                    </div>

                @endauth

            </div>

        </div>

    </div>

</nav>
