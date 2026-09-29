<nav class="navbar navbar-expand-lg fixed-top shadow-sm" id="customerNavbar" style="background: rgba(255, 255, 255, 0.96); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px); border-bottom: 1px solid rgba(0, 0, 0, .05); transition: transform 0.2s ease-out; padding: 16px 0;">

    <style>
        /* Sembunyikan caretez Bootstrap pada tombol profil customer */
        .user-box.no-caret.dropdown-toggle::after {
            display: none;
        }
    </style>

    <div class="container">

        <a href="{{ route('customer.dashboard') }}" class="navbar-brand">
            Rental<span>ku</span>.
        </a>

        <button class="navbar-toggler d-lg-none border-0" type="button" data-bs-toggle="collapse" data-bs-target="#customerNav" aria-controls="customerNav" aria-expanded="false" aria-label="Menu navigasi">
            <i class="bi bi-list fs-3"></i>
        </button>

        <div class="collapse navbar-collapse" id="customerNav">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="{{ route('customer.dashboard') }}#mobil">Cari Mobil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="{{ route('customer.dashboard') }}#rental-saya">Rental Saya</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="{{ route('customer.kompensasi.index') }}">Kompensasi</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="user-box dropdown-toggle d-flex align-items-center gap-2 border-0 bg-transparent p-0 cursor-pointer no-caret"
                            id="profileDropdown"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                        <div class="user-avatar user-icon d-flex align-items-center justify-content-center rounded-circle text-white fw-bold overflow-hidden" style="width:38px; height:38px; background: var(--primary, #2C666E);">
                            @if(Auth::user()->photo)
                                <img src="{{ asset(Auth::user()->photo) }}" alt="Avatar" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <i class="bi bi-person fs-5"></i>
                            @endif
                        </div>
                        <span class="user-name fw-semibold" style="color: var(--dark, #111827);">
                            {{ Auth::user()->name }}
                        </span>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2" 
                        style="min-width: 220px; border-radius: 14px;" 
                        aria-labelledby="profileDropdown">
                        <li class="px-3 py-2 text-muted small border-bottom mb-2">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-envelope me-2"></i>
                                {{ Auth::user()->email }}
                            </div>
                        </li>
                        <li>
                            <button class="dropdown-item rounded-2 py-2 d-flex align-items-center" type="button" data-bs-toggle="modal" data-bs-target="#profileModal" data-mode="edit">
                                <i class="bi bi-person-badge me-3 text-secondary"></i>
                                Edit Profile
                            </button>
                        </li>
@unless(request()->routeIs('customer.riwayat'))
                        <li>
                            <a class="dropdown-item rounded-2 py-2" href="{{ route('customer.riwayat') }}">
                                <i class="bi bi-clock-history me-3 text-primary"></i>
                                Riwayat Rental
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
@endunless
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger rounded-2 py-2">
                                    <i class="bi bi-box-arrow-right me-3"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</nav>

<style>
    :root {
        --primary: #2C666E;
        --primary-dark: #1F4F54;
        --dark: #111827;
        --muted: #6b7280;
    }

    .navbar-brand {
        font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
        font-size: 25px;
        font-weight: 800;
        color: var(--dark) !important;
        text-decoration: none;
    }

    .navbar-brand span {
        color: var(--primary);
    }

    .navbar-nav .nav-link {
        color: #4b5563 !important;
        font-weight: 600;
        margin: 0 7px;
        padding: 8px 12px !important;
        transition: color 0.2s ease, background 0.2s ease !important;
        position: relative;
        border-radius: 10px !important;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
        color: var(--primary) !important;
        background: rgba(44, 102, 110, 0.08) !important;
    }

    .navbar-nav .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 2px;
        left: 50%;
        background-color: var(--primary);
        transition: width 0.2s ease, left 0.2s ease;
    }

    .navbar-nav .nav-link:hover::after,
    .navbar-nav .nav-link.active::after {
        width: 60%;
        left: 20%;
    }

    /* Mobile bottom tab navigation */
    .customer-bottom-tabs {
        z-index: 1030;
        padding-top: 6px;
        padding-bottom: max(10px, env(safe-area-inset-bottom));
        background: rgba(255, 255, 255, .98);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-top: 1px solid #e5e7eb;
        box-shadow: 0 -4px 20px rgba(17, 24, 39, .07);
    }
    .customer-bottom-tabs .tab-link {
        min-height: 48px;
        min-width: 44px;
        padding: 5px 6px 2px;
        color: #6b7280;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: .02em;
        line-height: 1.15;
        text-decoration: none;
        border-radius: 12px;
        transition: color .18s ease, background .18s ease, transform .14s ease;
        -webkit-tap-highlight-color: transparent;
    }
    .customer-bottom-tabs .tab-link i {
        display: block;
        margin: 0 auto 4px;
        font-size: 21px;
        line-height: 1;
        transition: transform .18s ease;
    }
    .customer-bottom-tabs .tab-link span { display:block; }
    .customer-bottom-tabs .tab-link:hover,
    .customer-bottom-tabs .tab-link:focus-visible {
        color: var(--primary);
        background: rgba(44, 102, 110, 0.08);
        outline: none;
    }
    .customer-bottom-tabs .tab-link:active { transform: scale(.95); }
    .customer-bottom-tabs .tab-link.active,
    .customer-bottom-tabs .tab-link[aria-current="page"] {
        color: var(--primary);
        background: rgba(44, 102, 110, 0.12);
    }
    .customer-bottom-tabs .tab-link.active i { transform: translateY(-1px); }

    @media (min-width: 992px) {
        .customer-bottom-tabs { display: none !important; }
    }
    @media (max-width: 991.98px) {
        body { padding-bottom: 78px; }
    }
