@extends('layouts.landing')

@section('title', 'Rentalku - Rental Mobil Terpercaya')

@section('content')

<style>

/* ============================================================
   RENTALKU PREMIUM LANDING
   ============================================================ */

:root {
    --rk-green: #39f58a;
    --rk-green-dark: #16a85a;
    --rk-green-soft: #9dffc4;
    --rk-black: #050907;
    --rk-dark: #08100c;
    --rk-dark-2: #0d1712;
    --rk-card: rgba(255,255,255,.055);
    --rk-border: rgba(255,255,255,.10);
    --rk-muted: #91a198;
    --rk-white: #f5fff9;
}


/* ============================================================
   GLOBAL
   ============================================================ */

body {
    background: var(--rk-black);
    color: var(--rk-white);
}

html {
    scroll-behavior: smooth;
}

.rk-section {
    position: relative;
    padding: 110px 0;
    overflow: hidden;
}

.rk-section-soft {
    background:
        radial-gradient(
            circle at 10% 20%,
            rgba(57,245,138,.07),
            transparent 30%
        ),
        #08100c;
}

.rk-center {
    text-align: center;
}


/* ============================================================
   HERO
   ============================================================ */

.rk-hero {
    position: relative;
    min-height: 760px;
    overflow: hidden;
    background:
        radial-gradient(
            circle at 75% 25%,
            rgba(57,245,138,.16),
            transparent 30%
        ),
        radial-gradient(
            circle at 20% 80%,
            rgba(22,168,90,.10),
            transparent 30%
        ),
        #050907;
    isolation: isolate;
}


/* Background glow */

.rk-hero::before {
    content: "";
    position: absolute;
    width: 700px;
    height: 700px;
    right: -250px;
    top: -250px;

    background: rgba(57,245,138,.13);

    filter: blur(100px);

    border-radius: 50%;

    pointer-events: none;
}


.rk-hero::after {
    content: "";
    position: absolute;
    width: 450px;
    height: 450px;
    left: -250px;
    bottom: -200px;

    background: rgba(22,168,90,.08);

    filter: blur(90px);

    border-radius: 50%;

    pointer-events: none;
}


.rk-hero-background {
    position: absolute;
    inset: 0;

    background-image:
        linear-gradient(
            rgba(255,255,255,.025) 1px,
            transparent 1px
        ),
        linear-gradient(
            90deg,
            rgba(255,255,255,.025) 1px,
            transparent 1px
        );

    background-size: 70px 70px;

    mask-image: linear-gradient(
        to bottom,
        black,
        transparent 90%
    );

    pointer-events: none;
}


.rk-noise {
    position: absolute;
    inset: 0;

    opacity: .04;

    background-image:
        url("data:image/svg+xml,%3Csvg viewBox='0 0 180 180' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.7'/%3E%3C/svg%3E");

    pointer-events: none;
}


/* ============================================================
   HERO CONTENT
   ============================================================ */

.rk-hero-content {
    position: relative;
    z-index: 5;

    min-height: 760px;

    display: flex;
    align-items: center;
}


.rk-hero-copy {
    max-width: 850px;

    padding-top: 50px;

    animation:
        rkHeroIn .9s ease both;
}


.rk-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 9px;

    padding: 9px 15px;

    border-radius: 999px;

    border: 1px solid rgba(57,245,138,.25);

    background: rgba(57,245,138,.07);

    color: var(--rk-green);

    font-size: 13px;
    font-weight: 700;

    letter-spacing: .04em;

    box-shadow:
        0 0 25px rgba(57,245,138,.08);
}


.rk-eyebrow i {
    font-size: 15px;
}


.rk-hero-title {
    margin-top: 25px;
    margin-bottom: 25px;

    max-width: 850px;

    font-size: clamp(48px, 7vw, 94px);

    line-height: .98;

    letter-spacing: -4px;

    font-weight: 800;

    color: #f5fff9;
}


.rk-hero-title span {
    display: block;

    color: var(--rk-green);

    text-shadow:
        0 0 25px rgba(57,245,138,.18);
}


.rk-hero-description {
    max-width: 650px;

    color: #9eaea6;

    font-size: 17px;

    line-height: 1.8;
}


/* ============================================================
   BUTTON
   ============================================================ */

.rk-hero-buttons {
    display: flex;
    flex-wrap: wrap;

    gap: 14px;

    margin-top: 32px;
}


.rk-btn-primary,
.rk-btn-outline,
.rk-cta-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 10px;

    min-height: 54px;

    padding: 0 24px;

    border-radius: 14px;

    text-decoration: none;

    font-weight: 700;

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        background .25s ease;
}


.rk-btn-primary {
    color: #031108;

    background: var(--rk-green);

    box-shadow:
        0 0 0 rgba(57,245,138,0),
        0 12px 35px rgba(57,245,138,.20);
}


.rk-btn-primary:hover {
    color: #031108;

    transform: translateY(-4px);

    box-shadow:
        0 0 30px rgba(57,245,138,.28),
        0 18px 45px rgba(57,245,138,.20);
}


.rk-btn-outline {
    color: #f5fff9;

    border: 1px solid rgba(255,255,255,.15);

    background: rgba(255,255,255,.045);

    backdrop-filter: blur(15px);
}


.rk-btn-outline:hover {
    color: var(--rk-green);

    border-color: rgba(57,245,138,.35);

    background: rgba(57,245,138,.07);

    transform: translateY(-4px);
}


/* ============================================================
   HERO CAROUSEL
   ============================================================ */

.rk-banner-carousel,
.rk-banner-slide {
    position: absolute;
    inset: 0;

    width: 100%;
    height: 100%;
}


.rk-banner-slide {
    background-size: cover;
    background-position: center;

    isolation: isolate;
}


.rk-banner-slide::before {
    content: "";

    position: absolute;
    inset: 0;

    background:
        linear-gradient(
            90deg,
            rgba(3,8,5,.95) 0%,
            rgba(3,8,5,.70) 45%,
            rgba(3,8,5,.20) 100%
        );

    z-index: -1;
}


.rk-banner-slide::after {
    content: "";

    position: absolute;
    inset: 0;

    background:
        radial-gradient(
            circle at 75% 50%,
            rgba(57,245,138,.10),
            transparent 35%
        );

    z-index: -1;
}


.rk-banner-content {
    height: 100%;

    display: flex;
    align-items: center;
}


.rk-banner-content-inner {
    max-width: 700px;

    padding-top: 60px;
}


.rk-banner-badge {
    display: inline-flex;

    align-items: center;
    gap: 8px;

    padding: 9px 15px;

    border-radius: 999px;

    background: rgba(57,245,138,.10);

    border: 1px solid rgba(57,245,138,.25);

    color: var(--rk-green);

    font-size: 13px;
    font-weight: 700;
}


.rk-banner-content h2 {
    margin-top: 22px;

    font-size: clamp(42px, 6vw, 78px);

    line-height: 1;

    font-weight: 800;

    letter-spacing: -3px;
}


.rk-banner-content p {
    max-width: 620px;

    color: #b5c3bc;

    font-size: 17px;

    line-height: 1.7;

    margin-top: 20px;
}


