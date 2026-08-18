<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Rentalku - Rental Mobil Terpercaya')</title>

    <meta
        name="description"
        content="Rentalku menyediakan layanan rental mobil mudah, aman dan terpercaya."
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>

        :root {
            --primary: #16a34a;
            --primary-dark: #15803d;
            --dark: #111827;
            --muted: #6b7280;
            --light: #f6f8f7;
            --border: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--dark);
            background: #fff;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        a {
            text-decoration: none;
        }

        .navbar {
            background: rgba(255,255,255,.96);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(0,0,0,.05);
            padding: 16px 0;
        }

        .navbar-brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
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
            min-height: 680px;
            background:
                linear-gradient(
                    90deg,
                    rgba(10,20,15,.92) 0%,
                    rgba(10,20,15,.75) 42%,
                    rgba(10,20,15,.15) 100%
                ),
                url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=2000&q=85')
                center/cover;
            display: flex;
            align-items: center;
            position: relative;
        }

        .hero-content {
            color: white;
            max-width: 700px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.2);
            padding: 8px 14px;
            border-radius: 50px;
            margin-bottom: 25px;
            font-size: 14px;
            backdrop-filter: blur(10px);
        }

        .hero h1 {
            font-size: clamp(42px, 6vw, 72px);
            font-weight: 800;
            line-height: 1.08;
            letter-spacing: -2px;
        }

        .hero h1 span {
            color: #4ade80;
        }

        .hero p {
            font-size: 18px;
            color: rgba(255,255,255,.78);
            max-width: 590px;
            margin-top: 20px;
            line-height: 1.7;
        }

        .hero-buttons {
            margin-top: 30px;
            display: flex;
            gap: 13px;
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
            border: 1px solid rgba(255,255,255,.35);
            background: rgba(255,255,255,.08);
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
            box-shadow: 0 15px 50px rgba(0,0,0,.12);
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
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(0,0,0,.09);
        }

        .car-image {
            height: 220px;
            width: 100%;
            object-fit: cover;
            background: #f1f5f9;
        }

        .car-content {
            padding: 20px;
        }

        .car-brand {
            color: var(--primary);
            font-size: 13px;
            font-weight: 700;
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
            transform: translateY(-4px);
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
            background: #dcfce7;
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
            padding: 60px;
            max-width: 700px;
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
            background: #f0fdf4;
            box-shadow: none;
        }

        .cta {
            background: var(--primary);
            border-radius: 25px;
            padding: 65px;
            color: white;
        }

        .cta p {
            color: rgba(255,255,255,.8);
            max-width: 650px;
        }

        footer {
            background: #111827;
            color: white;
            padding: 65px 0 25px;
        }

        footer .brand {
            font-size: 25px;
            font-weight: 800;
        }

        footer .brand span {
            color: #4ade80;
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
                min-height: 600px;
            }

            .hero h1 {
                letter-spacing: -1px;
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
                padding: 35px 25px;
            }

        }

    </style>

    @stack('styles')
</head>

<body>

    @include('layouts.partials.navbar')

    @yield('content')

    @include('layouts.partials.footer')

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    @stack('scripts')

</body>

</html>