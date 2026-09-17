<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Customer - RentalKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>

        /* =========================================================
           ROOT
        ========================================================= */

        :root {
            --rk-green: #16834b;
            --rk-green-dark: #0f663a;
            --rk-green-light: #e9f7ef;

            --rk-cream: #f7f7f3;
            --rk-white: #ffffff;

            --rk-dark: #18201c;
            --rk-muted: #78817b;

            --rk-border: #e6ebe7;

            --rk-yellow: #f4b942;
            --rk-blue: #4d7cff;
            --rk-red: #dc5b5b;

            --rk-shadow:
                0 15px 45px rgba(24, 32, 28, .07);
        }


        /* =========================================================
           RESET
        ========================================================= */

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: var(--rk-cream);
            color: var(--rk-dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        button,
        a {
            -webkit-tap-highlight-color: transparent;
        }


        /* =========================================================
           PAGE BACKGROUND DECORATION
        ========================================================= */

        .rk-page-decoration {
            position: fixed;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: rgba(22, 131, 75, .045);
            filter: blur(5px);
            pointer-events: none;
            z-index: -1;
        }

        .rk-decoration-one {
            top: -180px;
            right: -100px;
        }

        .rk-decoration-two {
            bottom: -220px;
            left: -150px;
        }


        /* =========================================================
           NAVBAR
        ========================================================= */

        .rk-navbar {
            position: sticky;
            top: 0;
            z-index: 1000;

            background: rgba(247, 247, 243, .88);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);

            border-bottom: 1px solid rgba(230, 235, 231, .9);
        }

        .rk-navbar-inner {
            min-height: 78px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .rk-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--rk-dark);
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -1.2px;
        }

        .rk-brand:hover {
            color: var(--rk-dark);
        }

        .rk-brand-mark {
            width: 38px;
            height: 38px;
            border-radius: 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--rk-green);
            color: white;

            box-shadow: 0 7px 18px rgba(22, 131, 75, .2);
        }

        .rk-brand span {
            color: var(--rk-green);
        }


        /* =========================================================
           USER PROFILE CHIP
        ========================================================= */

        .rk-profile-trigger {
            display: flex;
            align-items: center;
            gap: 11px;

            padding: 6px 8px 6px 6px;

            border: 1px solid var(--rk-border);
            background: white;

            border-radius: 16px;

            cursor: pointer;

            transition: .25s ease;
        }

        .rk-profile-trigger:hover {
            border-color: rgba(22, 131, 75, .3);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(24, 32, 28, .06);
        }

        .rk-profile-avatar {
            width: 38px;
            height: 38px;

            border-radius: 12px;

            background: var(--rk-green);
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 14px;
            font-weight: 800;
        }

        .rk-profile-info {
            text-align: left;
            line-height: 1.2;
        }

        .rk-profile-info small {
            display: block;
            color: var(--rk-muted);
            font-size: 10px;
            margin-bottom: 3px;
        }

        .rk-profile-info strong {
            font-size: 13px;
            font-weight: 800;
        }

        .rk-profile-arrow {
            color: var(--rk-muted);
            font-size: 14px;
            margin-left: 2px;
        }


        /* =========================================================
           MAIN
        ========================================================= */

        .rk-main {
            padding: 34px 0 70px;
        }


        /* =========================================================
           WELCOME HEADER
        ========================================================= */

        .rk-welcome-row {
            margin-bottom: 25px;
        }

        .rk-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            color: var(--rk-green);

            font-size: 11px;
            font-weight: 800;

            text-transform: uppercase;
            letter-spacing: 1.4px;

            margin-bottom: 10px;
        }

        .rk-eyebrow-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--rk-green);
            box-shadow: 0 0 0 5px rgba(22, 131, 75, .1);
        }

        .rk-welcome-title {
            font-size: clamp(28px, 4vw, 42px);
            line-height: 1.1;
            letter-spacing: -1.7px;
            font-weight: 800;
            margin: 0;
        }

        .rk-welcome-title span {
            color: var(--rk-green);
        }

        .rk-welcome-description {
            color: var(--rk-muted);
            font-size: 14px;
            line-height: 1.7;
            max-width: 620px;
            margin: 11px 0 0;
        }


        /* =========================================================
           QUICK ACTION
        ========================================================= */

        .rk-quick-action {
            display: inline-flex;
            align-items: center;
            gap: 9px;

            background: var(--rk-dark);
            color: white;

            padding: 13px 18px;
            border-radius: 14px;

            font-size: 13px;
            font-weight: 700;

            transition: .25s ease;
        }

        .rk-quick-action:hover {
            background: var(--rk-green);
            color: white;
            transform: translateY(-2px);
        }

        .rk-quick-action i {
            font-size: 16px;
        }


        /* =========================================================
           BENTO HERO
        ========================================================= */

        .rk-bento-hero {
            display: grid;
            grid-template-columns: 1.35fr .65fr;
            gap: 16px;
            margin-bottom: 18px;
        }

        .rk-hero-main {
            position: relative;
            min-height: 330px;

            overflow: hidden;

            border-radius: 28px;

            background:
                linear-gradient(
                    120deg,
                    #123d2a 0%,
                    #1a8050 55%,
                    #36a56e 100%
                );

            color: white;

            padding: 42px;

            box-shadow:
                0 18px 55px rgba(15, 102, 58, .18);
        }

        .rk-hero-main::before {
            content: "";

            position: absolute;

            width: 330px;
            height: 330px;

            border-radius: 50%;

            right: -100px;
            top: -150px;

            background: rgba(255,255,255,.08);
        }

        .rk-hero-main::after {
            content: "";

            position: absolute;

            width: 220px;
            height: 220px;

            border-radius: 50%;

            right: 130px;
            bottom: -150px;

            background: rgba(255,255,255,.06);
        }

        .rk-hero-content {
            position: relative;
            z-index: 3;
            max-width: 620px;
        }

        .rk-hero-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            background: rgba(255,255,255,.13);
            border: 1px solid rgba(255,255,255,.18);

            padding: 8px 12px;

            border-radius: 100px;

            font-size: 11px;
            font-weight: 700;

            margin-bottom: 20px;

            backdrop-filter: blur(8px);
        }

        .rk-hero-label i {
            color: #bdf2d2;
        }

        .rk-hero-title {
            font-size: clamp(30px, 4vw, 52px);
            line-height: 1.05;

            letter-spacing: -2px;

            font-weight: 800;

            margin-bottom: 15px;
        }

        .rk-hero-title span {
            color: #baf1cf;
        }

        .rk-hero-text {
            max-width: 510px;

            color: rgba(255,255,255,.76);

            font-size: 14px;
            line-height: 1.8;

            margin-bottom: 25px;
        }

        .rk-hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
        }

        .rk-btn-white {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            background: white;
            color: var(--rk-green-dark);

            border-radius: 13px;

            padding: 12px 17px;

            font-size: 13px;
            font-weight: 800;

            transition: .25s ease;
        }

        .rk-btn-white:hover {
            color: var(--rk-green-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,.12);
        }

        .rk-btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            background: rgba(255,255,255,.1);
            color: white;

            border: 1px solid rgba(255,255,255,.2);

            border-radius: 13px;

            padding: 11px 16px;

            font-size: 13px;
            font-weight: 700;

            transition: .25s ease;
        }

        .rk-btn-ghost:hover {
            background: rgba(255,255,255,.18);
            color: white;
        }


        /* =========================================================
           HERO CAR IMAGE
        ========================================================= */

        .rk-hero-car {
            position: absolute;

            width: 430px;
            max-width: 52%;

            right: -15px;
            bottom: -10px;

            z-index: 2;

            filter:
                drop-shadow(0 30px 25px rgba(0,0,0,.25));

            transform: rotate(-2deg);

            transition: transform .5s ease;
        }

        .rk-hero-main:hover .rk-hero-car {
            transform:
                rotate(-1deg)
                translateY(-7px)
                scale(1.02);
        }


        /* =========================================================
           SIDE BENTO
        ========================================================= */

        .rk-side-stack {
            display: grid;
            grid-template-rows: 1fr 1fr;
            gap: 16px;
        }

        .rk-side-card {
            background: white;
            border: 1px solid var(--rk-border);
            border-radius: 24px;

            padding: 25px;

            box-shadow: var(--rk-shadow);

            position: relative;
            overflow: hidden;
        }

        .rk-side-card-green {
            background: #eaf7ef;
            border-color: #d8eedf;
        }

        .rk-side-icon {
            width: 45px;
            height: 45px;

            border-radius: 14px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--rk-green);
            color: white;

            font-size: 19px;

            margin-bottom: 18px;
        }

        .rk-side-card h4 {
            font-size: 17px;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .rk-side-card p {
            color: var(--rk-muted);
            font-size: 12px;
            line-height: 1.7;
            margin: 0;
        }

        .rk-side-card-green p {
            color: #527463;
        }

        .rk-side-decoration {
            position: absolute;

            width: 100px;
            height: 100px;

            border-radius: 50%;

            right: -35px;
            bottom: -35px;

            background: rgba(22,131,75,.06);
        }


        /* =========================================================
           STATS
        ========================================================= */

        .rk-stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;

            margin-bottom: 65px;
        }

        .rk-stat-card {
            background: white;

            border: 1px solid var(--rk-border);
            border-radius: 21px;

            padding: 20px;

            display: flex;
            align-items: center;
            gap: 15px;

            box-shadow: 0 8px 30px rgba(24,32,28,.045);

            transition: .25s ease;
        }

        .rk-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(24,32,28,.08);
        }

        .rk-stat-icon {
            width: 52px;
            height: 52px;

            flex: 0 0 52px;

            border-radius: 16px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 21px;
        }

        .rk-stat-icon.green {
            background: #e7f6ed;
            color: var(--rk-green);
        }

        .rk-stat-icon.yellow {
            background: #fff5db;
            color: #c28a18;
        }

        .rk-stat-icon.blue {
            background: #edf2ff;
            color: var(--rk-blue);
        }

        .rk-stat-label {
            color: var(--rk-muted);
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .rk-stat-number {
            font-size: 21px;
            font-weight: 800;
            letter-spacing: -.5px;
            margin: 0;
        }


        /* =========================================================
           SECTION HEADER
        ========================================================= */

        .rk-section {
            margin-bottom: 75px;
        }

        .rk-section-head {
            display: flex;
            align-items: end;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 25px;
        }

        .rk-section-label {
            color: var(--rk-green);

            font-size: 10px;
            font-weight: 800;

            text-transform: uppercase;
            letter-spacing: 1.5px;

            margin-bottom: 7px;
        }

        .rk-section-title {
            font-size: clamp(24px, 3vw, 32px);
            font-weight: 800;

            letter-spacing: -1.2px;

            margin: 0;
        }

        .rk-section-description {
            color: var(--rk-muted);
            font-size: 13px;
            line-height: 1.7;

            margin: 7px 0 0;
        }


        /* =========================================================
           RENTAL CARDS
        ========================================================= */

        .rk-rental-list {
            display: grid;
            gap: 15px;
        }

        .rk-rental-card {
            background: white;

            border: 1px solid var(--rk-border);
            border-radius: 22px;

            padding: 23px;

            box-shadow: 0 8px 30px rgba(24,32,28,.045);

            transition: .25s ease;
        }

        .rk-rental-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 38px rgba(24,32,28,.08);
        }

        .rk-rental-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;

            gap: 15px;

            margin-bottom: 20px;
        }

        .rk-rental-car-name {
            font-size: 17px;
            font-weight: 800;
            margin: 0 0 4px;
        }

        .rk-rental-id {
            color: var(--rk-muted);
            font-size: 11px;
        }

        .rk-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;

            border-radius: 100px;

            padding: 7px 10px;

            font-size: 10px;
            font-weight: 800;

            white-space: nowrap;
        }

        .rk-status.waiting {
            background: #fff4d7;
            color: #9a6b08;
        }

        .rk-status.approved {
            background: #e6f6ed;
            color: #167244;
        }

        .rk-status.running {
            background: #edf2ff;
            color: #456fd6;
        }

        .rk-status.finished {
            background: #eef0f1;
            color: #60686b;
        }

        .rk-status.cancelled {
            background: #fdeaea;
            color: #b34d4d;
        }

        .rk-rental-details {
            display: grid;
            grid-template-columns: repeat(4, 1fr);

            border-top: 1px solid #edf0ee;
            border-bottom: 1px solid #edf0ee;

            padding: 18px 0;

            margin-bottom: 18px;
        }

        .rk-detail-item {
            padding: 0 15px;
            border-right: 1px solid #edf0ee;
        }

        .rk-detail-item:first-child {
            padding-left: 0;
        }

        .rk-detail-item:last-child {
            border-right: 0;
            padding-right: 0;
        }

        .rk-detail-label {
            color: var(--rk-muted);
            font-size: 10px;
            margin-bottom: 5px;
        }

        .rk-detail-value {
            font-size: 13px;
            font-weight: 800;
        }

        .rk-detail-value.price {
            color: var(--rk-green);
        }


        /* =========================================================
           PAYMENT BUTTONS / ALERT
        ========================================================= */

        .rk-payment-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            width: 100%;

            background: var(--rk-green);
            color: white;

            border: none;

            border-radius: 13px;

            padding: 12px 15px;

            font-size: 12px;
            font-weight: 800;

            transition: .25s ease;
        }

        .rk-payment-button:hover {
            background: var(--rk-green-dark);
            color: white;
            transform: translateY(-1px);
        }

        .rk-payment-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;

            border-radius: 13px;

            padding: 13px 14px;

            font-size: 11px;
            line-height: 1.6;

            margin: 0;
        }

        .rk-payment-alert i {
            font-size: 16px;
            margin-top: 1px;
        }

        .rk-payment-info {
            background: #eef5ff;
            color: #466486;
            border: 1px solid #dce9fb;
        }

        .rk-payment-success {
            background: #eaf7ef;
            color: #31704c;
            border: 1px solid #d8eedf;
        }

        .rk-payment-warning {
            background: #fff7df;
            color: #8b6b1b;
            border: 1px solid #f6e7b5;
        }

        .rk-payment-danger {
            background: #fff0f0;
            color: #9c5050;
            border: 1px solid #f4dada;
        }

        .rk-upload-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            width: 100%;

            background: #d95353;
            color: white;

            border-radius: 13px;

            padding: 12px;

            font-size: 12px;
            font-weight: 800;

            transition: .25s ease;
        }

        .rk-upload-button:hover {
            background: #bb4141;
            color: white;
        }


        /* =========================================================
           EMPTY STATE
        ========================================================= */

        .rk-empty {
            background: white;

            border: 1px dashed #d8dfda;

            border-radius: 24px;

            padding: 55px 25px;

            text-align: center;
        }

        .rk-empty-icon {
            width: 70px;
            height: 70px;

            margin: auto;

            border-radius: 21px;

            background: #eef5f0;
            color: var(--rk-green);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 28px;
        }

        .rk-empty h5 {
            font-size: 16px;
            font-weight: 800;
            margin-top: 18px;
            margin-bottom: 7px;
        }

        .rk-empty p {
            color: var(--rk-muted);
            font-size: 12px;
            margin: 0;
        }


        /* =========================================================
           CAR GRID
        ========================================================= */

        .rk-car-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 17px;
        }

        .rk-car-card {
            background: white;

            border: 1px solid var(--rk-border);
            border-radius: 23px;

            overflow: hidden;

            height: 100%;

            box-shadow: 0 8px 28px rgba(24,32,28,.045);

            cursor: pointer;

            transition:
                transform .3s ease,
                box-shadow .3s ease,
                border-color .3s ease;
        }

        .rk-car-card:hover {
            transform: translateY(-7px);

            box-shadow:
                0 20px 45px rgba(24,32,28,.1);

            border-color: rgba(22,131,75,.22);
        }

        .rk-car-image-wrap {
            position: relative;

            height: 215px;

            background:
                radial-gradient(
                    circle at 50% 25%,
                    #ffffff 0%,
                    #f0f3f1 70%,
                    #e8ece9 100%
                );

            overflow: hidden;
        }

        .rk-car-image {
            width: 100%;
            height: 100%;

            object-fit: contain;

            padding: 14px;

            transition: transform .45s ease;
        }

        .rk-car-card:hover .rk-car-image {
            transform: scale(1.06);
        }

        .rk-car-status {
            position: absolute;

            top: 14px;
            left: 14px;

            display: inline-flex;
            align-items: center;
            gap: 5px;

            padding: 7px 10px;

            background: rgba(255,255,255,.9);

            border: 1px solid rgba(255,255,255,.8);

            backdrop-filter: blur(8px);

            border-radius: 100px;

            font-size: 10px;
            font-weight: 800;

            color: var(--rk-green);

            box-shadow: 0 5px 15px rgba(0,0,0,.06);
        }

        .rk-car-status.disewa {
            color: #5474c7;
        }

        .rk-car-status.maintenance {
            color: #a1741c;
        }

        .rk-car-arrow {
            position: absolute;

            right: 14px;
            bottom: 14px;

            width: 36px;
            height: 36px;

            border-radius: 12px;

            background: white;

            color: var(--rk-dark);

            display: flex;
            align-items: center;
            justify-content: center;

            box-shadow: 0 7px 18px rgba(0,0,0,.09);

            transition: .25s ease;
        }

        .rk-car-card:hover .rk-car-arrow {
            background: var(--rk-green);
            color: white;
            transform: rotate(-8deg);
        }

        .rk-car-body {
            padding: 20px;
        }

        .rk-car-name {
            font-size: 17px;
            font-weight: 800;

            margin-bottom: 7px;
        }

        .rk-car-info {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;

            color: var(--rk-muted);

            font-size: 10px;

            margin-bottom: 18px;
        }

        .rk-car-info span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .rk-car-info i {
            color: var(--rk-green);
        }

        .rk-car-bottom {
            display: flex;
            align-items: end;
            justify-content: space-between;

            gap: 10px;
        }

        .rk-price-label {
            color: var(--rk-muted);
            font-size: 10px;
            margin-bottom: 3px;
        }

        .rk-price {
            color: var(--rk-dark);
            font-size: 18px;
            font-weight: 800;
        }

        .rk-price span {
            color: var(--rk-muted);
            font-size: 10px;
            font-weight: 500;
        }

        .rk-rent-small {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            background: var(--rk-green);
            color: white;

            border-radius: 11px;

            padding: 10px 13px;

            font-size: 10px;
            font-weight: 800;

            transition: .25s ease;
        }

        .rk-rent-small:hover {
            background: var(--rk-green-dark);
            color: white;
        }


        /* =========================================================
           INFORMATION SECTION
        ========================================================= */

        .rk-info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .rk-info-card {
            position: relative;

            background: white;

            border: 1px solid var(--rk-border);
            border-radius: 22px;

            padding: 25px;

            min-height: 190px;

            overflow: hidden;

            transition: .25s ease;
        }

        .rk-info-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--rk-shadow);
        }

        .rk-info-number {
            position: absolute;

            right: 20px;
            top: 18px;

            color: #edf1ee;

            font-size: 48px;
            font-weight: 800;

            line-height: 1;
        }

        .rk-info-icon {
            width: 48px;
            height: 48px;

            border-radius: 14px;

            background: var(--rk-green-light);
            color: var(--rk-green);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 20px;

            margin-bottom: 20px;
        }

        .rk-info-card h5 {
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .rk-info-card p {
            color: var(--rk-muted);
            font-size: 11px;
            line-height: 1.7;
            margin: 0;
            max-width: 260px;
        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .rk-footer {
            background: var(--rk-dark);
            color: white;

            margin-top: 30px;
        }

        .rk-footer-main {
            padding: 45px 0;
        }

        .rk-footer-brand {
            display: inline-flex;
            align-items: center;
            gap: 9px;

            font-size: 21px;
            font-weight: 800;

            color: white;
        }

        .rk-footer-brand:hover {
            color: white;
        }

        .rk-footer-brand span {
            color: #55ce89;
        }

        .rk-footer-icon {
            width: 33px;
            height: 33px;

            border-radius: 10px;

            background: var(--rk-green);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 14px;
        }

        .rk-footer-text {
            color: #9ea9a3;

            font-size: 11px;
            line-height: 1.8;

            max-width: 410px;

            margin-top: 12px;
        }

        .rk-footer-title {
            font-size: 11px;
            font-weight: 800;

            color: white;

            margin-bottom: 10px;
        }

        .rk-footer-copy {
            color: #8f9a94;

            font-size: 10px;

            padding: 18px 0;

            border-top: 1px solid rgba(255,255,255,.08);
        }


        /* =========================================================
           MODAL DETAIL
        ========================================================= */

        #mobilDetailModal .modal-content {
            border: none;
            border-radius: 25px !important;
            overflow: hidden;

            box-shadow:
                0 25px 80px rgba(0,0,0,.2);
        }

        #mobilDetailModal .modal-header {
            padding: 22px 25px 10px;
        }

        #mobilDetailModal .modal-title {
            font-size: 18px;
            font-weight: 800;
        }

        #mobilDetailModal .modal-body {
            min-height: 180px;
        }


        /* =========================================================
           SWEETALERT
        ========================================================= */

        .swal2-popup {
            border-radius: 22px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        .swal2-title {
            font-weight: 800 !important;
        }

        .swal2-confirm {
            border-radius: 11px !important;
            font-weight: 700 !important;
        }


        /* =========================================================
           RESPONSIVE TABLET
        ========================================================= */

        @media (max-width: 991px) {

            .rk-main {
                padding-top: 25px;
            }

            .rk-bento-hero {
                grid-template-columns: 1fr;
            }

            .rk-side-stack {
                grid-template-columns: 1fr 1fr;
                grid-template-rows: auto;
            }

            .rk-stat-grid {
                margin-bottom: 55px;
            }

            .rk-car-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .rk-info-grid {
                grid-template-columns: 1fr 1fr;
            }

            .rk-rental-details {
                grid-template-columns: repeat(2, 1fr);
                row-gap: 18px;
            }

            .rk-detail-item:nth-child(2) {
                border-right: 0;
            }

            .rk-detail-item:nth-child(3) {
                padding-left: 0;
            }

            .rk-hero-car {
                width: 380px;
                max-width: 45%;
            }
        }


        /* =========================================================
           RESPONSIVE MOBILE
        ========================================================= */

        @media (max-width: 767px) {

            .rk-navbar-inner {
                min-height: 68px;
            }

            .rk-brand {
                font-size: 21px;
            }

            .rk-brand-mark {
                width: 34px;
                height: 34px;
                border-radius: 10px;
            }

            .rk-profile-info,
            .rk-profile-arrow {
                display: none;
            }

            .rk-profile-trigger {
                padding: 5px;
                border-radius: 13px;
            }

            .rk-profile-avatar {
                width: 37px;
                height: 37px;
            }

            .rk-main {
                padding-top: 22px;
                padding-bottom: 50px;
            }

            .rk-welcome-title {
                font-size: 29px;
            }

            .rk-welcome-description {
                font-size: 12px;
            }

            .rk-quick-action {
                margin-top: 15px;
                width: 100%;
                justify-content: center;
            }

            .rk-hero-main {
                min-height: 450px;
                padding: 28px;
                border-radius: 24px;
            }

            .rk-hero-title {
                font-size: 34px;
            }

            .rk-hero-text {
                font-size: 12px;
                max-width: 100%;
            }

            .rk-hero-car {
                width: 400px;
                max-width: 90%;
                right: -55px;
                bottom: -8px;
                opacity: .92;
            }

            .rk-side-stack {
                grid-template-columns: 1fr;
            }

            .rk-side-card {
                border-radius: 21px;
            }

            .rk-stat-grid {
                grid-template-columns: 1fr;
                gap: 10px;
                margin-bottom: 50px;
            }

            .rk-stat-card {
                padding: 16px;
            }

            .rk-section {
                margin-bottom: 55px;
            }

            .rk-section-head {
                display: block;
            }

            .rk-section-title {
                font-size: 25px;
            }

            .rk-car-grid {
                grid-template-columns: 1fr;
            }

            .rk-car-image-wrap {
                height: 225px;
            }

            .rk-info-grid {
                grid-template-columns: 1fr;
            }

            .rk-rental-top {
                flex-direction: column;
            }

            .rk-rental-details {
                grid-template-columns: 1fr 1fr;
            }

            .rk-detail-item {
                padding: 0 10px;
            }

            .rk-detail-item:nth-child(3) {
                padding-left: 0;
            }

            .rk-detail-item:nth-child(2),
            .rk-detail-item:nth-child(4) {
                border-right: 0;
            }

            .rk-footer-main {
                padding: 38px 0;
            }
        }


        @media (max-width: 420px) {

            .container {
                padding-left: 16px;
                padding-right: 16px;
            }

            .rk-hero-main {
                min-height: 470px;
            }

            .rk-hero-title {
                font-size: 30px;
            }

            .rk-hero-buttons {
                flex-direction: column;
            }

            .rk-btn-white,
            .rk-btn-ghost {
                width: 100%;
                justify-content: center;
            }

            .rk-rental-card {
                padding: 17px;
            }

            .rk-rental-details {
                gap: 15px 0;
            }

            .rk-detail-item {
                border-right: 0 !important;
                padding-left: 0 !important;
            }
        }


        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            html {
                scroll-behavior: auto;
            }

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }

        }

    </style>

