<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Rental - RentalKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --primary: #198754;
            --primary-dark: #146c43;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f8faf9;
            color: #1f2937;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
        }

        .navbar {
            background: rgba(255,255,255,.95);
            border-bottom: 1px solid #e9ecef;
        }

        .brand {
            font-size: 27px;
            font-weight: 800;
            letter-spacing: -1px;
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

        .user-box.dropdown-toggle {
            transition: none;
        }

        .user-box.dropdown-toggle:hover {
            transform: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        .dropdown-menu {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.2s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            font-size: 14px;
            padding: 10px 16px;
            color: #1f2937;
            transition: all 0.15s ease;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background: #f5f7f6;
            color: #198754;
        }

        .dropdown-item.text-danger:hover,
        .dropdown-item.text-danger:focus {
            background: #fee;
            color: #dc3545;
        }

        .page-header {
            padding: 20px 0 16px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 14px;
        }

        .back-link {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            color: #374151 !important;
            background: transparent !important;
            border-radius: 999px !important;
            transition: all 0.2s ease !important;
            position: relative;
            display: inline-flex !important;
            align-items: center;
            gap: 8px;
            padding: 8px 0 !important;
            text-decoration: none !important;
            font-weight: 600;
            font-size: 14px;
        }

        .back-link:hover,
        .back-link:focus {
            color: #2c666e !important;
            background: transparent !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            text-decoration: none !important;
        }

        .back-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #2c666e;
            transition: width 0.2s ease, left 0.2s ease;
            border-radius: 1px;
        }

        .back-link:hover::after,
        .back-link:focus::after {
            width: 100%;
            left: 0;
        }

        .page-title {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin: 0;
            color: #1f2937;
        }

        .rental-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 24px;
            margin-top: 16px;
        }

        .rental-card {
            background: #ffffff;
            border: 1px solid #eef1f0;
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .rental-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            border-color: #d8dedb;
        }

        .rental-card-img {
            width: 100%;
            height: 180px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: #ccc;
            overflow: hidden;
        }

        .rental-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .rental-card-body {
            padding: 18px;
        }

        /* Rental Card Layout */
        .rental-image-thumb {
            width: 90px;
            height: 90px;
            flex-shrink: 0;
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .rental-image-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .placeholder-image {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #e9ecef, #f1f3f5);
            font-size: 32px;
            color: #6c757d;
            border-radius: 10px;
        }

        /* Data Section */
        .rental-data {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .rental-data-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .rental-data-item i {
            color: #4FD366;
            width: 20px;
            text-align: center;
        }

        .rental-status {
            display: inline-block;
            background: #e9f7ef;
            color: #198754;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .rental-title {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 6px 0;
        }

        .rental-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 12px;
        }

        .rental-price {
            font-size: 18px;
            font-weight: 800;
            color: #198754;
            margin-bottom: 14px;
        }

        .rental-actions {
            display: flex;
            gap: 8px;
        }

        .rental-action-btn {
            flex: 1;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            border: 1px solid transparent;
        }
        .btn-rating {
            background-color: #fff3cd;
            color: #856404;
            border-color: #ffeeba;
        }
        .btn-rating:hover {
            background-color: #ffe082;
            color: #533f03;
        }
        .btn-kompensasi {
            background-color: transparent;
            color: #6c757d;
            border-color: #e9ecef;
        }
        .btn-kompensasi:hover {
            background-color: #f8f9fa;
            color: #495057;
            border-color: #dee2e6;
        }

        .btn-rate {
            background: #f0f8f4;
            color: #198754;
            border: 1px solid #e9f7ef;
        }

        .btn-rate:hover {
            background: #e9f7ef;
            border-color: #198754;
        }

        .btn-claim {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .btn-claim:hover {
            background: #fde68a;
            border-color: #f59e0b;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 48px;
            color: #d1d5db;
            margin-bottom: 12px;
        }

        .empty-text {
            color: #9ca3af;
            font-size: 14px;
        }

        footer {
            background: #17211d;
            color: white;
            margin-top: auto;
            padding-top: 40px;
        }

        .footer-brand {
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
        }

        .footer-brand span {
            color: #4FD366;
        }

        .footer-text {
            color: #aeb8b2;
            font-size: 14px;
        }

        .footer-line {
            border-color: rgba(255,255,255,.1);
        }

        html {
            scroll-behavior: smooth;
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 30px 0 20px;
            }

            .page-title {
                font-size: 24px;
            }

            .rental-grid {
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
                gap: 20px;
                margin-top: 20px;
            }
        }

        @media (max-width: 576px) {
            .page-header {
                padding: 24px 0 16px;
            }

            .page-title {
                font-size: 20px;
            }

            .rental-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .rental-card-img {
                height: 160px;
            }

            .rental-actions {
                flex-direction: column;
            }

            .rental-action-btn {
                width: 100%;
            }
        }
    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @include('layouts.partials.modal-head-style')
</head>

<body>

<div style="height: 76px;"></div>
@include('layouts.partials.customer-nav')

    <div class="container">
        <div class="page-header">
            <a href="{{ route('customer.dashboard') }}" class="back-link">
                <i class="bi bi-arrow-left"></i>
                Kembali ke Dashboard
            </a>
            <h1 class="page-title">Riwayat Rental</h1>
        </div>
    </div>

    @if($rentals->count())
        <div class="container">
            <div class="rental-grid">
                @foreach($rentals as $rental)
                    @include('customer.partials.rental-card', ['rental' => $rental])
                @endforeach
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-clock-history"></i>
            </div>
            <p class="empty-text">Belum ada riwayat rental.</p>
        </div>
    @endif

</div>

@include('layouts.partials.customer-footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
