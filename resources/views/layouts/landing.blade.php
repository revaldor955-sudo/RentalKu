<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Rentalku - Rental Mobil Terpercaya')</title>

    <meta name="description" content="Rentalku menyediakan layanan rental mobil mudah, aman dan terpercaya.">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Rentalku - Rental Mobil Terpercaya')">
    <meta property="og:description" content="Rentalku menyediakan layanan rental mobil mudah, aman dan terpercaya.">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2C666E;
            --primary-dark: #1F4F54;
            --dark: #111827;
            --muted: #6b7280;
            --light: #F0EDEE;
            --border: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            overflow-x: clip; /* margin negatif .row.g-5 melebihi padding .container */
        }

        body {
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
            color: var(--dark);
            background: #fff;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
        }

        a {
            text-decoration: none;
        }

        .navbar {
            background: rgba(255, 255, 255, .96);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(0, 0, 0, .05);
            padding: 16px 0;
        }

        .navbar-brand {
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
            font-size: 25px;
            font-weight: 800;
            color: var(--dark) !important;
        }

        .navbar-brand span {
            color: var(--primary);
        }

        .nav-link {
            color: #4b5563 !important;
            font-weight: 600;
            margin: 0 7px;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        .btn-rent {
            background: var(--primary);
            color: white;
            border-radius: 10px;
            padding: 11px 21px;
            font-weight: 700;
            border: none;
        }

        .btn-rent:hover {
            background: var(--primary-dark);
            color: white;
        }

        .hero {
            height: 550px;
            overflow: hidden;
            position: relative;
            border-radius: 0 0 40px 40px;
        }

        .hero .carousel,
        .hero .carousel-inner,
        .hero .carousel-item {
            height: 100%;
        }

        .hero-slide {
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .hero-slide::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(44, 102, 110, .88) 0%, rgba(17, 24, 39, .55) 100%);
        }

        .hero-content {
            color: white;
            text-align: center;
            width: 100%;
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, .15);
            border: 1px solid rgba(255, 255, 255, .25);
            padding: 8px 16px;
            border-radius: 50px;
            margin-bottom: 18px;
            font-size: 13px;
            backdrop-filter: blur(8px);
        }

        /* Loading Skeleton */
        .search-skeleton {
            opacity: 0.7;
        }
        .skeleton-card {
            background: #fff;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .skeleton-img {
            width: 100%;
            height: 180px;
            background: linear-gradient(90deg, #F0EDEE 25%, #E8F0F1 50%, #F0EDEE 75%);
            background-size: 400% 100%;
            border-radius: 8px;
            margin-bottom: 12px;
            animation: shimmer 1.5s infinite linear;
        }
        .skeleton-line {
            background: linear-gradient(90deg, #F0EDEE 25%, #E8F0F1 50%, #F0EDEE 75%);
            background-size: 400% 100%;
            height: 8px;
            border-radius: 4px;
            margin-bottom: 8px;
            animation: shimmer 1.5s infinite linear;
        }
        .skeleton-line-lg { width: 90%; }
        .skeleton-line-md { width: 70%; }
        .skeleton-line-sm { width: 50%; }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .hero h1 {
            font-size: clamp(32px, 5vw, 56px);
            font-weight: 700;
            margin-bottom: 14px;
        }

        .hero h1 span {
            color: #7FB7BC;
        }

        .hero p {
            font-size: 16px;
            opacity: .9;
            margin: 0 auto 26px;
            max-width: 560px;
        }

        .hero-buttons {
            justify-content: center;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-hero {
            padding: 14px 24px;
            border-radius: 11px;
            font-weight: 700;
        }

        .btn-hero-primary {
            background: var(--primary);
            color: white;
        }

        .btn-hero-primary:hover {
            background: var(--primary-dark);
            color: white;
        }

        .btn-hero-outline {
            color: white;
            border: 1px solid rgba(255, 255, 255, .35);
            background: rgba(255, 255, 255, .08);
        }

        .btn-hero-outline:hover {
            background: white;
            color: var(--dark);
        }

        .search-box {
            margin-top: -65px;
            position: relative;
            z-index: 10;
        }

        .search-card {
            background: white;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, .12);
        }

        .search-label {
            font-size: 13px;
            color: var(--muted);
            font-weight: 600;
            margin-bottom: 7px;
        }

        .search-input {
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px 14px;
        }

        .section {
            padding: 95px 0;
        }

        .section-light {
            background: var(--light);
        }

        .section-title {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: -.8px;
        }

        .section-subtitle {
            color: var(--muted);
            max-width: 600px;
            margin-top: 12px;
            line-height: 1.7;
        }

        .car-card {
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            background: white;
            transition: .3s ease;
            height: 100%;
        }

        .car-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .05);
        }

        .car-image {
            height: 220px;
            width: 100%;
            object-fit: contain;
            background: #f1f5f9;
        }

        .car-content {
            padding: 20px;
        }

        .car-title {
            font-size: 20px;
            font-weight: 800;
            margin: 5px 0 15px;
        }

        .car-info {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            color: var(--muted);
            font-size: 13px;
        }

        .car-info i {
            color: var(--primary);
        }

        .car-price {
            font-size: 21px;
            font-weight: 800;
            color: var(--dark);
        }

        .car-price small {
            color: var(--muted);
            font-size: 13px;
            font-weight: 500;
        }

        .brand-card {
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 22px;
            background: white;
            text-align: center;
            transition: .25s;
        }

        .brand-card:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .05);
        }

        .brand-logo {
            width: 55px;
            height: 55px;
            object-fit: contain;
            margin-bottom: 12px;
        }

        .feature-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 30px;
            height: 100%;
            transition: .3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #E8F0F1;
            color: var(--primary);
            border-radius: 14px;
            font-size: 25px;
            margin-bottom: 20px;
        }

        .feature-card h5 {
            font-weight: 800;
        }

        .feature-card p {
            color: var(--muted);
            line-height: 1.7;
            margin-top: 10px;
        }

        .steps {
            position: relative;
        }

        .step-number {
            width: 52px;
            height: 52px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .step-card h5 {
            font-weight: 800;
        }

        .step-card p {
            color: var(--muted);
            line-height: 1.7;
        }

        .promo {
            border-radius: 25px;
            overflow: hidden;
            position: relative;
            min-height: 330px;
            background: #111827;
        }

        .promo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            inset: 0;
            opacity: .45;
        }

        .promo-content {
            position: relative;
            z-index: 2;
            color: white;
            padding: 60px 60px 60px 96px;
            max-width: 700px;
        }

        /* Carousel kontrol */
        .hero .carousel-control-prev,
        .hero .carousel-control-next {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, .15);
            border-radius: 50%;
            backdrop-filter: blur(8px);
            top: 50%;
            transform: translateY(-50%);
            opacity: 1;
            z-index: 3;
            border: 1px solid rgba(255, 255, 255, .2);
        }

        .hero .carousel-control-prev {
            left: 20px;
        }

        .hero .carousel-control-next {
            right: 20px;
        }

        .hero .carousel-control-prev:hover,
        .hero .carousel-control-next:hover {
            background: rgba(255, 255, 255, .3);
        }

        .hero .carousel-control-prev-icon,
        .hero .carousel-control-next-icon {
            filter: invert(1);
            width: 20px;
            height: 20px;
        }

        /* Indikator */
        .hero .carousel-indicators {
            z-index: 3;
            margin-bottom: 26px;
        }

        .hero .carousel-indicators [data-bs-target] {
            width: 9px;
            height: 9px;
            border: none;
            border-radius: 50px;
            background: rgba(255, 255, 255, .45);
            opacity: 1;
            transition: width .25s ease-out, background-color .25s ease-out;
        }

        .hero .carousel-indicators .active {
            width: 28px;
            background: white;
        }

        .rating-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 25px;
            height: 100%;
        }

        .stars {
            color: #f59e0b;
            letter-spacing: 2px;
        }

        .rating-text {
            color: #4b5563;
            line-height: 1.8;
            margin: 15px 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            background: #e5e7eb;
        }

        .faq .accordion-item {
            border: 1px solid var(--border);
            border-radius: 12px !important;
            margin-bottom: 12px;
            overflow: hidden;
        }

        .faq .accordion-button {
            font-weight: 700;
            padding: 20px;
        }

        .faq .accordion-button:not(.collapsed) {
            color: var(--primary);
            background: #E8F0F1;
            box-shadow: none;
        }

        .cta {
            background: var(--primary);
            border-radius: 25px;
            padding: 65px;
            color: white;
        }

        .cta p {
            color: rgba(255, 255, 255, .8);
            max-width: 650px;
        }

        footer {
            background: #111827;
            color: white;
            padding: 40px 0 20px;
        }

        footer .brand {
            font-size: 25px;
            font-weight: 800;
        }

        footer .brand span {
            color: #7FB7BC;
        }

        footer p,
        footer a {
            color: #9ca3af;
        }

        footer a:hover {
            color: white;
        }

        .footer-title {
            font-weight: 700;
            margin-bottom: 18px;
        }

        @media(max-width: 768px) {

            .hero {
                height: 500px;
            }

            .hero h1 {
                font-size: 28px;
            }

            .hero p {
                font-size: 14px;
            }

            .hero .carousel-control-prev,
            .hero .carousel-control-next {
                display: none;
            }

            .search-box {
                margin-top: -30px;
            }

            .section {
                padding: 65px 0;
            }

            .section-title {
                font-size: 29px;
            }

            .promo-content,
            .cta {
                padding: 35px 25px 35px 64px;
            }

        }

        /* Override Bootstrap success (green) to teal */
        :root {
            --bs-success: #2C666E;
            --bs-success-rgb: 44, 102, 110;
        }
        /* Ghost button & Nav-link hover effects */
        .nav-btn-ghost {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            color: var(--dark) !important;
            background: transparent !important;
            border-radius: 10px !important;
            transition: all 0.2s ease !important;
            position: relative;
        }

        .nav-btn-ghost:hover,
        .nav-btn-ghost:focus {
            background: rgba(44, 102, 110, 0.1) !important;
            color: var(--primary) !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .nav-btn-ghost::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 2px;
            left: 50%;
            background-color: var(--primary);
            transition: width 0.2s ease, left 0.2s ease;
        }

        .nav-btn-ghost:hover::after,
        .nav-btn-ghost:focus::after {
            width: 60%;
            left: 20%;
        }

        .navbar-nav .nav-link {
            transition: color 0.2s ease, background 0.2s ease !important;
            position: relative;
            border-radius: 10px !important;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary) !important;
            background: rgba(44, 102, 110, 0.1) !important;
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

        .navbar-nav .nav-link:hover::after {
            width: 60%;
            left: 20%;
        }

    </style>

    @stack('styles')
</head>

<body>

    <div style="height: 76px;"></div>
    @include('layouts.partials.navbar')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('content')

    @include('layouts.partials.footer')

    <script>
        const navbar = document.getElementById('mainNavbar');
        let ticking = false;

        function updateNavbar() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            // Cuma muncul pas mentok atas (<= 60px), selain itu (scroll bawah/atas) tetep ilang
            if (scrollTop <= 60) {
                navbar.style.transform = 'translateY(0)';
            } else {
                navbar.style.transform = 'translateY(-100%)';
            }

            ticking = false;
        }

        document.addEventListener('DOMContentLoaded', updateNavbar);

        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(updateNavbar);
                ticking = true;
            }
        }, { passive: true });
    </script>

    @stack('scripts')

</body>

</html>