</head>


<body>


    {{-- DECORATION BACKGROUND --}}
    <div class="rk-page-decoration rk-decoration-one"></div>
    <div class="rk-page-decoration rk-decoration-two"></div>


    {{-- =========================================================
         NAVBAR CUSTOMER
    ========================================================== --}}

    <nav class="rk-navbar">

        <div class="container">

            <div class="rk-navbar-inner">

                <a
                    href="{{ url('/') }}"
                    class="rk-brand"
                >

                    <div class="rk-brand-mark">
                        <i class="bi bi-car-front-fill"></i>
                    </div>

                    Rental<span>ku</span>.

                </a>


                <div
                    class="rk-profile-trigger"
                    data-bs-toggle="modal"
                    data-bs-target="#profileModal"
                    title="Buka profil"
                >

                    <div class="rk-profile-avatar">

                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                    </div>

                    <div class="rk-profile-info">

                        <small>
                            Customer
                        </small>

                        <strong>
                            {{ Auth::user()->name }}
                        </strong>

                    </div>

                    <i class="bi bi-chevron-down rk-profile-arrow"></i>

                </div>

            </div>

        </div>

    </nav>



    {{-- =========================================================
         MAIN
    ========================================================== --}}

    <main class="rk-main">

        <div class="container">


            {{-- =================================================
                 WELCOME
            ================================================== --}}

            <div class="row align-items-end rk-welcome-row">

                <div class="col-lg-8">

                    <div class="rk-eyebrow">

                        <span class="rk-eyebrow-dot"></span>

                        Dashboard Customer

                    </div>

                    <h1 class="rk-welcome-title">

                        Halo,
                        <span>{{ Auth::user()->name }}</span> 👋

                    </h1>

                    <p class="rk-welcome-description">

                        Kelola perjalananmu dengan mudah.
                        Temukan kendaraan yang sesuai, lihat rental,
                        dan pantau pembayaranmu di satu tempat.

                    </p>

                </div>


                <div class="col-lg-4 text-lg-end">

                    <a
                        href="#mobil"
                        class="rk-quick-action"
                    >

                        <i class="bi bi-search"></i>

                        Cari Mobil

                    </a>

                </div>

            </div>



            {{-- =================================================
                 BENTO HERO
            ================================================== --}}

            <div class="rk-bento-hero">


                {{-- HERO UTAMA --}}

                <div class="rk-hero-main">

                    <div class="rk-hero-content">

                        <div class="rk-hero-label">

                            <i class="bi bi-stars"></i>

                            Perjalanan lebih nyaman

                        </div>


                        <h2 class="rk-hero-title">

                            Temukan mobil
                            untuk perjalanan
                            <span>berikutnya.</span>

                        </h2>


                        <p class="rk-hero-text">

                            Pilih kendaraan favoritmu,
                            lihat detailnya, tentukan jadwal,
                            lalu ajukan rental dengan mudah
                            melalui RentalKu.

                        </p>


                        <div class="rk-hero-buttons">

                            <a
                                href="#mobil"
                                class="rk-btn-white"
                            >

                                <i class="bi bi-car-front-fill"></i>

                                Lihat Mobil

                            </a>


                            <a
                                href="#informasi"
                                class="rk-btn-ghost"
                            >

                                Pelajari Rental

                                <i class="bi bi-arrow-right"></i>

                            </a>

                        </div>

                    </div>


                    {{-- FOTO MOBIL --}}

                    <img
                        src="https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg"
                        class="rk-hero-car"
                        alt="Mobil RentalKu"
                    >

                </div>



                {{-- SIDE BENTO --}}

                <div class="rk-side-stack">


                    <div class="rk-side-card rk-side-card-green">

                        <div class="rk-side-icon">

                            <i class="bi bi-shield-check"></i>

                        </div>

                        <h4>
                            Rental Lebih Tenang
                        </h4>

                        <p>
                            Semua proses rental dapat
                            kamu pantau langsung dari
                            dashboard customer.
                        </p>

                        <div class="rk-side-decoration"></div>

                    </div>


                    <div class="rk-side-card">

                        <div class="rk-side-icon">

                            <i class="bi bi-wallet2"></i>

                        </div>

                        <h4>
                            Pembayaran Praktis
                        </h4>

                        <p>
                            Setelah rental disetujui,
                            lakukan pembayaran dan
                            upload bukti dengan mudah.
                        </p>

                        <div class="rk-side-decoration"></div>

                    </div>

                </div>

            </div>



            {{-- =================================================
                 STATS
            ================================================== --}}

            <div class="rk-stat-grid">


                {{-- MOBIL --}}

                <div class="rk-stat-card">

                    <div class="rk-stat-icon green">

                        <i class="bi bi-car-front-fill"></i>

                    </div>

                    <div>

                        <div class="rk-stat-label">
                            Mobil Tersedia
                        </div>

                        <p class="rk-stat-number">
                            {{ $mobils->count() }}
                        </p>

                    </div>

                </div>


                {{-- RENTAL --}}

                <div class="rk-stat-card">

                    <div class="rk-stat-icon yellow">

                        <i class="bi bi-calendar-check-fill"></i>

                    </div>

                    <div>

                        <div class="rk-stat-label">
                            Rental Saya
                        </div>

                        <p class="rk-stat-number">
                            0
                        </p>

                    </div>

                </div>


                {{-- TRANSAKSI --}}

                <div class="rk-stat-card">

                    <div class="rk-stat-icon blue">

                        <i class="bi bi-wallet2"></i>

                    </div>

                    <div>

                        <div class="rk-stat-label">
                            Total Transaksi
                        </div>

                        <p class="rk-stat-number">
                            Rp 0
                        </p>

                    </div>

                </div>

            </div>



            {{-- =================================================
                 RENTAL SAYA
            ================================================== --}}

            <section class="rk-section">

                <div class="rk-section-head">

                    <div>

                        <div class="rk-section-label">
                            Aktivitas Rental
                        </div>

                        <h2 class="rk-section-title">
                            Rental Saya
                        </h2>

                        <p class="rk-section-description">
                            Lihat status rental dan lakukan pembayaran kendaraanmu.
                        </p>

                    </div>

                </div>


                @if($rentals->count())


                    <div class="rk-rental-list">


                        @foreach($rentals as $rental)


                            <div class="rk-rental-card">


                                {{-- HEADER RENTAL --}}

                                <div class="rk-rental-top">

                                    <div>

                                        <h5 class="rk-rental-car-name">

                                            {{ $rental->mobil->name ?? 'Mobil' }}

                                        </h5>

                                        <div class="rk-rental-id">

                                            Rental #{{ $rental->id }}

                                        </div>

                                    </div>


                                    {{-- STATUS --}}

                                    @if($rental->status === 'Menunggu')

                                        <span class="rk-status waiting">

                                            <i class="bi bi-hourglass-split"></i>

                                            Menunggu

                                        </span>

                                    @elseif($rental->status === 'Disetujui')

                                        <span class="rk-status approved">

                                            <i class="bi bi-check-circle-fill"></i>

                                            Disetujui

                                        </span>

                                    @elseif($rental->status === 'Berjalan')

                                        <span class="rk-status running">

                                            <i class="bi bi-car-front-fill"></i>

                                            Berjalan

                                        </span>

                                    @elseif($rental->status === 'Selesai')

                                        <span class="rk-status finished">

                                            <i class="bi bi-check2-circle"></i>

                                            Selesai

                                        </span>

                                    @else

                                        <span class="rk-status cancelled">

                                            <i class="bi bi-x-circle"></i>

                                            Dibatalkan

                                        </span>

                                    @endif

                                </div>



                                {{-- DETAIL RENTAL --}}

                                <div class="rk-rental-details">


                                    <div class="rk-detail-item">

                                        <div class="rk-detail-label">
                                            Tanggal Mulai
                                        </div>

                                        <div class="rk-detail-value">

                                            {{ $rental->tanggal_mulai->format('d/m/Y') }}

                                        </div>

                                    </div>


                                    <div class="rk-detail-item">

                                        <div class="rk-detail-label">
                                            Tanggal Selesai
                                        </div>

                                        <div class="rk-detail-value">

                                            {{ $rental->tanggal_selesai->format('d/m/Y') }}

                                        </div>

                                    </div>


                                    <div class="rk-detail-item">

                                        <div class="rk-detail-label">
                                            Jumlah Hari
                                        </div>

                                        <div class="rk-detail-value">

                                            {{ $rental->jumlah_hari }} Hari

                                        </div>

                                    </div>


                                    <div class="rk-detail-item">

                                        <div class="rk-detail-label">
                                            Total Harga
                                        </div>

                                        <div class="rk-detail-value price">

                                            Rp
                                            {{ number_format($rental->total_harga, 0, ',', '.') }}

                                        </div>

                                    </div>


                                </div>



                                {{-- =================================================
                                     PEMBAYARAN
                                ================================================== --}}

                                @if($rental->status === 'Disetujui')


                                    @if(!$rental->pembayaran)

                                        <a
                                            href="{{ route('pembayaran.create', $rental->id) }}"
                                            class="rk-payment-button"
                                        >

                                            <i class="bi bi-credit-card"></i>

                                            Bayar Sekarang

                                        </a>


                                    @elseif($rental->pembayaran->status === 'Menunggu')


                                        <div class="rk-payment-alert rk-payment-info">

                                            <i class="bi bi-clock-history"></i>

                                            <div>

                                                Bukti pembayaran sudah dikirim
                                                dan sedang menunggu verifikasi admin.

                                            </div>

                                        </div>


                                    @elseif($rental->pembayaran->status === 'Disetujui')


                                        <div class="rk-payment-alert rk-payment-success">

                                            <i class="bi bi-check-circle-fill"></i>

                                            <div>

                                                Pembayaran sudah diverifikasi admin.

                                            </div>

                                        </div>


                                    @elseif($rental->pembayaran->status === 'Ditolak')


                                        <a
                                            href="{{ route('pembayaran.create', $rental->id) }}"
                                            class="rk-upload-button"
                                        >

                                            <i class="bi bi-arrow-repeat"></i>

                                            Upload Ulang Pembayaran

                                        </a>

                                    @endif


                                @elseif($rental->status === 'Menunggu')


                                    <div class="rk-payment-alert rk-payment-warning">

                                        <i class="bi bi-hourglass-split"></i>

                                        <div>

                                            Menunggu persetujuan admin sebelum
                                            melakukan pembayaran.

                                        </div>

                                    </div>


                                @elseif($rental->status === 'Ditolak')


                                    <div class="rk-payment-alert rk-payment-danger">

                                        <i class="bi bi-x-circle"></i>

                                        <div>

                                            Pengajuan rental ditolak.

                                        </div>

                                    </div>


                                @elseif($rental->status === 'Selesai')


                                    <div class="rk-payment-alert">

                                        <i class="bi bi-check2-circle"></i>

                                        <div>

                                            Rental telah selesai.

                                        </div>

                                    </div>

                                @endif


                            </div>


                        @endforeach


                    </div>


                @else


                    <div class="rk-empty">

                        <div class="rk-empty-icon">

                            <i class="bi bi-calendar-x"></i>

                        </div>

                        <h5>
                            Belum Ada Rental
                        </h5>

                        <p>
                            Rental yang kamu lakukan akan muncul di sini.
                        </p>

                    </div>


                @endif

            </section>



            {{-- =================================================
                 MOBIL
            ================================================== --}}

            <section
                class="rk-section"
                id="mobil"
            >

                <div class="rk-section-head">

                    <div>

                        <div class="rk-section-label">
                            Pilihan Rental
                        </div>

                        <h2 class="rk-section-title">
                            Mobil Pilihan Untukmu
                        </h2>

                        <p class="rk-section-description">
                            Temukan kendaraan yang cocok untuk menemani perjalananmu.
                        </p>

                    </div>

                </div>



                <div class="rk-car-grid">


                    @forelse($mobils as $index => $mobil)


                        <div
                            class="rk-car-card"
                            data-mobil-id="{{ $mobil->id }}"
                            role="button"
                            title="Lihat detail {{ $mobil->name }}"
                        >


                            {{-- FOTO --}}

                            <div class="rk-car-image-wrap">


                                @if($mobil->image)

                                    <img
                                        src="{{ asset($mobil->image) }}"
                                        class="rk-car-image"
                                        alt="{{ $mobil->name }}"
                                    >

                                @else

                                    <img
                                        src="https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg"
                                        class="rk-car-image"
                                        alt="{{ $mobil->name }}"
                                    >

                                @endif



                                {{-- STATUS --}}

                                @if($mobil->status == 'Tersedia')

                                    <div class="rk-car-status">

                                        <i class="bi bi-check-circle-fill"></i>

                                        Tersedia

                                    </div>

                                @elseif($mobil->status == 'Disewa')

                                    <div class="rk-car-status disewa">

                                        <i class="bi bi-calendar-check-fill"></i>

                                        Disewa

                                    </div>

                                @else

                                    <div class="rk-car-status maintenance">

                                        <i class="bi bi-tools"></i>

                                        Maintenance

                                    </div>

                                @endif



                                <div class="rk-car-arrow">

                                    <i class="bi bi-arrow-up-right"></i>

                                </div>


                            </div>



                            {{-- CONTENT --}}

                            <div class="rk-car-body">


                                <h5 class="rk-car-name">

                                    {{ $mobil->name }}

                                </h5>


                                <div class="rk-car-info">

                                    <span>

                                        <i class="bi bi-gear-fill"></i>

                                        {{ $mobil->transmisi }}

                                    </span>


                                    <span>

                                        <i class="bi bi-people-fill"></i>

                                        {{ $mobil->kapasitas }} orang

                                    </span>

                                </div>



                                <div class="rk-car-bottom">


                                    <div>

                                        <div class="rk-price-label">
                                            Mulai dari
                                        </div>

                                        <div class="rk-price">

                                            Rp
                                            {{ number_format($mobil->harga_perhari, 0, ',', '.') }}

                                            <span>
                                                /hari
                                            </span>

                                        </div>

                                    </div>


                              <button
    type="button"
    class="rk-rent-small"
    data-mobil-id="{{ $mobil->id }}"