</style>

{{-- Mobile bottom tab navigation — 4 tabs, ≤ lg only --}}
<nav class="customer-bottom-tabs d-lg-none fixed-bottom" aria-label="Navigasi utama pelanggan">
    <div class="container d-flex justify-content-around text-center px-1">
        <a href="{{ route('customer.dashboard') }}#mobil"
           class="tab-link flex-fill{{ request()->routeIs('customer.dashboard') && !request()->has('tab') ? ' active' : '' }}"
           aria-label="Cari mobil" data-tab="mobil">
            <i class="bi bi-search" aria-hidden="true"></i>
            <span>Cari</span>
        </a>
        <a href="{{ route('customer.dashboard') }}#rental-saya"
           class="tab-link flex-fill"
           aria-label="Rental saya" data-tab="rental-saya">
            <i class="bi bi-car-front-fill" aria-hidden="true"></i>
            <span>Rental Saya</span>
        </a>
        <a href="{{ route('customer.riwayat') }}"
           class="tab-link flex-fill{{ request()->routeIs('customer.riwayat') ? ' active' : '' }}"
           aria-label="Riwayat rental" @if(request()->routeIs('customer.riwayat')) aria-current="page" @endif>
            <i class="bi bi-clock-history" aria-hidden="true"></i>
            <span>Riwayat</span>
        </a>
        <a href="{{ route('customer.kompensasi.index') }}"
           class="tab-link flex-fill{{ request()->routeIs('customer.kompensasi.*') ? ' active' : '' }}"
           aria-label="Kompensasi" @if(request()->routeIs('customer.kompensasi.*')) aria-current="page" @endif>
            <i class="bi bi-shield-exclamation" aria-hidden="true"></i>
            <span>Kompensasi</span>
        </a>
    </div>
</nav>

<script>
(function(){
    // Auto-hide top navbar on scroll > 60px (sama persis landing page)
    var nav = document.getElementById('customerNavbar');
    var ticking = false;
    function updateNav() {
        if (!nav) return;
        var st = window.pageYOffset || document.documentElement.scrollTop;
        if (st <= 60) {
            nav.style.transform = 'translateY(0)';
        } else {
            nav.style.transform = 'translateY(-100%)';
        }
        ticking = false;
    }
    document.addEventListener('DOMContentLoaded', updateNav);
    window.addEventListener('scroll', function() {
        if (!ticking) {
            window.requestAnimationFrame(updateNav);
            ticking = true;
        }
    }, { passive: true });

    // Auto-close profile dropdown when page scrolls
    // Bootstrap bundle loads AFTER this partial in some views, so resolve the
    // instance lazily at scroll time (scroll can only happen after full parse).
    var profileBtn = document.getElementById('profileDropdown');
    var profileDd = null;
    function getProfileDropdown() {
        if (!profileDd && profileBtn && window.bootstrap && window.bootstrap.Dropdown) {
            profileDd = window.bootstrap.Dropdown.getOrCreateInstance(profileBtn);
        }
        return profileDd;
    }
    window.addEventListener('scroll', function() {
        if (!profileBtn || profileBtn.getAttribute('aria-expanded') !== 'true') return;
        var dd = getProfileDropdown();
        if (dd) dd.hide();
    }, { passive: true });

    // Sync bottom tab active state
    var tabs = document.querySelectorAll('.customer-bottom-tabs [data-tab]');
    if(!tabs.length) return;
    function syncTabs(){
        var h = location.hash.replace('#','');
        tabs.forEach(function(a){
            var isActive = h === a.getAttribute('data-tab');
            a.classList.toggle('active', isActive);
            if(isActive) a.setAttribute('aria-current','page');
            else if(a.hasAttribute('data-tab')) a.removeAttribute('aria-current');
        });
        if(!h && location.pathname.includes('dashboard')){
            var first = document.querySelector('.customer-bottom-tabs [data-tab="mobil"]');
            if(first) { first.classList.add('active'); first.setAttribute('aria-current','page'); }
        }
    }
    window.addEventListener('hashchange', syncTabs);
    syncTabs();
})();
</script>