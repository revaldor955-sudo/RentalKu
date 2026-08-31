{{-- NAVBAR ADMIN --}}
{{-- Partial self-contained: memuat style navbar dan markup navbar. --}}
{{-- Bootstrap CSS/JS TIDAK dimuat di sini — setiap halaman memuatnya sendiri di <head>. --}}
{{-- Dipakai oleh SEMUA halaman admin via @include('layouts.partials.admin-navbar'). --}}

<style>
    .navbar {
        background: white;
        border-bottom: 1px solid #e9ecef;
    }

    .brand {
        font-size: 25px;
        font-weight: 800;
        color: #1f2937;
    }

    .brand span {
        color: #198754;
    }

    .user-box {
        background: #f5f8f6;
        border-radius: 50px;
        padding: 6px 12px 6px 7px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
    }

    .user-icon {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #198754;
        color: white;
        font-size: 16px;
    }
</style>

<nav class="navbar">
    <div class="container py-3">

        <div class="d-flex justify-content-between align-items-center w-100">

            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none brand">
                Rental<span>ku</span>.
            </a>

            <div class="d-flex gap-2 align-items-center">

                <a href="#" class="user-box d-none d-md-flex text-decoration-none text-dark"
                   data-bs-toggle="modal" data-bs-target="#profileModal">
                    <div class="user-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    <span>{{ Auth::user()?->name ?? 'Admin' }}</span>
                </a>

            </div>

        </div>

    </div>
</nav>

{{-- MODAL PROFIL (partial bersama admin/staff/customer) --}}
@include('layouts.partials.profile-modal')