.rk-carousel-arrow {
    width: 52px;
    height: 52px;

    top: auto;
    bottom: 80px;

    opacity: 1;

    border: 1px solid rgba(255,255,255,.12);

    background: rgba(255,255,255,.06);

    backdrop-filter: blur(12px);

    border-radius: 50%;
}


.rk-carousel-arrow:hover {
    background: rgba(57,245,138,.12);

    color: var(--rk-green);
}


.carousel-control-prev.rk-carousel-arrow {
    left: auto;
    right: 145px;
}


.carousel-control-next.rk-carousel-arrow {
    right: 80px;
}


.rk-hero .carousel-indicators {
    bottom: 30px;
}


.rk-hero .carousel-indicators button {
    width: 35px;
    height: 3px;

    border: 0;

    border-radius: 10px;

    background: rgba(255,255,255,.25);
}


.rk-hero .carousel-indicators .active {
    background: var(--rk-green);

    box-shadow:
        0 0 12px rgba(57,245,138,.5);
}


/* ============================================================
   SCROLL INDICATOR
   ============================================================ */

.rk-scroll-indicator {
    position: absolute;

    z-index: 8;

    left: 50%;
    bottom: 25px;

    transform: translateX(-50%);

    color: #718078;

    font-size: 11px;

    letter-spacing: .12em;

    text-transform: uppercase;

    display: flex;
    align-items: center;
    gap: 10px;
}


.rk-scroll-line {
    width: 35px;
    height: 1px;

    background: var(--rk-green);

    box-shadow:
        0 0 10px rgba(57,245,138,.5);
}


/* ============================================================
   SEARCH
   ============================================================ */

.rk-search-wrap {
    position: relative;

    z-index: 20;

    margin-top: -55px;
}


.rk-search-card {
    padding: 10px;

    border-radius: 22px;

    border: 1px solid rgba(255,255,255,.10);

    background:
        linear-gradient(
            135deg,
            rgba(255,255,255,.09),
            rgba(255,255,255,.035)
        );

    box-shadow:
        0 25px 70px rgba(0,0,0,.35);

    backdrop-filter: blur(25px);
}


.rk-search-inner {
    display: grid;

    grid-template-columns:
        1.3fr
        1fr
        1fr
        auto;

    gap: 8px;

    padding: 9px;

    border-radius: 17px;

    background: #101a15;
}


.rk-search-field {
    padding: 10px 15px;

    border-radius: 13px;

    background: rgba(255,255,255,.035);

    border: 1px solid rgba(255,255,255,.05);
}


.rk-search-label {
    display: block;

    margin-bottom: 5px;

    color: #7e8e86;

    font-size: 11px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .08em;
}


.rk-search-input {
    width: 100%;

    border: 0;
    outline: 0;

    background: transparent;

    color: #f5fff9;

    font-size: 14px;

    font-weight: 600;
}


.rk-search-input option {
    color: #111;
    background: white;
}


.rk-search-input::-webkit-calendar-picker-indicator {
    filter: invert(1);
    opacity: .7;
}


.rk-search-button {
    height: 100%;

    min-width: 170px;

    border: 0;

    border-radius: 13px;

    background: var(--rk-green);

    color: #031108;

    font-weight: 800;

    transition: .25s;
}


.rk-search-button:hover {
    background: #62ffa1;

    box-shadow:
        0 0 30px rgba(57,245,138,.25);

    transform: translateY(-2px);
}


/* ============================================================
   SEARCH RESULT FIX
   INI BAGIAN PENTING UNTUK FOTO MOBIL
   ============================================================ */

#hasil-pencarian {
    position: relative;

    width: 100%;
}


/*
|--------------------------------------------------------------------------
| Jangan biarkan gambar mobil menjadi sebesar viewport.
|--------------------------------------------------------------------------
*/

#hasil-pencarian img {
    max-width: 100% !important;

    object-fit: cover;

    display: block;
}


/*
|--------------------------------------------------------------------------
| Jika hasil pencarian menggunakan card mobil,
| gambar dikunci supaya tidak membesar.
|--------------------------------------------------------------------------
*/

#hasil-pencarian .card-img-top {
    width: 100% !important;

    height: 220px !important;

    max-height: 220px !important;

    object-fit: cover !important;

    display: block;

    border-radius: 0 !important;
}


/*
|--------------------------------------------------------------------------
| Beberapa kemungkinan class gambar dari partial lama.
|--------------------------------------------------------------------------
*/

#hasil-pencarian .mobil-image,
#hasil-pencarian .car-image,
#hasil-pencarian .vehicle-image {
    width: 100% !important;

    height: 220px !important;

    max-height: 220px !important;

    object-fit: cover !important;
}


/*
|--------------------------------------------------------------------------
| Kalau gambar dibungkus container.
|--------------------------------------------------------------------------
*/

#hasil-pencarian .mobil-card,
#hasil-pencarian .car-card,
#hasil-pencarian .vehicle-card {
    overflow: hidden;

    position: relative;

    border-radius: 22px !important;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.075),
            rgba(255,255,255,.025)
        ) !important;

    border: 1px solid rgba(255,255,255,.09) !important;

    box-shadow:
        0 15px 45px rgba(0,0,0,.20);

    color: #f5fff9;

    transition:
        transform .3s ease,
        border-color .3s ease,
        box-shadow .3s ease;
}


#hasil-pencarian .mobil-card:hover,
#hasil-pencarian .car-card:hover,
#hasil-pencarian .vehicle-card:hover {
    transform: translateY(-7px);

    border-color: rgba(57,245,138,.35) !important;

    box-shadow:
        0 20px 60px rgba(0,0,0,.30),
        0 0 30px rgba(57,245,138,.07);
}


/*
|--------------------------------------------------------------------------
| Paksa body card hasil pencarian tetap terlihat di dark theme.
|--------------------------------------------------------------------------
*/

#hasil-pencarian .card-body {
    background:
        linear-gradient(
            145deg,
            #111b16,
            #0b120f
        ) !important;

    color: #f5fff9 !important;
}


#hasil-pencarian .card-title,
#hasil-pencarian h1,
#hasil-pencarian h2,
#hasil-pencarian h3,
#hasil-pencarian h4,
#hasil-pencarian h5,
#hasil-pencarian h6 {
    color: #f5fff9 !important;
}


#hasil-pencarian p,
#hasil-pencarian small,
#hasil-pencarian .text-muted {
    color: #9eaea6 !important;
}


#hasil-pencarian .text-success {
    color: var(--rk-green) !important;
}


/*
|--------------------------------------------------------------------------
| Kalau partial menggunakan img tanpa class sama sekali,
| tetap kita batasi supaya tidak meledak.
|--------------------------------------------------------------------------
*/

#hasil-pencarian .row img {
    max-height: 220px;
}


/* ============================================================
   SECTION HEADER
   ============================================================ */

.rk-section-head {
    margin-bottom: 55px;
}


.rk-kicker {
    display: inline-block;

    color: var(--rk-green);

    font-size: 12px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .16em;

    margin-bottom: 13px;
}


.rk-section-title {
    color: #f4fff8;

    font-size: clamp(34px, 4vw, 55px);

    line-height: 1.05;

    letter-spacing: -2px;

    font-weight: 800;

    margin-bottom: 16px;
}


