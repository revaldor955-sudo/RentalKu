
{{-- NAVBAR ADMIN RENTALKU --}}

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

    .nav-link-custom {
        color: #526158;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        padding: 10px 14px;
        border-radius: 10px;
        transition: .2s;
    }

    .nav-link-custom:hover,
    .nav-link-custom.active {
        background: #e8f8ef;
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

            <a href="{{ route('admin.dashboard') }}"
                class="text-decoration-none brand">

                Rental<span>ku</span>.

            </a>


            <div class="d-flex gap-2 align-items-center">

                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link-custom d-none d-md-block">

                    <i class="bi bi-grid me-1"></i>

                    Dashboard

                </a>


                <a href="{{ route('faqs.index') }}"
                    class="nav-link-custom">

                    <i class="bi bi-question-circle me-1"></i>

                    FAQ

                </a>


                <a href="#"
                    class="user-box d-none d-md-flex text-decoration-none text-dark"
                    data-bs-toggle="modal"
                    data-bs-target="#profileModal">

                    <div class="user-icon">

                        <i class="bi bi-person"></i>

                    </div>

                    <span>
                        {{ Auth::user()?->name ?? 'Admin' }}
                    </span>

                </a>

            </div>

        </div>

    </div>
</nav>


@include('layouts.partials.profile-modal')