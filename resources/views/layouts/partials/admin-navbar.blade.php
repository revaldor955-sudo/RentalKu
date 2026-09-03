{{-- NAVBAR ADMIN (for sidebar layout) --}}
{{-- Top bar that sits above main content, next to sidebar --}}
{{-- Bootstrap CSS/JS TIDAK dimuat di sini — setiap halaman memuatnya sendiri di <head>. --}}
{{-- Dipakai oleh SEMUA halaman admin via @include('layouts.partials.admin-navbar'). --}}

<style>
    .topbar {
        background: #fff;
        border-bottom: 1px solid #edf0ee;
        height: 64px;
        position: sticky;
        top: 0;
        z-index: 1020;
    }

    .topbar-brand {
        font-size: 20px;
        font-weight: 800;
        color: #1f2937;
        text-decoration: none;
    }

    .topbar-brand span {
        color: #198754;
    }

    /* Profil hanya di sidebar */

    /* Toggle drawer + brand hanya di bawah breakpoint sidebar (1024px) */
    #mobileSidebarToggle {
        display: none;
    }

    .topbar-brand {
        display: none;
    }

    @media (max-width: 1023.98px) {
        #mobileSidebarToggle {
            display: inline-block;
        }

        .topbar-brand {
            display: block;
        }
    }
</style>

<header class="topbar" role="banner">
    <div class="container-fluid px-4 h-100">
        <div class="d-flex align-items-center gap-3 h-100">
            {{-- Sidebar toggle for mobile --}}
            <button
                class="btn btn-sm btn-outline-secondary me-3"
                type="button"
                id="mobileSidebarToggle"
                aria-label="Buka menu navigasi"
                aria-expanded="false"
                aria-controls="adminSidebar"
            >
                <i class="bi bi-list" aria-hidden="true"></i>
            </button>

            {{-- Page title / Brand (shown on mobile) --}}
            <a href="{{ route('admin.dashboard') }}" class="topbar-brand">
                Rental<span>ku</span>.
            </a>

            <div class="d-flex align-items-center gap-3 flex-grow-1">
                {{-- Breadcrumb / Page title area --}}
                <div class="d-none d-md-block flex-grow-1">
                    @if(isset($pageTitle))
                        <h1 class="h5 mb-0 fw-bold text-dark">{{ $pageTitle }}</h1>
                    @else
                        <h1 class="h5 mb-0 fw-bold text-dark">Dashboard</h1>
                    @endif
                </div>
            </div>

        </div>
    </div>
</header>

{{-- MODAL PROFIL (partial bersama admin/staff/customer) --}}
@include('layouts.partials.profile-modal')