.rk-section-description {
    max-width: 650px;

    margin: 0 auto;

    color: #819088;

    line-height: 1.8;

    font-size: 16px;
}


/* ============================================================
   BRAND
   ============================================================ */

.rk-brand-card {
    min-height: 155px;

    display: flex;
    flex-direction: column;

    align-items: center;
    justify-content: center;

    gap: 15px;

    padding: 22px;

    border-radius: 20px;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.055),
            rgba(255,255,255,.02)
        );

    border: 1px solid rgba(255,255,255,.08);

    transition: .3s;

    backdrop-filter: blur(12px);
}


.rk-brand-card:hover {
    transform: translateY(-8px);

    border-color: rgba(57,245,138,.30);

    box-shadow:
        0 20px 50px rgba(0,0,0,.25),
        0 0 30px rgba(57,245,138,.07);
}


.rk-brand-logo {
    width: 65px;
    height: 65px;

    object-fit: contain;

    border-radius: 50%;

    padding: 8px;

    background: white;
}


.rk-brand-name {
    color: #dce9e2;

    font-weight: 700;
}


/* ============================================================
   ABOUT VISUAL
   ============================================================ */

.rk-about-visual {
    position: relative;

    min-height: 480px;

    padding: 45px;

    border-radius: 32px;

    overflow: hidden;

    background:
        radial-gradient(
            circle at 70% 20%,
            rgba(57,245,138,.24),
            transparent 30%
        ),
        linear-gradient(
            145deg,
            #101b15,
            #06100b
        );

    border: 1px solid rgba(255,255,255,.09);

    box-shadow:
        0 25px 70px rgba(0,0,0,.3);
}


.rk-about-visual::before {
    content: "";

    position: absolute;

    width: 280px;
    height: 280px;

    right: -80px;
    top: -80px;

    border-radius: 50%;

    border: 1px solid rgba(57,245,138,.25);

    box-shadow:
        0 0 80px rgba(57,245,138,.12);
}


.rk-about-number {
    font-size: 100px;

    font-weight: 800;

    color: rgba(255,255,255,.035);

    line-height: 1;
}


.rk-about-glow {
    position: absolute;

    width: 180px;
    height: 180px;

    right: 70px;
    top: 110px;

    border-radius: 50%;

    background: var(--rk-green);

    filter: blur(100px);

    opacity: .16;
}


.rk-about-copy {
    position: absolute;

    left: 45px;
    right: 45px;
    bottom: 45px;
}


.rk-about-copy small {
    color: var(--rk-green);

    font-weight: 700;
}


.rk-about-copy h3 {
    margin-top: 12px;

    color: white;

    font-size: 34px;

    font-weight: 800;
}


.rk-about-copy p {
    color: #8c9b93;

    line-height: 1.8;

    margin: 0;
}


/* ============================================================
   FEATURES
   ============================================================ */

.rk-feature {
    position: relative;

    height: 100%;

    padding: 28px;

    border-radius: 22px;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.055),
            rgba(255,255,255,.02)
        );

    border: 1px solid rgba(255,255,255,.08);

    transition: .3s;
}


.rk-feature:hover {
    transform: translateY(-6px);

    border-color: rgba(57,245,138,.30);

    box-shadow:
        0 20px 50px rgba(0,0,0,.2);
}

/* ============================================================
   INFORMASI CABANG
============================================================ */

.rk-branch-card {
    height: 100%;
    padding: 28px;
    border-radius: 24px;
    background: linear-gradient(
        145deg,
        rgba(255, 255, 255, .06),
        rgba(255, 255, 255, .02)
    );
    border: 1px solid rgba(255, 255, 255, .08);
    transition: .3s ease;
}

.rk-branch-card:hover {
    transform: translateY(-7px);
    border-color: rgba(57, 245, 138, .35);
    box-shadow:
        0 20px 55px rgba(0, 0, 0, .25),
        0 0 25px rgba(57, 245, 138, .06);
}

.rk-branch-icon {
    width: 58px;
    height: 58px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 22px;
    border-radius: 17px;
    color: var(--rk-green);
    background: rgba(57, 245, 138, .08);
    border: 1px solid rgba(57, 245, 138, .15);
    font-size: 24px;
}

.rk-branch-name {
    color: #f5fff9;
    font-size: 20px;
    font-weight: 800;
    margin-bottom: 18px;
}

.rk-branch-info {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 14px;
    color: #9eaea6;
    font-size: 14px;
    line-height: 1.7;
}

.rk-branch-info i {
    color: var(--rk-green);
    font-size: 17px;
    margin-top: 3px;
}

.rk-branch-empty {
    padding: 35px;
    border-radius: 20px;
    text-align: center;
    color: #9eaea6;
    background: rgba(255, 255, 255, .035);
    border: 1px solid rgba(255, 255, 255, .08);
}
.rk-feature-number {
    position: absolute;

    top: 20px;
    right: 22px;

    color: rgba(255,255,255,.15);

    font-size: 12px;

    font-weight: 800;
}


.rk-feature-icon {
    width: 55px;
    height: 55px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 16px;

    color: var(--rk-green);

    background: rgba(57,245,138,.08);

    border: 1px solid rgba(57,245,138,.15);

    font-size: 23px;

    margin-bottom: 22px;

    box-shadow:
        0 0 25px rgba(57,245,138,.05);
}


.rk-feature h4 {
    color: #f5fff9;

    font-size: 18px;

    font-weight: 800;

    margin-bottom: 10px;
}


.rk-feature p {
    color: #84938b;

    font-size: 14px;

    line-height: 1.7;

    margin: 0;
}


/* ============================================================
   STEPS
   ============================================================ */

.rk-steps {
    position: relative;
}


.rk-steps::before {
    content: "";

    position: absolute;

    left: 12%;
    right: 12%;

    top: 39px;

    height: 1px;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(57,245,138,.35),
            transparent
        );
}


.rk-step {
    position: relative;

    height: 100%;

    padding: 35px 28px;

    text-align: center;

    border-radius: 24px;

    background:
        rgba(255,255,255,.035);

    border: 1px solid rgba(255,255,255,.07);

    transition: .3s;
}


.rk-step:hover {
    transform: translateY(-7px);

    border-color: rgba(57,245,138,.25);

    box-shadow:
        0 20px 45px rgba(0,0,0,.2);
}


.rk-step-circle {
    position: relative;
    z-index: 2;

    width: 78px;
    height: 78px;

    margin: 0 auto 25px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    color: #031108;

    background: var(--rk-green);

    font-size: 16px;

    font-weight: 900;

    box-shadow:
        0 0 35px rgba(57,245,138,.18);
}


.rk-step h4 {
    color: white;

    font-weight: 800;

    font-size: 18px;
}


.rk-step p {
    color: #84938b;

    line-height: 1.7;

    font-size: 14px;

    margin-bottom: 0;
}


/* ============================================================
   TESTIMONIAL
   ============================================================ */

.rk-rating-card {
    height: 100%;

    padding: 30px;

    border-radius: 24px;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.06),
            rgba(255,255,255,.02)
        );

    border: 1px solid rgba(255,255,255,.08);

    transition: .3s;
}


.rk-rating-card:hover {
    transform: translateY(-6px);

    border-color: rgba(57,245,138,.25);

    box-shadow:
        0 20px 55px rgba(0,0,0,.25);
}


