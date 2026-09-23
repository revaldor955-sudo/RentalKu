<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Rentalku - Rental Mobil Terpercaya')
    </title>

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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>

        :root {

            --rk-green: #16a34a;
            --rk-green-light: #4ade80;
            --rk-green-dark: #15803d;

            --rk-black: #07110c;
            --rk-dark: #0b1711;

            --rk-text: #101713;
            --rk-muted: #66736b;

            --rk-bg: #f6f8f7;
            --rk-white: #ffffff;

            --rk-border: rgba(16, 24, 20, .09);

        }


        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        html {
            scroll-behavior: smooth;
        }


        body {

            font-family: 'Plus Jakarta Sans', sans-serif;

            color: var(--rk-text);

            background: #fff;

            overflow-x: clip;

        }


        a {
            text-decoration: none;
        }


        button,
        input,
        select {
            font-family: inherit;
        }


        .rk-loader {

            position: fixed;

            inset: 0;

            z-index: 99999;

            background: #06100b;

            display: flex;

            align-items: center;

            justify-content: center;

            transition:
                opacity .8s ease,
                visibility .8s ease;

        }


        .rk-loader.hide {

            opacity: 0;

            visibility: hidden;

            pointer-events: none;

        }


        .rk-loader-content {

            width: min(420px, 80%);

            text-align: center;

            color: white;

        }


        .rk-loader-logo {

            font-size: 46px;

            font-weight: 800;

            letter-spacing: -3px;

            margin-bottom: 30px;

        }


        .rk-loader-logo span {
            color: var(--rk-green-light);
        }


        .rk-loader-logo b {
            color: var(--rk-green-light);
        }


        .rk-loader-road {

            position: relative;

            height: 2px;

            background: rgba(255,255,255,.12);

            overflow: hidden;

            border-radius: 20px;

        }


        .rk-loader-road::after {

            content: '';

            position: absolute;

            left: -30%;

            top: 0;

            width: 30%;

            height: 100%;

            background: var(--rk-green-light);

            box-shadow: 0 0 20px var(--rk-green-light);

            animation: rkLoading 1.5s ease infinite;

        }


        .rk-loader-text {

            margin-top: 16px;

            font-size: 11px;

            letter-spacing: 4px;

            text-transform: uppercase;

            color: rgba(255,255,255,.45);

        }


        @keyframes rkLoading {

            0% {
                left: -30%;
            }

            100% {
                left: 100%;
            }

        }


        .rk-navbar {

            position: fixed;

            top: 0;

            left: 0;

            width: 100%;

            z-index: 5000;

            padding: 18px 0;

            background: transparent;

            border-bottom: 1px solid transparent;

            transition:
                background .35s ease,
                backdrop-filter .35s ease,
                padding .35s ease,
                border-color .35s ease;

        }


        .rk-navbar.scrolled {

            padding: 11px 0;

            background: rgba(7, 17, 12, .88);

            backdrop-filter: blur(22px);

            -webkit-backdrop-filter: blur(22px);

            border-color: rgba(255,255,255,.08);

        }


        .rk-navbar-inner {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 30px;

        }


        .rk-logo {

            color: white !important;

            font-size: 27px;

            font-weight: 800;

            letter-spacing: -1.7px;

            white-space: nowrap;

        }


        .rk-logo span,
        .rk-logo b {

            color: var(--rk-green-light);

        }


        .rk-desktop-menu {

            display: flex;

            align-items: center;

            gap: 5px;

        }


        .rk-nav-link {

            position: relative;

            display: flex;

            align-items: center;

            gap: 7px;

            color: rgba(255,255,255,.72);

            font-size: 13px;

            font-weight: 600;

            padding: 10px 12px;

            transition: color .25s ease;

        }


        .rk-nav-link span {

            font-size: 8px;

            color: rgba(255,255,255,.35);

            letter-spacing: 1px;

            transition: color .25s ease;

        }


        .rk-nav-link::after {

            content: '';

            position: absolute;

            left: 12px;

            right: 12px;

            bottom: 2px;

            height: 1px;

            background: var(--rk-green-light);

            transform: scaleX(0);

            transform-origin: left;

            transition: transform .25s ease;

        }


        .rk-nav-link:hover {

            color: white;

        }


        .rk-nav-link:hover span {

            color: var(--rk-green-light);

        }


        .rk-nav-link:hover::after {

            transform: scaleX(1);

        }


        .rk-navbar-actions {

            display: flex;

            align-items: center;

            gap: 10px;

        }


        .rk-login {

            color: white;

            border: 1px solid rgba(255,255,255,.22);

            background: rgba(255,255,255,.06);

            border-radius: 100px;

            padding: 11px 19px;

            font-size: 13px;

            font-weight: 700;

            transition: .25s ease;

        }


        .rk-login:hover {

            background: white;

            color: var(--rk-black);

        }


        .rk-register {

            display: inline-flex;

            align-items: center;

            gap: 9px;

            color: #06100b;

            background: var(--rk-green-light);

            border-radius: 100px;

            padding: 12px 19px;

            font-size: 13px;

            font-weight: 800;

            transition:
                transform .25s ease,
                box-shadow .25s ease;

        }


        .rk-register:hover {

            color: #06100b;

            transform: translateY(-2px);

            box-shadow: 0 10px 30px rgba(74,222,128,.22);

        }


        .rk-user {

            display: flex;

            align-items: center;

            gap: 9px;

            color: white;

            font-size: 12px;

            font-weight: 700;

        }


        .rk-user-avatar {

            width: 34px;

            height: 34px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background: var(--rk-green-light);

            color: #06100b;

            font-weight: 800;

        }


        .rk-logout {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            border: 1px solid rgba(255,255,255,.15);

            color: white;

            background: rgba(255,255,255,.05);

            border-radius: 100px;

            padding: 9px 14px;

            font-size: 12px;

            font-weight: 700;

            transition: .25s ease;

        }


        .rk-logout:hover {

            background: rgba(255,255,255,.12);

        }


        .rk-menu-button {

            display: none;

            width: 44px;

            height: 44px;

            border-radius: 50%;

            border: 1px solid rgba(255,255,255,.2);

            background: rgba(255,255,255,.08);

            align-items: center;

            justify-content: center;

            flex-direction: column;

            gap: 6px;

        }


        .rk-menu-button span {

            display: block;

            width: 17px;

            height: 1.5px;

            background: white;

            transition: .3s ease;

        }


        .rk-menu-button.open span:first-child {

            transform: translateY(3.75px) rotate(45deg);

        }


        .rk-menu-button.open span:last-child {

            transform: translateY(-3.75px) rotate(-45deg);

        }


        /* MOBILE NAV */

        .rk-mobile-menu {

            position: fixed;

            inset: 0;

            z-index: -1;

            background:

                radial-gradient(
                    circle at 80% 15%,
                    rgba(74,222,128,.10),
                    transparent 30%
                ),

                #07110c;

            padding: 110px 25px 35px;

            overflow-y: auto;

            opacity: 0;

            visibility: hidden;

            transform: translateY(-15px);

            transition: .35s ease;

        }


        .rk-mobile-menu.open {

            opacity: 1;

            visibility: visible;

            transform: translateY(0);

        }


        .rk-mobile-menu-inner {

            max-width: 600px;

            margin: auto;

        }


        .rk-mobile-menu-label {

            color: rgba(255,255,255,.35);

            font-size: 10px;

            letter-spacing: 4px;

            margin-bottom: 18px;

        }


        .rk-mobile-link {

            display: flex;

            align-items: center;

            gap: 18px;

            color: white;

            padding: 18px 0;

            border-bottom: 1px solid rgba(255,255,255,.08);

        }


        .rk-mobile-link span {

            color: var(--rk-green-light);

            font-size: 10px;

            width: 22px;

        }


        .rk-mobile-link strong {

            flex: 1;

            font-size: 22px;

            letter-spacing: -1px;

        }


        .rk-mobile-link i {

            color: rgba(255,255,255,.35);

        }


        .rk-mobile-auth {

            padding-top: 28px;

        }


        .rk-mobile-user {

            display: flex;

            align-items: center;

            gap: 12px;

            color: white;

        }


        .rk-mobile-user small {

            display: block;

            color: rgba(255,255,255,.4);

            font-size: 10px;

        }


        .rk-mobile-user strong {

            display: block;

            font-size: 14px;

        }


        .rk-mobile-logout {

            margin-top: 18px;

            width: 100%;

            border: 1px solid rgba(255,255,255,.12);

            background: rgba(255,255,255,.06);

            color: white;

            border-radius: 12px;

            padding: 13px;

            font-weight: 700;

        }


        .rk-mobile-buttons {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 10px;

        }


        .rk-mobile-login,
        .rk-mobile-register {

            display: flex;

            justify-content: center;

            align-items: center;

            gap: 7px;

            border-radius: 12px;

            padding: 14px;

            font-weight: 700;

        }


        .rk-mobile-login {

            color: white;

            border: 1px solid rgba(255,255,255,.15);

        }


        .rk-mobile-register {

            color: #06100b;

            background: var(--rk-green-light);

        }


        .rk-hero {

            position: relative;

            min-height: 820px;

            display: flex;

            align-items: center;

            overflow: hidden;

            background: #07110c;

            isolation: isolate;

        }


        .rk-hero-background {

            position: absolute;

            inset: 0;

            z-index: -3;

            background-image:

                linear-gradient(
                    90deg,
                    rgba(5,15,10,.96) 0%,
                    rgba(5,15,10,.84) 34%,
                    rgba(5,15,10,.38) 65%,
                    rgba(5,15,10,.18) 100%
                ),

                url('{{ asset('images/banners/hero-jalan-palem.jpg') }}');

            background-size: cover;

            background-position: center;

            transform: scale(1.04);

            animation: rkHeroZoom 14s ease-in-out infinite alternate;

        }


        @keyframes rkHeroZoom {

            from {
                transform: scale(1.04);
            }

            to {
                transform: scale(1.10);
            }

        }


        .rk-hero::before {

            content: '';

            position: absolute;

            inset: 0;

            z-index: -2;

            background:

                radial-gradient(
                    circle at 75% 35%,
                    rgba(74,222,128,.12),
                    transparent 25%
                ),

                linear-gradient(
                    180deg,
                    rgba(7,17,12,.2),
                    transparent 50%,
                    rgba(7,17,12,.55)
                );

        }


        .rk-noise {

            position: absolute;

            inset: 0;

            z-index: -1;

            opacity: .08;

            background-image:
                radial-gradient(
                    rgba(255,255,255,.8) .6px,
                    transparent .6px
                );

            background-size: 5px 5px;

            pointer-events: none;

        }


        .rk-hero-content {

            position: relative;

            z-index: 4;

            width: 100%;

            padding-top: 90px;

            padding-bottom: 100px;

        }


        .rk-hero-copy {

            max-width: 730px;

        }


        .rk-eyebrow {

            display: inline-flex;

            align-items: center;

            gap: 9px;

            color: rgba(255,255,255,.85);

            background: rgba(255,255,255,.08);

            border: 1px solid rgba(255,255,255,.15);

            backdrop-filter: blur(12px);

            padding: 9px 14px;

            border-radius: 100px;

            font-size: 12px;

            font-weight: 600;

            margin-bottom: 25px;

            animation: rkFadeUp .8s ease both;

        }


        .rk-eyebrow i {

            color: var(--rk-green-light);

        }


        .rk-hero-title {

            color: white;

            font-size: clamp(50px, 7vw, 91px);

            font-weight: 800;

            line-height: .99;

            letter-spacing: -5px;

            animation: rkFadeUp .9s .1s ease both;

        }


        .rk-hero-title span {

            color: var(--rk-green-light);

            display: block;

        }


        .rk-hero-description {

            max-width: 610px;

            margin-top: 25px;

            color: rgba(255,255,255,.70);

            font-size: 17px;

            line-height: 1.8;

            animation: rkFadeUp .9s .2s ease both;

        }


        .rk-hero-buttons {

            display: flex;

            flex-wrap: wrap;

            gap: 12px;

            margin-top: 31px;

            animation: rkFadeUp .9s .3s ease both;

        }


        .rk-btn-primary {

            display: inline-flex;

            align-items: center;

            gap: 10px;

            padding: 15px 22px;

            border-radius: 12px;

            background: var(--rk-green);

            color: white;

            font-weight: 800;

            transition: .3s ease;

            box-shadow: 0 12px 30px rgba(22,163,74,.18);

        }


        .rk-btn-primary:hover {

            color: white;

            background: var(--rk-green-light);

            color: #06100b;

            transform: translateY(-3px);

            box-shadow: 0 18px 40px rgba(74,222,128,.22);

        }


        .rk-btn-outline {

            display: inline-flex;

            align-items: center;

            gap: 10px;

            padding: 15px 22px;

            border-radius: 12px;

            background: rgba(255,255,255,.07);

            border: 1px solid rgba(255,255,255,.2);

            color: white;

            font-weight: 700;

            backdrop-filter: blur(10px);

            transition: .3s ease;

        }


        .rk-btn-outline:hover {

            background: white;

            color: var(--rk-black);

            transform: translateY(-3px);

        }


        .rk-scroll-indicator {

            position: absolute;

            bottom: 35px;

            left: 50%;

            transform: translateX(-50%);

            display: flex;

            align-items: center;

            gap: 10px;

            color: rgba(255,255,255,.4);

            font-size: 9px;

            letter-spacing: 3px;

            text-transform: uppercase;

        }


        .rk-scroll-line {

            width: 42px;

            height: 1px;

            background: rgba(255,255,255,.3);

        }


        @keyframes rkFadeUp {

            from {

                opacity: 0;

                transform: translateY(25px);

            }

            to {

                opacity: 1;

                transform: translateY(0);

            }

        }


        .rk-banner-carousel {

            position: absolute;

            inset: 0;

            z-index: 1;

        }


        .rk-banner-carousel .carousel-inner,
        .rk-banner-carousel .carousel-item {

            height: 100%;

        }


        .rk-banner-slide {

            position: relative;

            height: 100%;

            background-size: cover;

            background-position: center;

        }


        .rk-banner-slide::after {

            content: '';

            position: absolute;

            inset: 0;

            background:

                linear-gradient(
                    90deg,
                    rgba(5,15,10,.97) 0%,
                    rgba(5,15,10,.85) 35%,
                    rgba(5,15,10,.28) 75%,
                    rgba(5,15,10,.1) 100%
                );

        }


        .rk-banner-content {

            position: absolute;

            inset: 0;

            display: flex;

            align-items: center;

            z-index: 2;

        }


        .rk-banner-content-inner {

            width: 100%;

            padding-top: 80px;

        }


        .rk-banner-content h2 {

            max-width: 720px;

            color: white;

            font-size: clamp(42px, 6vw, 80px);

            font-weight: 800;

            line-height: 1;

            letter-spacing: -4px;

        }


        .rk-banner-content p {

            max-width: 570px;

            color: rgba(255,255,255,.72);

            margin-top: 20px;

            line-height: 1.7;

        }


        .rk-banner-badge {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 8px 13px;

            border-radius: 100px;

            background: rgba(74,222,128,.12);

            border: 1px solid rgba(74,222,128,.25);

            color: var(--rk-green-light);

            font-size: 11px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: 1px;

            margin-bottom: 20px;

        }


        .rk-carousel-arrow {

            width: 48px !important;

            height: 48px;

            top: auto !important;

            bottom: 45px !important;

            opacity: 1 !important;

            border-radius: 50%;

            background: rgba(255,255,255,.09);

            border: 1px solid rgba(255,255,255,.15);

            backdrop-filter: blur(10px);

        }


        .rk-banner-carousel .carousel-control-prev {

            left: auto;

            right: 125px;

        }


        .rk-banner-carousel .carousel-control-next {

            right: 65px;

        }


        .rk-banner-carousel .carousel-indicators {

            left: auto;

            right: 65px;

            bottom: 105px;

            width: auto;

            margin: 0;

            justify-content: flex-end;

        }


        .rk-banner-carousel .carousel-indicators button {

            width: 7px;

            height: 7px;

            border: none;

            border-radius: 100px;

            margin: 0 4px;

            opacity: .35;

        }


        .rk-banner-carousel .carousel-indicators .active {

            width: 28px;

            opacity: 1;

        }


        .rk-search-wrap {

            position: relative;

            z-index: 20;

            margin-top: -72px;

        }


        .rk-search-card {

            position: relative;

            background: rgba(255,255,255,.96);

            border: 1px solid rgba(255,255,255,.8);

            border-radius: 22px;

            padding: 12px;

            box-shadow:
                0 30px 80px rgba(0,0,0,.14),
                0 8px 25px rgba(0,0,0,.06);

            backdrop-filter: blur(20px);

        }


        .rk-search-inner {

            display: grid;

            grid-template-columns:
                1.15fr
                1fr
                1fr
                .9fr;

            gap: 7px;

        }


        .rk-search-field {

            position: relative;

            padding: 13px 16px;

            border-radius: 14px;

            background: #f5f7f6;

            border: 1px solid transparent;

            transition: .25s ease;

        }


        .rk-search-field:focus-within {

            background: white;

            border-color: rgba(22,163,74,.35);

            box-shadow: 0 0 0 4px rgba(22,163,74,.06);

        }


        .rk-search-label {

            display: block;

            color: #849087;

            font-size: 10px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: 1px;

            margin-bottom: 5px;

        }


        .rk-search-input {

            width: 100%;

            border: 0;

            outline: 0;

            background: transparent;

            color: var(--rk-text);

            font-size: 13px;

            font-weight: 700;

        }


        .rk-search-input option {

            color: var(--rk-text);

        }


        .rk-search-button {

            width: 100%;

            min-height: 67px;

            border: 0;

            border-radius: 14px;

            background: var(--rk-green);

            color: white;

            font-size: 13px;

            font-weight: 800;

            transition: .3s ease;

        }


        .rk-search-button:hover {

            background: var(--rk-green-dark);

            transform: translateY(-2px);

        }


        .rk-search-button:disabled {

            opacity: .7;

            cursor: wait;

        }


        .rk-section {

            padding: 110px 0;

        }


        .rk-section-soft {

            background: var(--rk-bg);

        }


        .rk-section-head {

            margin-bottom: 50px;

        }


        .rk-kicker {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            color: var(--rk-green);

            font-size: 10px;

            font-weight: 800;

            letter-spacing: 2px;

            text-transform: uppercase;

            margin-bottom: 12px;

        }


        .rk-kicker::before {

            content: '';

            width: 22px;

            height: 2px;

            background: var(--rk-green);

        }


        .rk-section-title {

            color: var(--rk-text);

            font-size: clamp(34px, 4vw, 52px);

            font-weight: 800;

            line-height: 1.05;

            letter-spacing: -2.5px;

        }


        .rk-section-description {

            color: var(--rk-muted);

            max-width: 600px;

            margin-top: 15px;

            line-height: 1.8;

            font-size: 14px;

        }


        .rk-center {

            text-align: center;

        }


        .rk-center .rk-section-description {

            margin-left: auto;

            margin-right: auto;

        }


        .rk-brand-card {

            height: 100%;

            min-height: 150px;

            background: white;

            border: 1px solid var(--rk-border);

            border-radius: 18px;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            padding: 20px;

            transition: .3s ease;

        }


        .rk-brand-card:hover {

            transform: translateY(-8px);

            border-color: rgba(22,163,74,.3);

            box-shadow: 0 20px 45px rgba(0,0,0,.07);

        }


        .rk-brand-logo {

            width: 58px;

            height: 58px;

            object-fit: contain;

            margin-bottom: 13px;

        }


        .rk-brand-name {

            font-size: 13px;

            font-weight: 800;

        }


        .rk-about-visual {

            position: relative;

            min-height: 570px;

            border-radius: 28px;

            overflow: hidden;

            background:

                linear-gradient(
                    145deg,
                    #10261a,
                    #06100b
                );

        }


        .rk-about-visual::before {

            content: '';

            position: absolute;

            inset: 0;

            background:
                radial-gradient(
                    circle at 65% 30%,
                    rgba(74,222,128,.22),
                    transparent 28%
                );

        }


        .rk-about-glow {

            position: absolute;

            width: 330px;

            height: 330px;

            border-radius: 50%;

            right: -90px;

            bottom: -100px;

            background: rgba(74,222,128,.12);

            filter: blur(20px);

        }


        .rk-about-number {

            position: absolute;

            top: 40px;

            left: 40px;

            color: rgba(255,255,255,.06);

            font-size: 180px;

            font-weight: 800;

            line-height: .8;

        }


        .rk-about-copy {

            position: absolute;

            left: 40px;

            right: 40px;

            bottom: 40px;

            color: white;

            z-index: 2;

        }


        .rk-about-copy small {

            color: var(--rk-green-light);

            text-transform: uppercase;

            letter-spacing: 2px;

            font-size: 10px;

            font-weight: 800;

        }


        .rk-about-copy h3 {

            margin-top: 10px;

            font-size: 35px;

            letter-spacing: -1.5px;

            font-weight: 800;

        }


        .rk-about-copy p {

            color: rgba(255,255,255,.55);

            line-height: 1.7;

            font-size: 13px;

            max-width: 470px;

            margin-top: 12px;

        }


        .rk-feature {

            position: relative;

            padding: 27px;

            border-radius: 18px;

            background: white;

            border: 1px solid var(--rk-border);

            height: 100%;

            transition: .3s ease;

        }


        .rk-feature:hover {

            transform: translateY(-5px);

            box-shadow: 0 18px 40px rgba(0,0,0,.06);

        }


        .rk-feature-number {

            position: absolute;

            top: 20px;

            right: 20px;

            color: #dfe7e2;

            font-size: 11px;

            font-weight: 800;

        }


        .rk-feature-icon {

            width: 50px;

            height: 50px;

            display: flex;

            align-items: center;

            justify-content: center;

            background: #eaf8ef;

            color: var(--rk-green);

            border-radius: 14px;

            font-size: 22px;

            margin-bottom: 20px;

        }


        .rk-feature h4 {

            font-size: 16px;

            font-weight: 800;

        }


        .rk-feature p {

            margin-top: 9px;

            color: var(--rk-muted);

            line-height: 1.7;

            font-size: 12px;

        }


        .rk-steps {

            position: relative;

        }


        .rk-steps::before {

            content: '';

            position: absolute;

            top: 31px;

            left: 12%;

            right: 12%;

            height: 1px;

            background: #dce4df;

        }


        .rk-step {

            position: relative;

            z-index: 2;

            text-align: center;

        }


        .rk-step-circle {

            width: 64px;

            height: 64px;

            margin: 0 auto 23px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background: white;

            border: 1px solid #dce4df;

            color: var(--rk-green);

            font-size: 12px;

            font-weight: 800;

            box-shadow: 0 0 0 9px var(--rk-bg);

        }


        .rk-step:hover .rk-step-circle {

            background: var(--rk-green);

            color: white;

            border-color: var(--rk-green);

        }


        .rk-step h4 {

            font-size: 15px;

            font-weight: 800;

        }


        .rk-step p {

            max-width: 230px;

            margin: 9px auto 0;

            color: var(--rk-muted);

            line-height: 1.7;

            font-size: 12px;

        }


        .rk-rating-card {

            position: relative;

            height: 100%;

            background: white;

            border: 1px solid var(--rk-border);

            border-radius: 20px;

            padding: 27px;

            transition: .3s ease;

        }


        .rk-rating-card:hover {

            transform: translateY(-6px);

            box-shadow: 0 20px 45px rgba(0,0,0,.07);

        }


        .rk-stars {

            color: #f59e0b;

            font-size: 12px;

            letter-spacing: 2px;

        }


        .rk-rating-quote {

            margin: 20px 0 25px;

            color: #4e5a53;

            line-height: 1.8;

            font-size: 13px;

        }


        .rk-rating-user {

            display: flex;

            align-items: center;

            gap: 11px;

        }


        .rk-rating-avatar {

            width: 43px;

            height: 43px;

            border-radius: 50%;

            object-fit: cover;

            background: #e9eeeb;

            display: flex;

            align-items: center;

            justify-content: center;

            color: var(--rk-green);

        }


        .rk-rating-name {

            font-size: 13px;

            font-weight: 800;

        }


        .rk-rating-car {

            color: var(--rk-muted);

            font-size: 10px;

            margin-top: 2px;

        }


        .rk-faq {

            max-width: 850px;

            margin: auto;

        }


        .rk-faq .accordion-item {

            border: 1px solid var(--rk-border);

            border-radius: 15px !important;

            overflow: hidden;

            margin-bottom: 10px;

            background: white;

        }


        .rk-faq .accordion-button {

            padding: 20px;

            background: white;

            color: var(--rk-text);

            font-size: 13px;

            font-weight: 800;

            box-shadow: none;

        }


        .rk-faq .accordion-button:not(.collapsed) {

            color: var(--rk-green);

            background: #f0f9f3;

            box-shadow: none;

        }


        .rk-faq .accordion-body {

            color: var(--rk-muted);

            font-size: 13px;

            line-height: 1.8;

            padding: 0 20px 20px;

        }


        .rk-cta {

            position: relative;

            overflow: hidden;

            border-radius: 28px;

            padding: 75px;

            background:

                radial-gradient(
                    circle at 85% 20%,
                    rgba(74,222,128,.18),
                    transparent 30%
                ),

                linear-gradient(
                    135deg,
                    #0d2517,
                    #06100b
                );

            color: white;

        }


        .rk-cta::after {

            content: 'RENTALKU';

            position: absolute;

            right: -20px;

            bottom: -55px;

            color: rgba(255,255,255,.025);

            font-size: 130px;

            font-weight: 800;

            letter-spacing: -7px;

        }


        .rk-cta h2 {

            position: relative;

            z-index: 2;

            font-size: clamp(35px, 4vw, 55px);

            line-height: 1;

            letter-spacing: -2px;

            font-weight: 800;

        }


        .rk-cta p {

            position: relative;

            z-index: 2;

            color: rgba(255,255,255,.55);

            max-width: 570px;

            margin-top: 16px;

            line-height: 1.7;

            font-size: 13px;

        }


        .rk-cta-button {

            position: relative;

            z-index: 2;

            display: inline-flex;

            align-items: center;

            gap: 10px;

            background: var(--rk-green-light);

            color: #06100b;

            border-radius: 12px;

            padding: 15px 20px;

            font-size: 13px;

            font-weight: 800;

            transition: .3s ease;

        }


        .rk-cta-button:hover {

            color: #06100b;

            transform: translateY(-3px);

            box-shadow: 0 15px 35px rgba(74,222,128,.18);

        }


        .rk-reveal {

            opacity: 0;

            transform: translateY(25px);

            transition:
                opacity .8s ease,
                transform .8s ease;

        }


        .rk-reveal.show {

            opacity: 1;

            transform: translateY(0);

        }


        @media(max-width: 1100px) {

            .rk-desktop-menu {
                gap: 0;
            }

            .rk-nav-link {
                padding-inline: 7px;
                font-size: 11px;
            }

            .rk-navbar-actions {
                gap: 6px;
            }

        }


        @media(max-width: 991px) {

            .rk-desktop-menu,
            .rk-navbar-actions {

                display: none;

            }


            .rk-menu-button {

                display: flex;

            }


            .rk-hero {

                min-height: 730px;

            }


            .rk-search-inner {

                grid-template-columns: 1fr 1fr;

            }


            .rk-search-button {

                min-height: 58px;

            }


            .rk-about-visual {

                min-height: 430px;

            }


            .rk-steps::before {

                display: none;

            }

        }


        @media(max-width: 767px) {

            .rk-navbar {

                padding: 15px 0;

            }


            .rk-logo {

                font-size: 24px;

            }


            .rk-hero {

                min-height: 720px;

            }


            .rk-hero-background {

                background-position: 62% center;

            }


            .rk-hero-title {

                font-size: clamp(46px, 14vw, 68px);

                letter-spacing: -3px;

            }


            .rk-hero-description {

                font-size: 14px;

            }


            .rk-hero-content {

                padding-top: 95px;

                padding-bottom: 80px;

            }


            .rk-hero-buttons {

                display: grid;

                grid-template-columns: 1fr;

            }


            .rk-btn-primary,
            .rk-btn-outline {

                justify-content: center;

            }


            .rk-search-wrap {

                margin-top: -35px;

            }


            .rk-search-card {

                padding: 9px;

                border-radius: 18px;

            }


            .rk-search-inner {

                grid-template-columns: 1fr;

            }


            .rk-search-field {

                padding: 12px 14px;

            }


            .rk-section {

                padding: 75px 0;

            }


            .rk-section-title {

                letter-spacing: -1.7px;

            }


            .rk-about-visual {

                min-height: 390px;

            }


            .rk-about-number {

                font-size: 120px;

            }


            .rk-about-copy {

                left: 25px;

                right: 25px;

                bottom: 25px;

            }


            .rk-about-copy h3 {

                font-size: 28px;

            }


            .rk-cta {

                padding: 42px 27px;

                border-radius: 22px;

            }


            .rk-cta::after {

                font-size: 75px;

            }


            .rk-banner-carousel .carousel-control-prev {

                right: 75px;

                bottom: 25px !important;

            }


            .rk-banner-carousel .carousel-control-next {

                right: 20px;

                bottom: 25px !important;

            }


            .rk-banner-carousel .carousel-indicators {

                right: 20px;

                bottom: 82px;

            }

        }


        @media(max-width: 480px) {

            .rk-mobile-buttons {

                grid-template-columns: 1fr;

            }


            .rk-scroll-indicator {

                display: none;

            }


            .rk-hero-title {

                font-size: 45px;

            }

        }


        @media(prefers-reduced-motion: reduce) {

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

    @stack('styles')

</head>


<body>

    <div class="rk-loader" id="rkLoader">

        <div class="rk-loader-content">

            <div class="rk-loader-logo">
                Rental<span>ku</span><b>.</b>
            </div>

            <div class="rk-loader-road"></div>

            <div class="rk-loader-text">
                Menyiapkan perjalananmu
            </div>

        </div>

    </div>


    @include('layouts.partials.navbar')


    @yield('content')


    @include('layouts.partials.footer')


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>


    <script>

        document.addEventListener('DOMContentLoaded', function () {


            const loader = document.getElementById('rkLoader');

            if (loader) {

                window.addEventListener('load', function () {

                    setTimeout(function () {

                        loader.classList.add('hide');

                    }, 600);

                });

            }


            const navbar = document.getElementById('rkNavbar');

            function updateNavbar() {

                if (!navbar) return;

                if (window.scrollY > 40) {

                    navbar.classList.add('scrolled');

                } else {

                    navbar.classList.remove('scrolled');

                }

            }


            updateNavbar();

            window.addEventListener(
                'scroll',
                updateNavbar,
                { passive: true }
            );


            const menuButton =
                document.getElementById('rkMenuButton');

            const mobileMenu =
                document.getElementById('rkMobileMenu');


            if (menuButton && mobileMenu) {

                menuButton.addEventListener('click', function () {

                    const isOpen =
                        mobileMenu.classList.toggle('open');

                    menuButton.classList.toggle(
                        'open',
                        isOpen
                    );

                    menuButton.setAttribute(
                        'aria-expanded',
                        isOpen ? 'true' : 'false'
                    );

                    document.body.style.overflow =
                        isOpen ? 'hidden' : '';

                });


                mobileMenu
                    .querySelectorAll('a')
                    .forEach(function (link) {

                        link.addEventListener(
                            'click',
                            function () {

                                mobileMenu.classList.remove('open');

                                menuButton.classList.remove('open');

                                menuButton.setAttribute(
                                    'aria-expanded',
                                    'false'
                                );

                                document.body.style.overflow = '';

                            }
                        );

                    });


                document.addEventListener(
                    'keydown',
                    function (event) {

                        if (
                            event.key === 'Escape' &&
                            mobileMenu.classList.contains('open')
                        ) {

                            mobileMenu.classList.remove('open');

                            menuButton.classList.remove('open');

                            menuButton.setAttribute(
                                'aria-expanded',
                                'false'
                            );

                            document.body.style.overflow = '';

                        }

                    }
                );

            }


            const revealElements =
                document.querySelectorAll('.rk-reveal');


            if ('IntersectionObserver' in window) {

                const observer =
                    new IntersectionObserver(
                        function (entries) {

                            entries.forEach(function (entry) {

                                if (entry.isIntersecting) {

                                    entry.target.classList.add('show');

                                    observer.unobserve(
                                        entry.target
                                    );

                                }

                            });

                        },
                        {
                            threshold: .12
                        }
                    );


                revealElements.forEach(function (element) {

                    observer.observe(element);

                });

            } else {

                revealElements.forEach(function (element) {

                    element.classList.add('show');

                });

            }


        });

    </script>


    @stack('scripts')

</body>

</html>