>
    <i class="bi bi-calendar-check me-1"></i>
    Sewa
</button>

                                </div>


                            </div>


                        </div>


                    @empty


                        <div class="rk-empty" style="grid-column: 1 / -1;">

                            <div class="rk-empty-icon">

                                <i class="bi bi-car-front"></i>

                            </div>

                            <h5>
                                Belum Ada Mobil
                            </h5>

                            <p>
                                Mobil yang tersedia akan muncul di halaman ini.
                            </p>

                        </div>


                    @endforelse


                </div>

            </section>



            {{-- =================================================
                 INFORMASI
            ================================================== --}}

            <section
                class="rk-section"
                id="informasi"
            >

                <div class="rk-section-head">

                    <div>

                        <div class="rk-section-label">
                            Kenapa RentalKu?
                        </div>

                        <h2 class="rk-section-title">
                            Dibuat untuk perjalananmu.
                        </h2>

                        <p class="rk-section-description">
                            Semua kebutuhan rental tersedia dalam satu tempat.
                        </p>

                    </div>

                </div>



                <div class="rk-info-grid">


                    <div class="rk-info-card">

                        <div class="rk-info-number">
                            01
                        </div>

                        <div class="rk-info-icon">

                            <i class="bi bi-shield-check"></i>

                        </div>

                        <h5>
                            Aman & Terpercaya
                        </h5>

                        <p>
                            RentalKu menyediakan kendaraan
                            untuk membantu perjalananmu dengan nyaman.
                        </p>

                    </div>



                    <div class="rk-info-card">

                        <div class="rk-info-number">
                            02
                        </div>

                        <div class="rk-info-icon">

                            <i class="bi bi-lightning-charge"></i>

                        </div>

                        <h5>
                            Proses Mudah
                        </h5>

                        <p>
                            Pilih mobil sesuai kebutuhanmu
                            dan lakukan proses rental dengan mudah.
                        </p>

                    </div>



                    <div class="rk-info-card">

                        <div class="rk-info-number">
                            03
                        </div>

                        <div class="rk-info-icon">

                            <i class="bi bi-headset"></i>

                        </div>

                        <h5>
                            Siap Membantu
                        </h5>

                        <p>
                            Tim RentalKu siap membantu
                            kebutuhan rental kendaraanmu.
                        </p>

                    </div>


                </div>

            </section>


        </div>

    </main>



    {{-- =========================================================
         FOOTER
    ========================================================== --}}

    <footer class="rk-footer">

        <div class="container">

            <div class="rk-footer-main">

                <div class="row g-4">


                    <div class="col-lg-7">

                        <a
                            href="{{ url('/') }}"
                            class="rk-footer-brand"
                        >

                            <div class="rk-footer-icon">

                                <i class="bi bi-car-front-fill"></i>

                            </div>

                            Rental<span>ku</span>.

                        </a>

                        <p class="rk-footer-text">

                            Solusi rental mobil yang nyaman,
                            mudah, dan terpercaya untuk menemani
                            setiap perjalananmu.

                        </p>

                    </div>


                    <div class="col-lg-5">

                        <div class="rk-footer-title">
                            Dashboard Customer
                        </div>

                        <div class="rk-footer-text mt-0">

                            Kelola rental, lihat status kendaraan,
                            dan lakukan pembayaran langsung
                            melalui dashboard RentalKu.

                        </div>

                    </div>


                </div>

            </div>


            <div class="rk-footer-copy">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                    <span>
                        &copy; {{ date('Y') }} RentalKu.
                        Semua hak dilindungi.
                    </span>

                    <span>
                        <i class="bi bi-images me-1"></i>
                        Foto kendaraan menggunakan Pexels API
                    </span>

                </div>

            </div>

        </div>

    </footer>



    {{-- =========================================================
         MODAL DETAIL MOBIL
    ========================================================== --}}

    <div
        class="modal fade"
        id="mobilDetailModal"
        tabindex="-1"
        aria-labelledby="mobilDetailModalLabel"
        aria-hidden="true"
    >

        <div
            class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
        >

            <div class="modal-content">


                <div class="modal-header border-0">

                    <h5
                        class="modal-title"
                        id="mobilDetailModalLabel"
                    >
                        Detail Mobil
                    </h5>


                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Tutup"
                    ></button>

                </div>


                <div
                    class="modal-body p-0"
                    id="mobilDetailModalBody"
                ></div>


            </div>

        </div>

    </div>



    {{-- =========================================================
         MODAL PROFILE
    ========================================================== --}}

    @include('layouts.partials.profile-modal')



    {{-- BOOTSTRAP --}}

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>


  {{-- JQUERY --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>

        /* =========================================================
           DETAIL MOBIL VIA AJAX
        ========================================================= */

        var $mobilDetailModalBody = $('#mobilDetailModalBody');


        function openMobilDetail(mobilId) {

            $mobilDetailModalBody.html(`

                <div class="text-center py-5">

                    <div
                        class="spinner-border text-success"
                        role="status"
                    ></div>

                    <div class="mt-3 text-muted small">
                        Memuat detail mobil...
                    </div>

                </div>

            `);


            $.ajax({

                url: '/mobils/' + mobilId,

                headers: {

                    'Accept': 'application/json',

                    'X-Requested-With': 'XMLHttpRequest'

                }

            })

            .done(function(html) {

                $mobilDetailModalBody.html(html);


                bootstrap.Modal
                    .getOrCreateInstance(
                        $('#mobilDetailModal')[0]
                    )
                    .show();

            })

            .fail(function() {

                $mobilDetailModalBody.html(`

                    <div class="alert alert-danger m-4">

                        <i class="bi bi-exclamation-triangle me-1"></i>

                        Gagal memuat detail mobil.
                        Silakan coba lagi.

                    </div>

                `);

            });

        }



        /* =========================================================
           CLICK CARD MOBIL
        ========================================================= */

       /* =========================================================
   CLICK CARD DAN TOMBOL SEWA
========================================================= */

// Klik tombol Sewa
$(document).on('click', '.rk-rent-small', function(event) {

    event.preventDefault();
    event.stopPropagation();

    var mobilId = $(this).data('mobil-id');

    if (!mobilId) {
        Swal.fire({
            icon: 'warning',
            title: 'Mobil Tidak Ditemukan',
            text: 'ID mobil tidak tersedia.'
        });

        return;
    }

    // Buka detail mobil terlebih dahulu
    openMobilDetail(mobilId);

});


// Klik kartu mobil
$(document).on('click', '.rk-car-card', function(event) {

    // Jangan jalankan ketika yang diklik tombol Sewa
    if ($(event.target).closest('.rk-rent-small').length) {
        return;
    }

    var mobilId = $(this).data('mobil-id');

    if (mobilId) {
        openMobilDetail(mobilId);
    }

});



      

    /*
    |--------------------------------------------------------------------------
    | POPUP SEWA MOBIL RENTALKU
    |--------------------------------------------------------------------------
    */

    window.openSewaPopup = function () {

        const $template = $('#sewaFormTemplate');

        if (!$template.length) {
            Swal.fire({
                icon: 'error',
                title: 'Form Tidak Ditemukan',
                text: 'Form sewa mobil belum tersedia. Silakan muat ulang halaman.'
            });

            return;
        }

        const formHtml = $template.html();

        Swal.fire({
            title: 'Form Sewa Mobil',
            html: formHtml,
            width: 650,
            showConfirmButton: false,
            showCloseButton: true,
            focusConfirm: false,
            customClass: {
                popup: 'rounded-4'
            },

            didOpen: function () {

                const $swal = $('#swal2-html-container');
                const $form = $swal.find('form');

                if (!$form.length) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Form Error',
                        text: 'Form sewa tidak ditemukan.'
                    });

                    return;
                }

                // Pastikan tanggal selesai tidak sebelum tanggal mulai
                $form.find('input[name="tanggal_mulai"]').on('change', function () {

                    const tanggalMulai = $(this).val();
                    const $tanggalSelesai =
                        $form.find('input[name="tanggal_selesai"]');

                    $tanggalSelesai.attr('min', tanggalMulai);

                    if ($tanggalSelesai.val() &&
                        $tanggalSelesai.val() <= tanggalMulai) {

                        $tanggalSelesai.val('');
                    }
                });

                // Submit form menggunakan AJAX
                $form.on('submit', function (event) {

                    event.preventDefault();

                    const formElement = this;
                    const formData = new FormData(formElement);
                    const actionUrl = $form.attr('action');

                    const tanggalMulai =
                        $form.find('input[name="tanggal_mulai"]').val();

                    const tanggalSelesai =
                        $form.find('input[name="tanggal_selesai"]').val();

                    if (!tanggalMulai || !tanggalSelesai) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Belum Lengkap',
                            text: 'Silakan isi tanggal mulai dan tanggal selesai.'
                        });

                        return;
                    }

                    if (tanggalSelesai <= tanggalMulai) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tanggal Tidak Valid',
                            text: 'Tanggal selesai harus setelah tanggal mulai.'
                        });

                        return;
                    }

                    Swal.fire({
                        title: 'Mengirim Pengajuan...',
                        text: 'Mohon tunggu sebentar.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: function () {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: actionUrl,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,

                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },

                        success: function (response) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message ||
                                    'Pengajuan sewa mobil berhasil dibuat.',
                                confirmButtonText: 'OK'
                            }).then(function () {

                                window.location.href =
                                    '{{ route("customer.dashboard") }}';

                            });

                        },

                        error: function (xhr) {

                            let errorMessage =
                                'Terjadi kesalahan. Silakan coba lagi.';

                            if (xhr.responseJSON) {

                                const response =
                                    xhr.responseJSON;

                                if (response.errors) {

                                    const errors =
                                        Object.values(response.errors)
                                            .flat();

                                    if (errors.length > 0) {
                                        errorMessage = errors[0];
                                    }

                                } else if (response.message) {

                                    errorMessage = response.message;

                                }
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Pengajuan Gagal',
                                text: errorMessage,
                                confirmButtonText: 'Mengerti'
                            });

                        }
                    });

                });

            }
        });

    };
</script>

</body>

</html>