.rk-stars {
    color: #ffd95a;

    letter-spacing: 2px;

    margin-bottom: 20px;
}


.rk-rating-quote {
    color: #c5d2cb;

    line-height: 1.8;

    min-height: 100px;
}


.rk-rating-user {
    display: flex;

    align-items: center;

    gap: 13px;

    margin-top: 25px;

    padding-top: 20px;

    border-top: 1px solid rgba(255,255,255,.07);
}


.rk-rating-avatar {
    width: 45px;
    height: 45px;

    border-radius: 50%;

    object-fit: cover;

    background: #18231d;

    display: flex;
    align-items: center;
    justify-content: center;

    color: var(--rk-green);
}


.rk-rating-name {
    color: white;

    font-weight: 700;
}


.rk-rating-car {
    color: #738078;

    font-size: 12px;

    margin-top: 3px;
}


/* ============================================================
   FAQ
   ============================================================ */

.rk-faq {
    max-width: 900px;

    margin: 0 auto;
}


.rk-faq .accordion-item {
    margin-bottom: 12px;

    overflow: hidden;

    border: 1px solid rgba(255,255,255,.08) !important;

    border-radius: 18px !important;

    background:
        rgba(255,255,255,.035) !important;
}


.rk-faq .accordion-button {
    padding: 23px 25px;

    background: transparent !important;

    color: #eefaf3 !important;

    box-shadow: none !important;

    font-weight: 700;

    font-size: 15px;
}


.rk-faq .accordion-button::after {
    filter: invert(1);

    opacity: .7;
}


.rk-faq .accordion-body {
    padding: 0 25px 25px;

    color: #84938b;

    line-height: 1.8;
}


/* ============================================================
   CTA
   ============================================================ */

.rk-cta {
    position: relative;

    overflow: hidden;

    padding: 65px;

    border-radius: 32px;

    background:
        radial-gradient(
            circle at 80% 20%,
            rgba(57,245,138,.22),
            transparent 30%
        ),
        linear-gradient(
            135deg,
            #112018,
            #07100b
        );

    border: 1px solid rgba(57,245,138,.15);

    box-shadow:
        0 30px 80px rgba(0,0,0,.3);
}


.rk-cta::after {
    content: "";

    position: absolute;

    width: 300px;
    height: 300px;

    right: -100px;
    bottom: -170px;

    border-radius: 50%;

    background: var(--rk-green);

    filter: blur(110px);

    opacity: .12;
}


.rk-cta h2 {
    position: relative;
    z-index: 2;

    color: white;

    font-size: clamp(34px, 5vw, 60px);

    font-weight: 800;

    line-height: 1.05;

    letter-spacing: -2px;
}


.rk-cta p {
    position: relative;
    z-index: 2;

    color: #8e9f96;

    max-width: 600px;

    line-height: 1.8;
}


.rk-cta-button {
    position: relative;
    z-index: 3;

    background: var(--rk-green);

    color: #031108;
}


.rk-cta-button:hover {
    color: #031108;

    transform: translateY(-4px);

    box-shadow:
        0 0 35px rgba(57,245,138,.25);
}


/* ============================================================
   REVEAL
   ============================================================ */

.rk-reveal {
    opacity: 0;

    transform: translateY(30px);

    transition:
        opacity .8s ease,
        transform .8s ease;
}


.rk-reveal.rk-visible {
    opacity: 1;

    transform: translateY(0);
}


/* ============================================================
   RESPONSIVE
   ============================================================ */

@media (max-width: 991px) {

    .rk-hero,
    .rk-hero-content {
        min-height: 680px;
    }


    .rk-search-inner {
        grid-template-columns: 1fr 1fr;
    }


    .rk-search-button {
        min-height: 55px;
    }


    .rk-about-visual {
        min-height: 400px;
    }


    .rk-steps::before {
        display: none;
    }

}


@media (max-width: 767px) {

    .rk-section {
        padding: 80px 0;
    }


    .rk-hero,
    .rk-hero-content {
        min-height: 650px;
    }


    .rk-hero-title {
        font-size: 48px;

        letter-spacing: -2px;
    }


    .rk-hero-description {
        font-size: 15px;
    }


    .rk-hero-buttons {
        flex-direction: column;

        align-items: stretch;
    }


    .rk-btn-primary,
    .rk-btn-outline {
        width: 100%;
    }


    .rk-search-wrap {
        margin-top: -35px;
    }


    .rk-search-inner {
        grid-template-columns: 1fr;
    }


    .rk-search-button {
        width: 100%;

        min-height: 55px;
    }


    .rk-carousel-arrow {
        display: none;
    }


    .rk-banner-content-inner {
        padding-top: 30px;
    }


    .rk-banner-content h2 {
        font-size: 44px;
    }


    .rk-about-visual {
        min-height: 380px;

        padding: 30px;
    }


    .rk-about-copy {
        left: 30px;
        right: 30px;
        bottom: 30px;
    }


    .rk-about-copy h3 {
        font-size: 28px;
    }


    .rk-cta {
        padding: 40px 28px;
    }


    /*
    ------------------------------------------------------------
    FOTO MOBIL MOBILE
    ------------------------------------------------------------
    */

    #hasil-pencarian .card-img-top,
    #hasil-pencarian .mobil-image,
    #hasil-pencarian .car-image,
    #hasil-pencarian .vehicle-image {
        height: 200px !important;

        max-height: 200px !important;
    }

}


@media (max-width: 480px) {

    .rk-hero-title {
        font-size: 40px;
    }


    .rk-section-title {
        font-size: 34px;
    }


    .rk-scroll-indicator {
        display: none;
    }

}


/* ============================================================
   REDUCED MOTION
   ============================================================ */

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


    .rk-reveal {
        opacity: 1;

        transform: none;
    }

}


@keyframes rkHeroIn {

    from {
        opacity: 0;

        transform: translateY(30px);
    }

    to {
        opacity: 1;

        transform: translateY(0);
    }

}

</style>


{{-- ============================================================
     HERO
============================================================ --}}

<section class="rk-hero" id="beranda">

    <div class="rk-hero-background"></div>

    <div class="rk-noise"></div>


    {{-- ========================================================
         BANNER
    ========================================================= --}}

    @if ($banners->count())

        <div
            id="rkHeroCarousel"
            class="carousel slide rk-banner-carousel"
            data-bs-ride="carousel"
            data-bs-interval="6000"
        >

            <div class="carousel-inner">


                {{-- DEFAULT SLIDE --}}

                <div class="carousel-item active">

                    <div class="rk-hero-content">

                        <div class="container">

                            <div class="rk-hero-copy">

                                <div class="rk-eyebrow">

                                    <i class="bi bi-patch-check-fill"></i>

                                   <span>
    {{ $landing['hero_badge'] ?? 'Rental mobil mudah & terpercaya' }}
</span>

                                </div>


                                <h1 class="rk-hero-title">

                                 {{ $landing['hero_title'] ?? 'Perjalanan lebih mudah dengan RentalKu.' }}

                                </h1>

<p class="rk-hero-description">

    {{ $landing['hero_description'] ?? 'Temukan mobil yang sesuai kebutuhanmu. Pilih kendaraan, tentukan tanggal rental, dan lakukan rental dengan mudah secara online.' }}

