{{-- shadcn/ui style: collapsible, accessible, keyboard navigable --}}
{{-- Usage: @include('layouts.partials.admin-sidebar') --}}

<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('css/action-hover.css') }}">
<style>
    .nav-badge { opacity: 1; } /* Specific admin override */
    .nav-link.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 24px;
        background: #198754;
        border-radius: 0 3px 3px 0;
    }
</style>

<div class="sidebar-layout" data-sidebar-layout>
    {{-- Sidebar dipakai halaman admin DAN halaman bersama adminstaff.
         Link Dashboard & Kelola Mobil mengikuti role agar staff tak 403. --}}
    @php
        $sidebarIsStaff = (auth()->user()->role->name ?? '') === 'Staff';
        $sidebarDashboardRoute = $sidebarIsStaff ? 'staff.dashboard' : 'admin.dashboard';
        $sidebarMobilRoute = $sidebarIsStaff ? 'staff.mobils.index' : 'mobils.index';
        $sidebarMobilPattern = $sidebarIsStaff ? 'staff.mobils*' : 'mobils*';
    @endphp
    <aside
        class="admin-sidebar"
        id="adminSidebar"
        role="navigation"
        aria-label="Navigasi utama"
        data-collapsed="false"
    >
        <header class="sidebar-header">
            <a href="{{ route($sidebarDashboardRoute) }}" class="sidebar-brand" aria-label="Dashboard RentalKu">
                <div class="brand-icon" aria-hidden="true">
                    <i class="bi bi-car-front-fill"></i>
                </div>
                <span class="brand-text">Rental<span>ku</span>.</span>
            </a>
            <button
                class="sidebar-toggle"
                id="sidebarToggle"
                aria-label="Collapse sidebar"
                aria-expanded="true"
                aria-controls="adminSidebar"
                type="button"
            >
                <i class="bi bi-chevron-left chevron" aria-hidden="true"></i>
            </button>
        </header>

        <nav class="sidebar-nav" aria-label="Menu admin">
            <div class="sidebar-section" data-section="core">
                <div class="section-label" data-section-label="core">Utama</div>
                <ul class="nav-list" role="list">
                    <li class="nav-item">
                        <a href="{{ route($sidebarDashboardRoute) }}"
                           class="nav-link {{ request()->routeIs('admin.dashboard', 'staff.dashboard') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('admin.dashboard', 'staff.dashboard') ? 'page' : 'false' }}">
                            <i class="bi bi-speedometer2 nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-section" data-section="master">
                <div class="section-label" data-section-label="master">Master Data</div>
                <ul class="nav-list" role="list">
                    <li class="nav-item">
                        <a href="{{ route($sidebarMobilRoute) }}"
                           class="nav-link {{ request()->routeIs($sidebarMobilPattern) ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs($sidebarMobilPattern) ? 'page' : 'false' }}">
                            <i class="bi bi-car-front-fill nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Kelola Mobil</span>
                            @if(($totalMobils ?? 0) > 0)<span class="nav-badge">{{ $totalMobils }}</span>@endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('brands.index') }}"
                           class="nav-link {{ request()->routeIs('brands*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('brands*') ? 'page' : 'false' }}">
                            <i class="bi bi-tags nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Merek</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tipe_mobils.index') }}"
                           class="nav-link {{ request()->routeIs('tipe_mobils*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('tipe_mobils*') ? 'page' : 'false' }}">
                            <i class="bi bi-list-check nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Tipe Mobil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('cabangs.index') }}"
                           class="nav-link {{ request()->routeIs('cabangs*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('cabangs*') ? 'page' : 'false' }}">
                            <i class="bi bi-building nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Cabang</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('fasilitas.index') }}"
                           class="nav-link {{ request()->routeIs('fasilitas*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('fasilitas*') ? 'page' : 'false' }}">
                            <i class="bi bi-stars nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Fasilitas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('supirs.index') }}"
                           class="nav-link {{ request()->routeIs('supirs*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('supirs*') ? 'page' : 'false' }}">
                            <i class="bi bi-person-vcard nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Supir</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-section" data-section="operational">
                <div class="section-label" data-section-label="operational">Operasional</div>
                <ul class="nav-list" role="list">
                    <li class="nav-item">
                        <a href="{{ route('rentals.index') }}"
                           class="nav-link {{ request()->routeIs('rentals*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('rentals*') ? 'page' : 'false' }}">
                            <i class="bi bi-car-front nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Rental</span>
                            @if(($pendingRentalsCount ?? 0) > 0)<span class="nav-badge">{{ $pendingRentalsCount }}</span>@endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pembayarans.index') }}"
                           class="nav-link {{ request()->routeIs('pembayarans*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('pembayarans*') ? 'page' : 'false' }}">
                            <i class="bi bi-credit-card nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Pembayaran</span>
                            @if(($pendingPaymentsCount ?? 0) > 0)<span class="nav-badge">{{ $pendingPaymentsCount }}</span>@endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pengembalian.index') }}"
                           class="nav-link {{ request()->routeIs('pengembalian*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('pengembalian*') ? 'page' : 'false' }}">
                            <i class="bi bi-arrow-return-left nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Pengembalian</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pemeriksaan-kendaraan.index') }}"
                           class="nav-link {{ request()->routeIs('pemeriksaan*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('pemeriksaan*') ? 'page' : 'false' }}">
                            <i class="bi bi-clipboard-check nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Pemeriksaan</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-section" data-section="users">
                <div class="section-label" data-section-label="users">Pengguna & Akses</div>
                <ul class="nav-list" role="list">
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}"
                           class="nav-link {{ request()->routeIs('users*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('users*') ? 'page' : 'false' }}">
                            <i class="bi bi-people nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Pengguna</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('roles.index') }}"
                           class="nav-link {{ request()->routeIs('roles*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('roles*') ? 'page' : 'false' }}">
                            <i class="bi bi-shield-lock nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Role</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-section" data-section="content">
                <div class="section-label" data-section-label="content">Promo & Konten</div>
                <ul class="nav-list" role="list">
                    <li class="nav-item">
                        <a href="{{ route('kupons.index') }}"
                           class="nav-link {{ request()->routeIs('kupons*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('kupons*') ? 'page' : 'false' }}">
                            <i class="bi bi-ticket-perforated nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Promo & Kupon</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('banners.index') }}"
                           class="nav-link {{ request()->routeIs('banners*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('banners*') ? 'page' : 'false' }}">
                            <i class="bi bi-images nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Banner</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('faqs.index') }}"
                           class="nav-link {{ request()->routeIs('faqs*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('faqs*') ? 'page' : 'false' }}">
                            <i class="bi bi-question-circle nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">FAQ</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-section" data-section="reports">
                <div class="section-label" data-section-label="reports">Laporan & Lainnya</div>
                <ul class="nav-list" role="list">
                    <li class="nav-item">
                        <a href="{{ route('laporan.index') }}"
                           class="nav-link {{ request()->routeIs('laporan*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('laporan*') ? 'page' : 'false' }}">
                            <i class="bi bi-file-earmark-bar-graph nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Laporan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('contacts.index') }}"
                           class="nav-link {{ request()->routeIs('contacts*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('contacts*') ? 'page' : 'false' }}">
                            <i class="bi bi-envelope nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Hubungi Kami</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dendas.index') }}"
                           class="nav-link {{ request()->routeIs('dendas*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('dendas*') ? 'page' : 'false' }}">
                            <i class="bi bi-exclamation-triangle nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Denda</span>
                            @if(($pendingDendasCount ?? 0) > 0)<span class="nav-badge">{{ $pendingDendasCount }}</span>@endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kompensasis.index') }}"
                           class="nav-link {{ request()->routeIs('kompensasis*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('kompensasis*') ? 'page' : 'false' }}">
                            <i class="bi bi-cash-stack nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Kompensasi</span>
                            @if(($pendingKompensasisCount ?? 0) > 0)<span class="nav-badge">{{ $pendingKompensasisCount }}</span>@endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('servis_mobils.index') }}"
                           class="nav-link {{ request()->routeIs('servis_mobils*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('servis_mobils*') ? 'page' : 'false' }}">
                            <i class="bi bi-tools nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Servis Mobil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kerusakan_mobils.index') }}"
                           class="nav-link {{ request()->routeIs('kerusakan_mobils*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('kerusakan_mobils*') ? 'page' : 'false' }}">
                            <i class="bi bi-wrench nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Jenis Kerusakan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dokumen_mobils.index') }}"
                           class="nav-link {{ request()->routeIs('dokumen_mobils*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('dokumen_mobils*') ? 'page' : 'false' }}">
                            <i class="bi bi-file-earmark-text nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Dokumen Mobil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('foto_mobils.index') }}"
                           class="nav-link {{ request()->routeIs('foto_mobils*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('foto_mobils*') ? 'page' : 'false' }}">
                            <i class="bi bi-camera nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Foto Mobil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('metode_pembayarans.index') }}"
                           class="nav-link {{ request()->routeIs('metode_pembayarans*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('metode_pembayarans*') ? 'page' : 'false' }}">
                            <i class="bi bi-bank nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Metode Pembayaran</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.ratings.index') }}"
                           class="nav-link {{ request()->routeIs('admin.ratings*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('admin.ratings*') ? 'page' : 'false' }}">
                            <i class="bi bi-star-fill nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Ulasan Pelanggan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.landing-settings.index') }}"
                           class="nav-link {{ request()->routeIs('admin.landing-settings*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('admin.landing-settings*') ? 'page' : 'false' }}">
                            <i class="bi bi-sliders nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Landing Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <footer class="sidebar-footer">
            <div class="dropdown w-100">
                <button
                   type="button"
                   class="user-menu w-100 text-start dropdown-toggle bg-transparent border-0 d-flex align-items-center"
                   data-bs-toggle="dropdown"
                   aria-expanded="false"
                   aria-label="Menu pengguna"
                >
                    <div class="user-avatar" aria-hidden="true">
                        @if(Auth::user()->photo)
                            <img src="{{ asset(Auth::user()->photo) }}" alt="Avatar" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                        @else
                            <i class="bi bi-person-fill"></i>
                        @endif
                    </div>
                    <div class="user-info flex-grow-1">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-role">{{ Auth::user()->role->name ?? 'Admin' }}</span>
                    </div>
                    <i class="bi bi-chevron-up chevron ms-auto" aria-hidden="true" style="font-size: 12px; color: #64748b;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-start shadow border-0 mb-2 p-2 w-100" style="border-radius: 12px; bottom: 100%; top: auto;">
                    <li>
                        <button class="dropdown-item rounded-2 py-2 d-flex align-items-center" type="button" data-bs-toggle="modal" data-bs-target="#profileModal" data-mode="edit">
                            <i class="bi bi-person-badge me-3 text-secondary"></i>
                            Edit Profile
                        </button>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger rounded-2 py-2 d-flex align-items-center">
                                <i class="bi bi-box-arrow-right me-3"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </footer>
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true" tabindex="-1"></div>

    <div class="main-content" id="mainContent">
        {{-- Topbar: satu-satunya sumber header.topbar + profileModal di halaman admin --}}
        @include('layouts.partials.admin-navbar')

        <main class="page-content" role="main">
        </main>
    </div>
</div>

<script src="{{ asset('js/sidebar.js') }}" defer></script>
</div>