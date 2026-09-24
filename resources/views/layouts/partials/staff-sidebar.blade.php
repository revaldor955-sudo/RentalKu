{{-- shadcn/ui style: collapsible, accessible, keyboard navigable --}}
{{-- Usage: @include('layouts.partials.staff-sidebar') --}}

<style>
    :root {
        --sidebar-width: 260px;
        --sidebar-collapsed-width: 72px;
        --sidebar-transition: 200ms ease;
        --header-height: 64px;
    }

    .sidebar-layout {
        display: flex;
        min-height: 100vh;
    }

    .admin-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1030;
        width: var(--sidebar-width);
        height: 100vh;
        background: #fff;
        border-right: 1px solid #edf0ee;
        display: flex;
        flex-direction: column;
        transition: width var(--sidebar-transition), transform var(--sidebar-transition);
        overflow: hidden;
    }

    .admin-sidebar.collapsed {
        width: var(--sidebar-collapsed-width);
    }

    .admin-sidebar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, #fafbfa 0%, #fff 100%);
        z-index: -1;
    }

    .sidebar-header {
        height: var(--header-height);
        padding: 0 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #edf0ee;
        flex-shrink: 0;
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: #1f2937;
        white-space: nowrap;
        overflow: hidden;
        transition: opacity var(--sidebar-transition);
    }

    .admin-sidebar.collapsed .sidebar-brand .brand-text {
        opacity: 0;
        width: 0;
    }

    .brand-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, #198754, #146c43);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 20px;
        flex-shrink: 0;
    }

    .brand-text {
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.5px;
        transition: opacity var(--sidebar-transition), width var(--sidebar-transition);
    }

    .brand-text span {
        color: #198754;
    }

    .sidebar-toggle {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: 1px solid #edf0ee;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        cursor: pointer;
        transition: all 150ms ease;
        flex-shrink: 0;
    }

    .sidebar-toggle:hover {
        background: #f5f7f6;
        border-color: #198754;
        color: #198754;
    }

    .sidebar-toggle:focus-visible {
        outline: 2px solid #198754;
        outline-offset: 2px;
    }

    .admin-sidebar.collapsed .sidebar-toggle {
        margin-left: auto;
    }

    .sidebar-toggle .chevron {
        transition: transform var(--sidebar-transition);
    }

    .admin-sidebar.collapsed .sidebar-toggle .chevron {
        transform: rotate(180deg);
    }

    .sidebar-nav {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        overscroll-behavior: contain;
        padding: 12px 8px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .sidebar-section {
        flex: 1 0 auto;
        display: flex;
        flex-direction: column;
        margin-bottom: 8px;
    }

    .section-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #9ca3af;
        padding: 0 12px;
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        transition: opacity var(--sidebar-transition);
    }

    .admin-sidebar.collapsed .section-label {
        opacity: 0;
        height: 0;
        margin: 0;
        padding: 0;
    }

    .nav-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .nav-item {
        position: relative;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 10px;
        color: #4b5563;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        white-space: nowrap;
        transition: all 150ms ease;
        overflow: hidden;
    }

    .nav-link:hover {
        background: #f5f7f6;
        color: #198754;
    }

    .nav-link:focus-visible {
        outline: 2px solid #198754;
        outline-offset: 2px;
    }

    .nav-link.active {
        background: #e9f7ef;
        color: #198754;
    }

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

    .nav-icon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        color: inherit;
        transition: color 150ms ease;
    }

    .nav-text {
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: opacity var(--sidebar-transition), width var(--sidebar-transition);
    }

    .admin-sidebar.collapsed .nav-text {
        opacity: 0;
        width: 0;
    }

    .nav-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 2px 6px;
        border-radius: 9999px;
        background: #fef3c7;
        color: #92400e;
        flex-shrink: 0;
        transition: opacity var(--sidebar-transition);
    }

    .admin-sidebar.collapsed .nav-badge {
        opacity: 0;
    }

    .sidebar-footer {
        padding: 12px;
        border-top: 1px solid #edf0ee;
        flex-shrink: 0;
    }

    .user-menu {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 8px 12px;
        border: none;
        border-radius: 10px;
        background: #f5f8f6;
        color: #1f2937;
        font: inherit;
        text-align: left;
        cursor: pointer;
        transition: all 150ms ease;
        white-space: nowrap;
        overflow: hidden;
    }

    .user-menu:hover {
        background: #e9f7ef;
        color: #198754;
    }

    .user-menu:focus-visible {
        outline: 2px solid #198754;
        outline-offset: 2px;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #198754;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .user-info {
        flex: 1;
        overflow: hidden;
    }

    .user-name {
        font-size: 14px;
        font-weight: 600;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: opacity var(--sidebar-transition);
    }

    .user-role {
        font-size: 12px;
        color: #9ca3af;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: opacity var(--sidebar-transition);
    }

    .admin-sidebar.collapsed .user-name,
    .admin-sidebar.collapsed .user-role {
        opacity: 0;
        width: 0;
    }

    .user-menu .chevron {
        color: #9ca3af;
        flex-shrink: 0;
        transition: transform var(--sidebar-transition);
    }

    .admin-sidebar.collapsed .user-menu .chevron {
        display: none;
    }

    /* Main content offset */
    .main-content {
        flex: 1;
        margin-left: var(--sidebar-width);
        transition: margin-left var(--sidebar-transition);
        min-height: 100vh;
    }

    .admin-sidebar.collapsed + .main-content {
        margin-left: var(--sidebar-collapsed-width);
    }

    /* Mobile drawer */
    @media (max-width: 1024px) {
        .admin-sidebar {
            transform: translateX(-100%);
        }

        .admin-sidebar.mobile-open {
            transform: translateX(0);
        }

        .admin-sidebar.collapsed {
            width: var(--sidebar-width);
        }

        .admin-sidebar.collapsed + .main-content {
            margin-left: 0;
        }

        .main-content {
            margin-left: 0;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.3);
            z-index: 1020;
        }

        .sidebar-overlay.visible {
            display: block;
        }
    }

    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {
        .admin-sidebar,
        .main-content,
        .nav-link,
        .sidebar-toggle .chevron,
        .brand-text,
        .nav-text,
        .nav-badge,
        .user-name,
        .user-role,
        .section-label {
            transition: none !important;
        }
    }

    /* Print */
    @media print {
        .admin-sidebar,
        .sidebar-toggle,
        .sidebar-overlay {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
        }
    }