</p>


                                <div class="rk-hero-buttons">

                                    <a
                                        href="#mobil"
                                        class="rk-btn-primary"
                                    >

                                        <i class="bi bi-car-front-fill"></i>

                                        Lihat Mobil

                                    </a>


                                    <a
                                        href="#cara-rental"
                                        class="rk-btn-outline"
                                    >

                                        Cara Rental

                                        <i class="bi bi-arrow-right"></i>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- BANNER DATABASE --}}

                @foreach ($banners as $banner)

                    <div
                        class="carousel-item rk-banner-slide"
                        style="background-image: url('{{ asset($banner->gambar) }}');"
                    >

                        <div class="rk-banner-content">

                            <div class="container">

                                <div class="rk-banner-content-inner">

                                    <div class="rk-banner-badge">

                                        <i class="bi bi-stars"></i>

                                        Promo Spesial Rentalku

                                    </div>


                                    <h2>
                                        {{ $banner->judul }}
                                    </h2>


                                    <p>
                                        {{ $banner->description }}
                                    </p>


                                    <div class="rk-hero-buttons">

                                        <a
                                            href="#mobil"
                                            class="rk-btn-primary"
                                        >

                                            <i class="bi bi-car-front-fill"></i>

                                            Lihat Mobil

                                        </a>


                                        <a
                                            href="#cara-rental"
                                            class="rk-btn-outline"
                                        >

                                            Cara Rental

                                            <i class="bi bi-arrow-right"></i>

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- INDICATORS --}}

            <div class="carousel-indicators">

                <button
                    type="button"
                    data-bs-target="#rkHeroCarousel"
                    data-bs-slide-to="0"
                    class="active"
                    aria-current="true"
                    aria-label="Slide 1"
                ></button>


                @foreach ($banners as $i => $banner)

                    <button
                        type="button"
                        data-bs-target="#rkHeroCarousel"
                        data-bs-slide-to="{{ $i + 1 }}"
                        aria-label="Banner {{ $i + 1 }}"
                    ></button>

                @endforeach

            </div>


            {{-- PREVIOUS --}}

            <button
                class="carousel-control-prev rk-carousel-arrow"
                type="button"
                data-bs-target="#rkHeroCarousel"
                data-bs-slide="prev"
            >

                <i class="bi bi-arrow-left"></i>

                <span class="visually-hidden">
                    Sebelumnya
                </span>

            </button>


            {{-- NEXT --}}

            <button
                class="carousel-control-next rk-carousel-arrow"
                type="button"
                data-bs-target="#rkHeroCarousel"
                data-bs-slide="next"
            >

                <i class="bi bi-arrow-right"></i>

                <span class="visually-hidden">
                    Berikutnya
                </span>

            </button>

        </div>

    @else

        {{-- ====================================================
             TANPA BANNER
        ===================================================== --}}

        <div class="rk-hero-content">

            <div class="container">

                <div class="rk-hero-copy">

                   <div class="rk-eyebrow">

    <i class="bi bi-patch-check-fill"></i>

    {{ $landing['hero_badge'] ?? 'Rental mobil mudah & terpercaya' }}

</div>

                    <h1 class="rk-hero-title">

    {{ $landing['hero_title'] ?? 'Perjalanan lebih mudah bersama RentalKu.' }}

</h1>

                    <p class="rk-hero-description">

                      {{ $landing['hero_description'] ?? 'Temukan mobil pilihan untuk perjalananmu.' }}

                    </p>


                    <div class="rk-hero-buttons">

                        <a
                            href="#mobil"
                            class="rk-btn-primary"
                        >

                            <i class="bi bi-car-front-fill"></i>

                            Lihat Mobil

                        </a>


                        <a
                            href="#cara-rental"
                            class="rk-btn-outline"
                        >

                            Cara Rental

                            <i class="bi bi-arrow-right"></i>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    @endif


    <div class="rk-scroll-indicator">

        <div class="rk-scroll-line"></div>

        Scroll untuk menjelajah

    </div>

</section>



{{-- ============================================================
     SEARCH
============================================================ --}}

