{{-- NAVBAR ADMIN --}}
{{-- Partial self-contained: memuat CSS Bootstrap, style navbar, dan markup navbar. --}}
{{-- Dipakai oleh SEMUA halaman admin via @include('layouts.partials.admin-navbar'). --}}

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
</style>

<nav class="navbar">
    <div class="container py-3">

        <div class="d-flex justify-content-between align-items-center w-100">

            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none brand">
                Rental<span>ku</span>.
            </a>

            <div class="d-flex gap-2">

                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-speedometer2 me-1"></i>
                    Dashboard
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Keluar
                    </button>
                </form>

            </div>

        </div>

    </div>
</nav>