</style>

<div class="sidebar-layout" data-sidebar-layout>
    {{-- Sidebar --}}
    <aside
        class="admin-sidebar"
        id="adminSidebar"
        role="navigation"
        aria-label="Navigasi utama"
        data-collapsed="false"
    >
        {{-- Header --}}
        <header class="sidebar-header">
            <a href="{{ route('staff.dashboard') }}" class="sidebar-brand" aria-label="Dashboard RentalKu">
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

        {{-- Navigation --}}
        <nav class="sidebar-nav" aria-label="Menu staff">
            {{-- Core --}}
            <div class="sidebar-section" data-section="core">
                <div class="section-label" data-section-label="core">Utama</div>
                <ul class="nav-list" role="list">
                    <li class="nav-item">
                        <a href="{{ route('staff.dashboard') }}"
                           class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('staff.dashboard') ? 'page' : 'false' }}">
                            <i class="bi bi-speedometer2 nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Master Data --}}
            <div class="sidebar-section" data-section="master">
                <div class="section-label" data-section-label="master">Kendaraan</div>
                <ul class="nav-list" role="list">
                    <li class="nav-item">
                        <a href="{{ route('staff.mobils.index') }}"
                           class="nav-link {{ request()->routeIs('staff.mobils*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('staff.mobils*') ? 'page' : 'false' }}">
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
                        <a href="{{ route('fasilitas.index') }}"
                           class="nav-link {{ request()->routeIs('fasilitas*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('fasilitas*') ? 'page' : 'false' }}">
                            <i class="bi bi-stars nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Fasilitas</span>
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
                </ul>
            </div>

            {{-- Operasional --}}
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
                        <a href="{{ route('pemeriksaan-kendaraan.index') }}"
                           class="nav-link {{ request()->routeIs('pemeriksaan*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('pemeriksaan*') ? 'page' : 'false' }}">
                            <i class="bi bi-clipboard-check nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Pemeriksaan</span>
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
                        <a href="{{ route('dendas.index') }}"
                           class="nav-link {{ request()->routeIs('dendas*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('dendas*') ? 'page' : 'false' }}">
                            <i class="bi bi-exclamation-triangle nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Denda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kompensasis.index') }}"
                           class="nav-link {{ request()->routeIs('kompensasis*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('kompensasis*') ? 'page' : 'false' }}">
                            <i class="bi bi-cash-coin nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Kompensasi</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Pengguna & Akses --}}
            <div class="sidebar-section" data-section="users">
                <div class="section-label" data-section-label="users">Pengguna</div>
                <ul class="nav-list" role="list">
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}"
                           class="nav-link {{ request()->routeIs('users*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('users*') ? 'page' : 'false' }}">
                            <i class="bi bi-people nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Pengguna</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Promo & Konten --}}
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
                </ul>
            </div>

            {{-- Laporan & Lainnya --}}
            <div class="sidebar-section" data-section="reports">
                <div class="section-label" data-section-label="reports">Laporan</div>
                <ul class="nav-list" role="list">
                    <li class="nav-item">
                        <a href="{{ route('laporan.index') }}"
                           class="nav-link {{ request()->routeIs('laporan*') ? 'active' : '' }}"
                           aria-current="{{ request()->routeIs('laporan*') ? 'page' : 'false' }}">
                            <i class="bi bi-file-earmark-bar-graph nav-icon" aria-hidden="true"></i>
                            <span class="nav-text">Laporan</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        {{-- Footer / User Menu --}}
        <footer class="sidebar-footer">
            <button
               type="button"
               class="user-menu"
               data-bs-toggle="modal"
               data-bs-target="#profileModal"
               aria-label="Profil pengguna"
            >
                <div class="user-avatar" aria-hidden="true">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">{{ Auth::user()->role->name ?? 'Staff' }}</span>
                </div>
                <i class="bi bi-chevron-right chevron" aria-hidden="true"></i>
            </button>
        </footer>
    </aside>

    {{-- Mobile Overlay --}}
    <div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true" tabindex="-1"></div>

    {{-- Main Content Wrapper --}}
    <div class="main-content" id="mainContent">
        {{-- Topbar: satu-satunya sumber header.topbar di halaman staff --}}
        @include('layouts.partials.staff-navbar')

        {{-- Page Content --}}
        <main class="page-content" role="main">
            {{-- Content injected by page --}}
        </main>
    </div>