<section class="rk-search-wrap">

    <div class="container">

        <div class="rk-search-card">

            <form
                action="{{ route('home') }}"
                method="GET"
            >

                <div class="rk-search-inner">


                    {{-- CABANG --}}

                    <div class="rk-search-field">

                        <label class="rk-search-label">
                            Lokasi Pengambilan
                        </label>

                        <select
                            name="cabang"
                            class="rk-search-input"
                            aria-label="Pilih cabang"
                        >

                            <option value="">
                                Pilih cabang
                            </option>

                            @foreach ($cabangs as $item)

                                <option
                                    value="{{ $item->id }}"
                                    @selected($cabangAktif?->id == $item->id)
                                >

                                    {{ $item->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

{{-- {{-- ============================================================
     KONTAK RENTALKU
============================================================ --}}

{{-- <section class="rk-section" id="kontak">

    <div class="container">

        <div class="rk-section-head rk-center rk-reveal">

            <div class="rk-kicker">
                Hubungi Kami
            </div>

            <h2 class="rk-section-title">
                Siap Membantu Perjalananmu
            </h2>

            <p class="rk-section-description">
                Hubungi RentalKu untuk mendapatkan informasi
                mengenai ketersediaan mobil dan layanan rental.
            </p>

        </div>

        <div class="row g-4">

            <div class="col-lg-6 rk-reveal">

                <div class="rk-branch-card h-100">

                    <div class="rk-branch-icon">
                        <i class="bi bi-headset"></i>
                    </div>

                    <div class="rk-branch-name">
                        Informasi Kontak
                    </div>

                    @if ($kontak)

                        <div class="rk-branch-info">
                            <i class="bi bi-geo-alt-fill"></i>

                            <span>
                                {{ $kontak->address ?: 'Alamat belum tersedia.' }}
                            </span>
                        </div>

                        <div class="rk-branch-info">
                            <i class="bi bi-telephone-fill"></i>

                            <span>
                                {{ $kontak->phone ?: 'Nomor telepon belum tersedia.' }}
                            </span>
                        </div>

                    @else

                        <div class="rk-branch-info">
                            <i class="bi bi-info-circle"></i>

                            <span>
                                Informasi kontak belum tersedia.
                            </span>
                        </div>

                    @endif

                </div>

            </div>


            <div class="col-lg-6 rk-reveal">

                <div class="rk-branch-card h-100">

                    <div class="rk-branch-icon">
                        <i class="bi bi-clock-fill"></i>
                    </div>

                    <div class="rk-branch-name">
                        Jam Operasional
                    </div>

                    <div class="rk-branch-info">
                        <i class="bi bi-calendar-check"></i>

                        <span>
                            Senin – Sabtu<br>
                            08.00 – 17.00 WIB
                        </span>
                    </div>

                    <div class="rk-branch-info">
                        <i class="bi bi-calendar-x"></i>

                        <span>
                            Minggu<br>
                            Dengan perjanjian
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>  --}}
                    {{-- TANGGAL MULAI --}}

                    <div class="rk-search-field">

                        <label class="rk-search-label">
                            Tanggal Mulai
                        </label>

                        <input
                            type="date"
                            name="tanggal_mulai"
                            value="{{ $mulai?->toDateString() }}"
                            min="{{ now()->toDateString() }}"
                            class="rk-search-input"
                        >

                    </div>


                    {{-- TANGGAL SELESAI --}}

                    <div class="rk-search-field">

                        <label class="rk-search-label">
                            Tanggal Selesai
                        </label>

                        <input
                            type="date"
                            name="tanggal_selesai"
                            value="{{ $selesai?->toDateString() }}"
                            min="{{ now()->toDateString() }}"
                            class="rk-search-input"
                        >

                    </div>


                    {{-- BUTTON --}}

                    <div>

                        <button
                            type="submit"
                            class="rk-search-button"
                        >

                            <i class="bi bi-search me-2"></i>

                            Cari Mobil

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</section>



{{-- ============================================================
     MOBIL
============================================================ --}}

<section
    class="rk-section"
    id="mobil"
>

    <div class="container">

        <div id="hasil-pencarian">

            @include('home.partials.hasil-pencarian')

        </div>

    </div>

</section>

{{-- ============================================================
     INFORMASI CABANG RENTAL
============================================================ --}}

<section
    class="rk-section rk-section-soft"
    id="cabang"
>

    <div class="container">

        <div class="rk-section-head rk-center rk-reveal">

            <div class="rk-kicker">
                Lokasi RentalKu
            </div>

            <h2 class="rk-section-title">
                Temukan Cabang RentalKu
            </h2>

            <p class="rk-section-description">
                Pilih cabang RentalKu yang paling dekat dengan lokasi
                dan kebutuhan perjalananmu.
            </p>

        </div>


        <div class="row g-4">

            @forelse ($cabangs as $cabang)

                <div class="col-md-6 col-lg-4 rk-reveal">

                    <div class="rk-branch-card">

                        <div class="rk-branch-icon">

                            <i class="bi bi-geo-alt-fill"></i>

                        </div>


                        <div class="rk-branch-name">

                            {{ $cabang->name }}

                        </div>


                        <div class="rk-branch-info">

                            <i class="bi bi-geo-alt-fill"></i>

                            <span>
                                {{ $cabang->address ?: 'Alamat belum tersedia.' }}
                            </span>

                        </div>


                        <div class="rk-branch-info">

                            <i class="bi bi-telephone-fill"></i>

                            <span>
                                {{ $cabang->phone ?: 'Nomor telepon belum tersedia.' }}
                            </span>

                        </div>


                        @if (!empty($cabang->address))

                            <a
                                href="https://www.google.com/maps/search/?api=1&query={{ urlencode($cabang->address) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="rk-btn-outline mt-3"
                            >

                                <i class="bi bi-map"></i>

                                Lihat Lokasi

                            </a>

                        @endif

                    </div>

                </div>

            @empty

                <div class="col-12">

                    <div class="rk-branch-empty">

                        <i class="bi bi-geo-alt fs-2 d-block mb-3"></i>

                        Belum ada informasi cabang rental.

                    </div>

                </div>

            @endforelse

        </div>

    </div>

</section>



{{-- ============================================================
     BRAND
============================================================ --}}

<section class="rk-section rk-section-soft">

    <div class="container">

        <div class="rk-section-head rk-center rk-reveal">

            <div class="rk-kicker">
                Brand Pilihan
            </div>

          <h2 class="rk-section-title">
    {{ $landing['brand_title'] ?? 'Pilihan brand untukmu.' }}
</h2>

<p class="rk-section-description">
    {{ $landing['brand_description'] ?? 'Berbagai pilihan merek kendaraan tersedia untuk memenuhi kebutuhan perjalananmu.' }}
</p>
        </div>


        <div class="row g-3 justify-content-center">

            @forelse($brands as $brand)

                <div class="col-6 col-md-4 col-lg-2 rk-reveal">

                    <div class="rk-brand-card">

                        @if ($brand->logo)

                            <img
                                src="{{ asset('storage/' . $brand->logo) }}"
                                class="rk-brand-logo"
                                alt="{{ $brand->name }}"
                            >

                        @else

                            <div
                                class="rk-brand-logo d-flex align-items-center justify-content-center bg-light rounded-circle"
                            >

                                <i class="bi bi-car-front fs-4 text-success"></i>

                            </div>

                        @endif


                        <div class="rk-brand-name">

                            {{ $brand->name }}

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12 text-center text-secondary">

                    Belum ada brand.

                </div>

            @endforelse

        </div>

    </div>

</section>

{{-- ============================================================
     PROMO DINAMIS DARI KUPON
============================================================ --}}

@if ($kupons->count())

<section class="rk-section rk-section-soft" id="promo">

    <div class="container">

        <div class="rk-section-head rk-center rk-reveal">

            <div class="rk-kicker">
                Promo Spesial
            </div>

           <h2 class="rk-section-title">
    {{ $landing['promo_title'] ?? 'Hemat perjalananmu.' }}
</h2>

<p class="rk-section-description">
    {{ $landing['promo_description'] ?? 'Gunakan kode kupon pilihan dan dapatkan penawaran menarik dari RentalKu.' }}
</p>

        </div>

        <div class="row g-4">

            @foreach ($kupons as $kupon)

                <div class="col-md-6 col-lg-4 rk-reveal">

                    <div class="rk-feature h-100">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div class="rk-feature-icon mb-0">

                                <i class="bi bi-ticket-perforated"></i>

                            </div>

                            <span class="badge rounded-pill text-bg-success">
                                Promo Aktif
                            </span>

                        </div>

                        <h4>
                            @if ($kupon->jenis === 'persen')
                                Diskon {{ $kupon->value }}%
                            @else
                                Potongan Rp {{ number_format($kupon->value, 0, ',', '.') }}
                            @endif
                        </h4>

                        <p class="mb-3">
                            Gunakan kupon ini saat melakukan
                            pemesanan mobil di RentalKu.
                        </p>

                        <div class="p-3 rounded-3 mb-3"
                             style="background: rgba(57,245,138,.08);
                                    border: 1px dashed rgba(57,245,138,.45);">

                            <div class="small text-secondary mb-1">
                                Kode Kupon
                            </div>

                            <div class="d-flex justify-content-between align-items-center">

                                <strong style="color: var(--rk-green); letter-spacing: 1px;">
                                    {{ $kupon->code }}
                                </strong>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-success"
                                    onclick="salinKupon('{{ $kupon->code }}')"
                                >
                                    <i class="bi bi-copy"></i>
                                </button>

                            </div>

                        </div>

                        @if ($kupon->minimal_pembelian)
                            <small class="text-secondary d-block mb-1">
                                Minimal pembelian:
                                Rp {{ number_format($kupon->minimal_pembelian, 0, ',', '.') }}
                            </small>
                        @endif

                        @if ($kupon->expired_at)
                            <small class="text-secondary d-block">
                                Berlaku sampai:
                                {{ \Carbon\Carbon::parse($kupon->expired_at)->format('d M Y') }}
                            </small>
                        @endif

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>

@endif

{{-- ============================================================
     TENTANG
============================================================ --}}

<section
    class="rk-section"
    id="tentang"
>

    <div class="container">

        <div class="row align-items-center g-5">


            <div class="col-lg-5 rk-reveal">

                <div class="rk-about-visual">

                    <div class="rk-about-number">
                        01
                    </div>

                    <div class="rk-about-glow"></div>


                    <div class="rk-about-copy">

                        <small>
                            Kenapa Rentalku?
                        </small>


                      <h3>
    {{ $landing['about_title'] ?? 'Rental mobil tanpa ribet.' }}
</h3>

<p>

    {{ $landing['about_description'] ?? 'Kami menghadirkan pengalaman rental mobil yang praktis dengan proses pemesanan yang mudah dan transparan.' }}

</p>

                    </div>

                </div>

            </div>


            <div class="col-lg-7">

                <div class="rk-section-head rk-reveal">

                    <div class="rk-kicker">
                        Mengapa Kami
                    </div>


                  <h2 class="rk-section-title">
    {{ $landing['feature_title'] ?? 'Lebih nyaman. Lebih mudah.' }}
</h2>

<p class="rk-section-description">
    {{ $landing['feature_description'] ?? 'Semua kebutuhan rental mobil kamu kami buat sesederhana mungkin.' }}
</p>

                </div>


                <div class="row g-3">


                    {{-- 01 --}}

                    <div class="col-md-6 rk-reveal">

                        <div class="rk-feature">

                            <div class="rk-feature-number">
                                01
                            </div>


                            <div class="rk-feature-icon">

                                <i class="bi bi-shield-check"></i>

                            </div>


                            <h4>
                                Aman & Terpercaya
                            </h4>


                            <p>

                                Data kendaraan dan proses rental
                                dikelola dengan sistem yang terstruktur.

                            </p>

                        </div>

                    </div>


                    {{-- 02 --}}

                    <div class="col-md-6 rk-reveal">

                        <div class="rk-feature">

                            <div class="rk-feature-number">
                                02
                            </div>


                            <div class="rk-feature-icon">

                                <i class="bi bi-lightning-charge"></i>

                            </div>


                            <h4>
                                Proses Cepat
                            </h4>


                            <p>

                                Rental mobil dapat dilakukan
                                dengan mudah melalui website.

                            </p>

                        </div>

                    </div>


                    {{-- 03 --}}

                    <div class="col-md-6 rk-reveal">

                        <div class="rk-feature">

                            <div class="rk-feature-number">
                                03
                            </div>


                            <div class="rk-feature-icon">

                                <i class="bi bi-wallet2"></i>

                            </div>


                            <h4>
                                Harga Transparan
                            </h4>


                            <p>

                                Kamu dapat melihat harga rental
                                sebelum melakukan rental.

                            </p>

                        </div>

                    </div>


                    {{-- 04 --}}

                    <div class="col-md-6 rk-reveal">

                        <div class="rk-feature">

                            <div class="rk-feature-number">
                                04
                            </div>


                            <div class="rk-feature-icon">

                                <i class="bi bi-headset"></i>

                            </div>


                            <h4>
                                Layanan Support
                            </h4>


                            <p>

                                Hubungi tim Rentalku jika membutuhkan
                                bantuan selama proses rental.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- ============================================================
     CARA RENTAL
============================================================ --}}

<section
    class="rk-section rk-section-soft"
    id="cara-rental"
>

    <div class="container">

        <div class="rk-section-head rk-center rk-reveal">

            <div class="rk-kicker">
                Cara Rental
            </div>


            <h2 class="rk-section-title">
    {{ $landing['steps_title'] ?? 'Semudah itu untuk berangkat.' }}
</h2>

<p class="rk-section-description">
    {{ $landing['steps_description'] ?? 'Proses sederhana untuk mendapatkan mobil yang kamu butuhkan.' }}
</p>

        </div>


        <div class="row g-4 rk-steps">


            {{-- STEP 01 --}}

            <div class="col-md-6 col-lg-3 rk-reveal">

                <div class="rk-step">

                    <div class="rk-step-circle">
                        01
                    </div>


                    <h4>
                        Pilih Mobil
                    </h4>


                    <p>

                        Cari dan pilih kendaraan sesuai
                        kebutuhan perjalananmu.

                    </p>

                </div>

            </div>


            {{-- STEP 02 --}}

            <div class="col-md-6 col-lg-3 rk-reveal">

                <div class="rk-step">

                    <div class="rk-step-circle">
                        02
                    </div>


                    <h4>
                        Tentukan Jadwal
                    </h4>


                    <p>

                        Tentukan tanggal mulai dan selesai
                        rental mobil.

                    </p>

                </div>

            </div>


            {{-- STEP 03 --}}

            <div class="col-md-6 col-lg-3 rk-reveal">

                <div class="rk-step">

                    <div class="rk-step-circle">
                        03
                    </div>


                    <h4>
                        Lakukan Rental
                    </h4>


                    <p>

                        Isi data rental dan pilih layanan
                        dengan atau tanpa supir.

                    </p>

                </div>

            </div>


            {{-- STEP 04 --}}

            <div class="col-md-6 col-lg-3 rk-reveal">

                <div class="rk-step">

                    <div class="rk-step-circle">
                        04
                    </div>


                    <h4>
                        Siap Berangkat
                    </h4>


                    <p>

                        Setelah pembayaran dikonfirmasi,
                        mobil siap digunakan.

                    </p>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- ============================================================
     TESTIMONI
============================================================ --}}

@if ($ratings->count())

    <section class="rk-section">

        <div class="container">

            <div class="rk-section-head rk-center rk-reveal">

                <div class="rk-kicker">
                    Testimoni
                </div>


               <h2 class="rk-section-title">
    {{ $landing['testimonial_title'] ?? 'Apa kata pelanggan?' }}
</h2>

<p class="rk-section-description">
    {{ $landing['testimonial_description'] ?? 'Pengalaman pelanggan menjadi bagian penting dari perjalanan RentalKu.' }}
</p>

            </div>


            <div class="row g-4">

                @foreach ($ratings as $rating)

                    <div class="col-md-6 col-lg-4 rk-reveal">

                        <div class="rk-rating-card">

                            <div class="rk-stars">

                                @for ($i = 1; $i <= 5; $i++)

                                    @if ($i <= $rating->rating)

                                        <i class="bi bi-star-fill"></i>

                                    @else

                                        <i class="bi bi-star"></i>

                                    @endif

                                @endfor

                            </div>


                            <div class="rk-rating-quote">

"{{ $rating->komentar ?? 'Pelayanan sangat baik.' }}"

                            </div>


                            <div class="rk-rating-user">

                                @if ($rating->foto_user)

                                    <img
                                        src="{{ asset('storage/' . $rating->foto_user) }}"
                                        class="rk-rating-avatar"
                                   alt="{{ $rating->nama ?? 'Pengguna RentalKu' }}"
                                    >

                                @else

                                    <div class="rk-rating-avatar">

                                        <i class="bi bi-person"></i>

                                    </div>

                                @endif


                                <div>

                                    <div class="rk-rating-name">

                                    {{ $rating->nama ?? 'Pengguna RentalKu' }}

                                    </div>


                                    <div class="rk-rating-car">

                                  {{ $rating->nama_mobil ?? 'Mobil RentalKu' }}

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </section>

@endif



{{-- ============================================================
     FAQ
============================================================ --}}