</div>

<script>
(function() {
    'use strict';

    const STORAGE_KEY = 'rentalku_sidebar_collapsed';
    const MOBILE_BREAKPOINT = 1024;

    const sidebar = document.getElementById('adminSidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');

    if (!sidebar || !toggleBtn) return;

    let isCollapsed = false;
    let isMobile = window.innerWidth < MOBILE_BREAKPOINT;

    function init() {
        if (!isMobile) {
            const saved = localStorage.getItem(STORAGE_KEY);
            if (saved !== null) {
                isCollapsed = saved === 'true';
                applyCollapsedState();
            }
        }
        updateAria();
    }

    function applyCollapsedState() {
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            sidebar.setAttribute('data-collapsed', 'true');
        } else {
            sidebar.classList.remove('collapsed');
            sidebar.setAttribute('data-collapsed', 'false');
        }
    }

    function updateAria() {
        toggleBtn.setAttribute('aria-expanded', !isCollapsed);
        toggleBtn.setAttribute('aria-label', isCollapsed ? 'Expand sidebar' : 'Collapse sidebar');
    }

    function toggleSidebar() {
        if (isMobile) {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('visible');
            document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
        } else {
            isCollapsed = !isCollapsed;
            localStorage.setItem(STORAGE_KEY, isCollapsed);
            applyCollapsedState();
        }
        updateAria();
    }

    function closeMobileSidebar() {
        if (isMobile) {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('visible');
            document.body.style.overflow = '';
        }
    }

    toggleBtn.addEventListener('click', toggleSidebar);

    // Mobile toggle (lives in staff-navbar, may parse after this script)
    function bindMobileToggle() {
        const btn = document.getElementById('mobileSidebarToggle');
        if (btn && !btn.dataset.sidebarBound) {
            btn.dataset.sidebarBound = 'true';
            btn.addEventListener('click', function() {
                isMobile = window.innerWidth < MOBILE_BREAKPOINT;
                toggleSidebar();
                btn.setAttribute('aria-expanded', sidebar.classList.contains('mobile-open'));
            });
        }
    }
    bindMobileToggle();
    document.addEventListener('DOMContentLoaded', bindMobileToggle);

    // Pages render .page-content as a body sibling AFTER .sidebar-layout,
    // so it misses the #mainContent sidebar offset. Move it inside once DOM is ready.
    // Single fix here covers all admin pages using this partial.
    function relocatePageContent() {
        const mc = document.getElementById('mainContent');
        if (!mc) return;
        const placeholder = mc.querySelector('main.page-content');
        if (placeholder && placeholder.children.length === 0) placeholder.style.display = 'none';
        document.querySelectorAll('body > .page-content').forEach(function(el) {
            mc.appendChild(el);
        });
    }
    document.addEventListener('DOMContentLoaded', relocatePageContent);

    if (overlay) overlay.addEventListener('click', closeMobileSidebar);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isMobile && sidebar.classList.contains('mobile-open')) {
            closeMobileSidebar();
        }
    });

    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            const wasMobile = isMobile;
            isMobile = window.innerWidth < MOBILE_BREAKPOINT;

            if (wasMobile && !isMobile) {
                // Mobile -> Desktop
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('visible');
                document.body.style.overflow = '';
                applyCollapsedState();
            } else if (!wasMobile && isMobile) {
                // Desktop -> Mobile
                sidebar.classList.remove('collapsed');
                sidebar.setAttribute('data-collapsed', 'false');
                isCollapsed = false;
                localStorage.removeItem(STORAGE_KEY);
            }
            updateAria();
        }, 100);
    });

    document.querySelectorAll('.nav-link').forEach(function(link) {
        link.addEventListener('click', function() {
            if (isMobile) {
                closeMobileSidebar();
            }
        });
    });

    // Ingat posisi scroll nav per sesi supaya tidak balik ke atas tiap pindah halaman
    function restoreNavScroll() {
        const nav = sidebar.querySelector('.sidebar-nav');
        if (!nav) return;
        try {
            const saved = sessionStorage.getItem('rentalku_sidebar_nav_scroll');
            if (saved !== null) nav.scrollTop = parseInt(saved, 10) || 0;
        } catch (e) {}
        let scrollTimer;
        nav.addEventListener('scroll', function() {
            clearTimeout(scrollTimer);
            scrollTimer = setTimeout(function() {
                try {
                    sessionStorage.setItem('rentalku_sidebar_nav_scroll', nav.scrollTop);
                } catch (e) {}
            }, 100);
        }, { passive: true });
    }

    init();
    restoreNavScroll();
})();
</script>

{{-- Profil modal: satu-satunya sumber di halaman staff --}}
@include('layouts.partials.profile-modal')