<section
    class="rk-section rk-section-soft"
    id="faq"
>

    <div class="container">

        <div class="rk-section-head rk-center rk-reveal">

            <div class="rk-kicker">
                FAQ
            </div>


           <h2 class="rk-section-title">
    {{ $landing['faq_title'] ?? 'Pertanyaan yang sering ditanyakan.' }}
</h2>

<p class="rk-section-description">
    {{ $landing['faq_description'] ?? 'Temukan jawaban dari beberapa pertanyaan yang sering ditanyakan pelanggan.' }}
</p>

        </div>


        <div
            class="accordion rk-faq"
            id="faqAccordion"
        >

            @forelse($faqs as $key => $faq)

                <div class="accordion-item rk-reveal">

                    <h2 class="accordion-header">

                        <button
                            class="accordion-button {{ $key !== 0 ? 'collapsed' : '' }}"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#rkFaq{{ $faq->id_faq }}"
                        >

                            {{ $faq->pertanyaan }}

                        </button>

                    </h2>


                    <div
                        id="rkFaq{{ $faq->id_faq }}"
                        class="accordion-collapse collapse {{ $key === 0 ? 'show' : '' }}"
                        data-bs-parent="#faqAccordion"
                    >

                        <div class="accordion-body">

                            {{ $faq->jawaban }}

                        </div>

                    </div>

                </div>

            @empty

                <div class="text-center text-secondary">

                    Belum ada FAQ.

                </div>

            @endforelse

        </div>

    </div>

</section>



{{-- ============================================================
     CTA
============================================================ --}}

<section
    class="rk-section"
    id="kontak"
>

    <div class="container">

        <div class="rk-cta rk-reveal">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <div class="rk-kicker">
                        Mulai Sekarang
                    </div>


<h2>

    {{ $landing['cta_title'] ?? 'Siap memulai perjalananmu?' }}

</h2>

<p>

    {{ $landing['cta_description'] ?? 'Pilih mobil favoritmu dan lakukan rental dengan mudah bersama RentalKu.' }}

</p>

                </div>


                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                    <a
                        href="#mobil"
                        class="rk-cta-button"
                    >

                        Cari Mobil Sekarang

                        <i class="bi bi-arrow-up-right"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- ============================================================
     SEARCH JAVASCRIPT
============================================================ --}}

<script>

$(function () {

    const $form = $('.rk-search-card form');

    if (!$form.length) {
        return;
    }


    const form = $form[0];


    const $mulai =
        $(form.elements.tanggal_mulai);


    const $selesai =
        $(form.elements.tanggal_selesai);


    const $cabangEl =
        $(form.elements.cabang);


    const $tombol =
        $form.find('button[type="submit"]');


    const $kontainer =
        $('#hasil-pencarian');


    /* =========================================================
       MIN TANGGAL
    ========================================================= */

    function sinkronMin() {

        const nilaiMulai =
            $mulai.val();

        $selesai.attr(
            'min',
            nilaiMulai || ''
        );

    }


    $mulai.on(
        'change',
        sinkronMin
    );


    sinkronMin();


    /* =========================================================
       VALIDASI
    ========================================================= */

    function pesanError() {

        const adaMulai =
            $mulai.val() !== '';


        const adaSelesai =
            $selesai.val() !== '';


        $selesai[0].setCustomValidity('');


        if (adaMulai !== adaSelesai) {

            return 'Lengkapi kedua tanggal (mulai dan selesai) atau kosongkan keduanya.';

        }


        if (
            adaSelesai &&
            $selesai.val() < $mulai.val()
        ) {

            return 'Tanggal selesai tidak boleh sebelum tanggal mulai.';

        }


        return '';

    }


    function valid() {

        const pesan =
            pesanError();


        if (pesan !== '') {

            $selesai[0].setCustomValidity(
                pesan
            );

            $selesai[0].reportValidity();

            return false;

        }


        return true;

    }


    /* =========================================================
       QUERY
    ========================================================= */

    function bangunQuery() {

        const params =
            new URLSearchParams();


        if ($cabangEl.val() !== '') {

            params.set(
                'cabang',
                $cabangEl.val()
            );

        }


        if ($mulai.val() !== '') {

            params.set(
                'tanggal_mulai',
                $mulai.val()
            );

        }


        if ($selesai.val() !== '') {

            params.set(
                'tanggal_selesai',
                $selesai.val()
            );

        }


        return params.toString();

    }


    let sedangCari = false;


    /* =========================================================
       AJAX SEARCH
    ========================================================= */

    function cari(
        url,
        dorongRiwayat,
        gulirKeGrid
    ) {

        if (sedangCari) {
            return;
        }


        sedangCari = true;


        $tombol.prop(
            'disabled',
            true
        );


        $tombol.html(
            '<span class="spinner-border spinner-border-sm me-2"></span>Mencari...'
        );


        $.ajax({

            url: url,

            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }

        })


        .done(function (html) {

            $kontainer.html(
                html
            );


            if (dorongRiwayat) {

                history.pushState(
                    null,
                    '',
                    url
                );

            }


            if (gulirKeGrid) {

                const mobil =
                    document.getElementById('mobil');


                if (mobil) {

                    mobil.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                }

            }

        })


        .fail(function () {

            window.location.href =
                url;

        })


        .always(function () {

            sedangCari = false;


            $tombol.prop(
                'disabled',
                false
            );


            $tombol.html(
                '<i class="bi bi-search me-2"></i>Cari Mobil'
            );

        });

    }


    /* =========================================================
       SUBMIT
    ========================================================= */

    $form.on(
        'submit',
        function (e) {

            e.preventDefault();


            if (!valid()) {
                return;
            }


            const query =
                bangunQuery();


            if (query === '') {

                cari(
                    form.action,
                    true,
                    false
                );

                return;

            }


            cari(
                form.action + '?' + query,
                true,
                false
            );

        }
    );


    /* =========================================================
       HASIL SEARCH LINK
    ========================================================= */

    $(document).on(
        'click',
        '#hasil-pencarian [data-search-link]',
        function (e) {

            e.preventDefault();


            const $link =
                $(this);


            cari(
                $link.attr('href'),
                true,
                $link.attr('data-search-top') !== undefined
            );

        }
    );


    /* =========================================================
       BROWSER BACK / FORWARD
    ========================================================= */

    $(window).on(
        'popstate',
        function () {

            cari(
                window.location.href,
                false,
                false
            );

        }
    );


    /* =========================================================
       SCROLL REVEAL
    ========================================================= */

    const revealElements =
        document.querySelectorAll('.rk-reveal');


    if (
        'IntersectionObserver' in window
    ) {

        const observer =
            new IntersectionObserver(
                function (entries) {

                    entries.forEach(function (entry) {

                        if (entry.isIntersecting) {

                            entry.target.classList.add(
                                'rk-visible'
                            );

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

            element.classList.add(
                'rk-visible'
            );

        });

    }

         window.salinKupon = function (kode) {
            navigator.clipboard.writeText(kode)
                .then(function () {
                    alert('Kode kupon berhasil disalin: ' + kode);
                })
                .catch(function () {
                    alert('Gagal menyalin kode kupon.');
                });
        };

    }); // Penutup $(function () {

</script>

@endsection