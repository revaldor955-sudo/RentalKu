<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Brand Studio - RentalKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">


    <style>

        :root {

            --green: #198754;
            --green-dark: #0f5132;
            --green-soft: #eaf7ef;

            --black: #101713;
            --dark: #18231d;

            --gray: #718078;
            --light: #f4f7f5;

            --border: #e7ece9;

            --white: #ffffff;

        }


        body {

            min-height: 100vh;

            background:
                linear-gradient(
                    180deg,
                    #f8faf9 0%,
                    #f2f6f3 100%
                );

            color: var(--dark);

            font-family:
                'Plus Jakarta Sans',
                sans-serif;

        }


        .navbar {

            background:
                rgba(255,255,255,.94);

            backdrop-filter:
                blur(18px);

            border-bottom:
                1px solid var(--border);

        }


        .brand-page {

            max-width: 1450px;

            margin: auto;

            padding:
                30px 22px 70px;

        }


        .brand-hero {

            position: relative;

            min-height: 320px;

            overflow: hidden;

            border-radius: 32px;

            padding: 45px;

            display: flex;

            align-items: center;

            background:
                #111b16;

            box-shadow:
                0 25px 60px
                rgba(16,40,27,.14);

        }


        .hero-grid {

            position: absolute;

            inset: 0;

            opacity: .08;

            background-image:
                linear-gradient(
                    rgba(255,255,255,.5) 1px,
                    transparent 1px
                ),
                linear-gradient(
                    90deg,
                    rgba(255,255,255,.5) 1px,
                    transparent 1px
                );

            background-size:
                40px 40px;

        }


        .hero-circle {

            position: absolute;

            width: 430px;

            height: 430px;

            right: -100px;

            top: -180px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    #198754,
                    rgba(25,135,84,.05) 65%,
                    transparent 70%
                );

        }


        .hero-circle-two {

            position: absolute;

            width: 280px;

            height: 280px;

            right: 230px;

            bottom: -210px;

            border-radius: 50%;

            border:
                45px solid
                rgba(25,135,84,.15);

        }


        .hero-content {

            position: relative;

            z-index: 5;

            max-width: 690px;

        }


        .hero-tag {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding:
                8px 13px;

            border-radius: 30px;

            background:
                rgba(25,135,84,.20);

            border:
                1px solid
                rgba(25,135,84,.35);

            color:
                #78d9a6;

            font-size: 11px;

            font-weight: 800;

            letter-spacing: 1px;

            text-transform: uppercase;

        }


        .hero-title {

            margin:
                20px 0 12px;

            color: white;

            font-size: 42px;

            line-height: 1.15;

            font-weight: 800;

            letter-spacing: -1.5px;

        }


        .hero-title span {

            color:
                #5ed392;

        }


        .hero-description {

            margin: 0;

            max-width: 610px;

            color:
                rgba(255,255,255,.62);

            font-size: 14px;

            line-height: 1.8;

        }


        .hero-decoration {

            position: absolute;

            right: 70px;

            bottom: 35px;

            z-index: 3;

            width: 230px;

            height: 150px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 28px;

            border:
                1px solid
                rgba(255,255,255,.08);

            background:
                rgba(255,255,255,.035);

            transform:
                rotate(-5deg);

        }


        .hero-decoration i {

            font-size: 100px;

            color:
                rgba(255,255,255,.10);

        }


        .toolbar {

            margin-top: 22px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 15px;

        }


        .breadcrumb-custom {

            display: flex;

            align-items: center;

            gap: 9px;

            color:
                #87918b;

            font-size: 12px;

            font-weight: 600;

        }


        .toolbar-actions {

            display: flex;

            gap: 9px;

        }


        .btn-dashboard {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            padding:
                10px 15px;

            border-radius: 11px;

            border:
                1px solid var(--border);

            background: white;

            color:
                #58645d;

            font-size: 12px;

            font-weight: 700;

            text-decoration: none;

        }


        .btn-dashboard:hover {

            background:
                #f8faf9;

            color:
                var(--dark);

        }


        .btn-add {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding:
                10px 16px;

            border: none;

            border-radius: 11px;

            background:
                var(--green);

            color: white;

            font-size: 12px;

            font-weight: 800;

            box-shadow:
                0 8px 18px
                rgba(25,135,84,.20);

        }


        .btn-add:hover {

            background:
                var(--green-dark);

            color: white;

            transform:
                translateY(-1px);

        }


        .stats-row {

            margin-top: 22px;

        }


        .mini-stat {

            position: relative;

            height: 100%;

            padding: 20px;

            overflow: hidden;

            border:
                1px solid var(--border);

            border-radius: 20px;

            background: white;

            transition:
                .25s ease;

        }


        .mini-stat:hover {

            transform:
                translateY(-4px);

            box-shadow:
                0 18px 35px
                rgba(20,40,28,.07);

        }


        .mini-stat::after {

            content: "";

            position: absolute;

            width: 95px;

            height: 95px;

            right: -35px;

            bottom: -40px;

            border-radius: 50%;

            background:
                var(--green-soft);

        }


        .mini-icon {

            width: 47px;

            height: 47px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 14px;

            background:
                var(--green-soft);

            color:
                var(--green);

            font-size: 20px;

        }


        .mini-label {

            margin-top: 17px;

            color:
                #89938d;

            font-size: 11px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .6px;

        }


        .mini-number {

            margin-top: 2px;

            font-size: 28px;

            font-weight: 800;

            letter-spacing: -1px;

        }


        .content-card {

            margin-top: 25px;

            border:
                1px solid var(--border);

            border-radius: 25px;

            background: white;

            overflow: hidden;

            box-shadow:
                0 8px 25px
                rgba(20,40,28,.035);

        }


        .content-top {

            padding:
                22px 24px;

            border-bottom:
                1px solid var(--border);

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

        }


        .content-title {

            margin: 0;

            font-size: 17px;

            font-weight: 800;

        }


        .content-subtitle {

            margin:
                5px 0 0;

            color:
                #8a948e;

            font-size: 11px;

        }


        .search-box {

            position: relative;

            width: 260px;

        }


        .search-box i {

            position: absolute;

            left: 13px;

            top: 50%;

            transform:
                translateY(-50%);

            color:
                #9aa39e;

        }


        .search-box input {

            width: 100%;

            height: 42px;

            padding-left: 38px;

            padding-right: 13px;

            border:
                1px solid var(--border);

            border-radius: 11px;

            outline: none;

            font-size: 12px;

        }


        .search-box input:focus {

            border-color:
                #91cdae;

            box-shadow:
                0 0 0 4px
                rgba(25,135,84,.08);

        }


        .gallery-wrapper {

            padding:
                24px;

        }


        .brand-grid {

            display: grid;

            grid-template-columns:
                repeat(4, minmax(0,1fr));

            gap: 17px;

        }


        .brand-card {

            position: relative;

            min-height: 245px;

            padding: 18px;

            overflow: hidden;

            border:
                1px solid #e9eeeb;

            border-radius: 21px;

            background:
                linear-gradient(
                    145deg,
                    #ffffff,
                    #f8faf9
                );

            transition:
                .25s ease;

        }


        .brand-card:hover {

            transform:
                translateY(-6px);

            border-color:
                #cfe4d7;

            box-shadow:
                0 20px 40px
                rgba(20,50,32,.09);

        }


        .brand-number {

            position: absolute;

            top: 15px;

            right: 17px;

            color:
                #c8d0cb;

            font-size: 10px;

            font-weight: 800;

            letter-spacing: 1px;

        }


        .logo-stage {

            width: 100%;

            height: 125px;

            margin-bottom: 16px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 16px;

            background:
                radial-gradient(
                    circle at center,
                    #ffffff,
                    #f1f5f2
                );

            border:
                1px solid #edf1ee;

        }


        .brand-logo {

            max-width: 110px;

            max-height: 80px;

            object-fit: contain;

            transition:
                .25s ease;

        }


        .brand-card:hover
        .brand-logo {

            transform:
                scale(1.06);

        }


        .no-logo {

            width: 65px;

            height: 65px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 20px;

            background:
                var(--green-soft);

            color:
                var(--green);

            font-size: 27px;

        }


        .brand-card-name {

            margin: 0;

            color:
                #18231d;

            font-size: 15px;

            font-weight: 800;

        }


        .brand-description {

            margin-top: 5px;

            min-height: 34px;

            color:
                #8a948e;

            font-size: 10px;

            line-height: 1.6;

            display: -webkit-box;

            -webkit-line-clamp: 2;

            -webkit-box-orient: vertical;

            overflow: hidden;

        }


        .brand-bottom {

            margin-top: 14px;

            padding-top: 13px;

            border-top:
                1px solid #edf1ee;

            display: flex;

            align-items: center;

            justify-content: space-between;

        }


        .car-count {

            display: inline-flex;

            align-items: center;

            gap: 6px;

            padding:
                6px 9px;

            border-radius: 8px;

            background:
                var(--green-soft);

            color:
                var(--green-dark);

            font-size: 10px;

            font-weight: 800;

        }


        .card-actions {

            display: flex;

            gap: 5px;

        }


        .card-action {

            width: 31px;

            height: 31px;

            display: flex;

            align-items: center;

            justify-content: center;

            border:
                1px solid #e6ebe8;

            border-radius: 9px;

            background: white;

            font-size: 13px;

            transition: .2s;

        }


        .card-action.edit {

            color:
                #0d6efd;

        }


        .card-action.delete {

            color:
                #dc3545;

        }


        .card-action.locked {

            color:
                #9aa39e;

            background:
                #f5f7f6;

            cursor: not-allowed;

        }


        .card-action.edit:hover {

            background:
                #edf5ff;

            border-color:
                #cfe2ff;

        }


        .card-action.delete:hover {

            background:
                #fff0f1;

            border-color:
                #f3c8cd;

        }


        #brands-table_wrapper {

            display: none;

        }


        .gallery-loading {

            min-height: 260px;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            color:
                #89948d;

        }


        .gallery-loading .spinner-border {

            color:
                var(--green);

        }


        .modal-content {

            border: none;

            border-radius: 24px;

            overflow: hidden;

            box-shadow:
                0 35px 90px
                rgba(0,0,0,.20);

        }


        .modal-header {

            padding:
                23px 25px;

            background:
                #111b16;

            color: white;

            border: none;

        }


        .modal-title {

            font-size: 17px;

            font-weight: 800;

        }


        .modal-subtitle {

            margin-top: 3px;

            color:
                rgba(255,255,255,.52);

            font-size: 10px;

        }


        .modal-body {

            padding: 25px;

        }


        .form-label {

            margin-bottom: 7px;

            color:
                #465149;

            font-size: 11px;

            font-weight: 800;

        }


        .form-control {

            min-height: 44px;

            border:
                1px solid var(--border);

            border-radius: 11px;

            font-size: 12px;

        }


        textarea.form-control {

            min-height: 105px;

        }


        .form-control:focus {

            border-color:
                var(--green);

            box-shadow:
                0 0 0 .2rem
                rgba(25,135,84,.09);

        }


        .logo-upload {

            position: relative;

            padding: 17px;

            border:
                1px dashed #cbd8d0;

            border-radius: 15px;

            background:
                #fafcfb;

        }


        .upload-preview {

            width: 100%;

            height: 130px;

            margin-bottom: 12px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 13px;

            background: white;

            border:
                1px solid var(--border);

            overflow: hidden;

        }


        .upload-preview img {

            max-width: 150px;

            max-height: 100px;

            object-fit: contain;

        }


        .upload-placeholder {

            text-align: center;

            color:
                #9ba49e;

        }


        .upload-placeholder i {

            display: block;

            margin-bottom: 5px;

            color:
                #b3beb7;

            font-size: 32px;

        }


        .modal-footer {

            padding:
                16px 25px;

            border-top:
                1px solid var(--border);

            background:
                #fafcfb;

        }


        .btn-modal-cancel {

            padding:
                9px 15px;

            border:
                1px solid var(--border);

            border-radius: 10px;

            background: white;

            color:
                #68736d;

            font-size: 11px;

            font-weight: 700;

        }


        .btn-modal-save {

            padding:
                9px 17px;

            border: none;

            border-radius: 10px;

            background:
                var(--green);

            color: white;

            font-size: 11px;

            font-weight: 800;

        }


        .btn-modal-save:hover {

            background:
                var(--green-dark);

            color: white;

        }


        @media(max-width: 1200px) {

            .brand-grid {

                grid-template-columns:
                    repeat(3, minmax(0,1fr));

            }

            .hero-decoration {

                right: 30px;

            }

        }


        @media(max-width: 900px) {

            .brand-grid {

                grid-template-columns:
                    repeat(2, minmax(0,1fr));

            }

            .hero-decoration {

                display: none;

            }

            .hero-title {

                font-size: 34px;

            }

        }


        @media(max-width: 600px) {

            .brand-page {

                padding:
                    20px 12px 50px;

            }

            .brand-hero {

                padding:
                    30px 23px;

                min-height:
                    290px;

                border-radius:
                    23px;

            }

            .hero-title {

                font-size: 28px;

            }

            .toolbar {

                flex-direction:
                    column;

                align-items:
                    flex-start;

            }

            .toolbar-actions {

                width: 100%;

            }

            .toolbar-actions > * {

                flex: 1;

                justify-content:
                    center;

                text-align:
                    center;

            }

            .content-top {

                flex-direction:
                    column;

                align-items:
                    flex-start;

            }

            .search-box {

                width: 100%;

            }

            .brand-grid {

                grid-template-columns:
                    1fr;

            }

            .gallery-wrapper {

                padding:
                    15px;

            }

        }

    </style>

</head>


<body>


    @include('layouts.partials.admin-navbar')


    <main class="brand-page">


        <section class="brand-hero">

            <div class="hero-grid"></div>

            <div class="hero-circle"></div>

            <div class="hero-circle-two"></div>


            <div class="hero-content">

                <div class="hero-tag">

                    <i class="bi bi-stars"></i>

                    RentalKu Brand Studio

                </div>


                <h1 class="hero-title">

                    Semua Merek.
                    <br>

                    <span>Satu Kendali.</span>

                </h1>


                <p class="hero-description">

                    Bangun katalog kendaraan RentalKu yang
                    lebih terorganisir. Kelola logo, informasi,
                    dan koleksi kendaraan berdasarkan merek
                    dalam satu ruang manajemen.

                </p>

            </div>


            <div class="hero-decoration">

                <i class="bi bi-grid-3x3-gap-fill"></i>

            </div>

        </section>


        <div class="toolbar">

            <div class="breadcrumb-custom">
            </div>


            <div class="toolbar-actions">

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="btn-dashboard">

                    <i class="bi bi-arrow-left"></i>

                    Dashboard

                </a>


                <button
                    type="button"
                    class="btn-add"
                    data-bs-toggle="modal"
                    data-bs-target="#tambahBrandModal">

                    <i class="bi bi-plus-lg"></i>

                    Tambah Merek

                </button>

            </div>

        </div>


        <div class="row g-3 stats-row">


            <div class="col-6 col-lg-3">

                <div class="mini-stat">

                    <div class="mini-icon">

                        <i class="bi bi-award-fill"></i>

                    </div>


                    <div class="mini-label">
                        Total Merek
                    </div>


                    <div class="mini-number"
                         id="totalBrands">

                        0

                    </div>

                </div>

            </div>


            <div class="col-6 col-lg-3">

                <div class="mini-stat">

                    <div class="mini-icon">

                        <i class="bi bi-car-front-fill"></i>

                    </div>


                    <div class="mini-label">
                        Total Mobil
                    </div>


                    <div class="mini-number"
                         id="totalMobils">

                        0

                    </div>

                </div>

            </div>


            <div class="col-6 col-lg-3">

                <div class="mini-stat">

                    <div class="mini-icon">

                        <i class="bi bi-collection-fill"></i>

                    </div>


                    <div class="mini-label">
                        Brand Dengan Mobil
                    </div>


                    <div class="mini-number"
                         id="brandsUsed">

                        0

                    </div>

                </div>

            </div>


            <div class="col-6 col-lg-3">

                <div class="mini-stat">

                    <div class="mini-icon">

                        <i class="bi bi-box-seam"></i>

                    </div>


                    <div class="mini-label">
                        Belum Memiliki Mobil
                    </div>


                    <div class="mini-number"
                         id="brandsEmpty">

                        0

                    </div>

                </div>

            </div>


        </div>


        <section class="content-card">


            <div class="content-top">

                <div>

                    <h2 class="content-title">

                        Koleksi Merek

                    </h2>


                    <p class="content-subtitle">

                        Pilih merek untuk mengedit informasi
                        atau mengelola datanya.

                    </p>

                </div>


                <div class="search-box">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        id="brandSearch"
                        placeholder="Cari nama merek...">

                </div>

            </div>


            <div class="gallery-wrapper">

                <div
                    id="brandGallery"
                    class="brand-grid">

                    <div class="gallery-loading"
                         style="grid-column:1/-1;">

                        <div
                            class="spinner-border"
                            role="status">

                        </div>

                        <div class="mt-3">
                            Memuat koleksi merek...
                        </div>

                    </div>

                </div>

            </div>


            <table
                id="brands-table"
                style="display:none;">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Logo</th>

                        <th>Nama Merek</th>

                        <th>Deskripsi</th>

                        <th>Jumlah Mobil</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody></tbody>

            </table>


        </section>


    </main>


    <div
        class="modal fade"
        id="tambahBrandModal"
        tabindex="-1"
        aria-hidden="true">


        <div
            class="modal-dialog modal-dialog-centered">

            <div class="modal-content">


                <div class="modal-header">

                    <div>

                        <div class="modal-title">

                            <i
                                class="bi bi-plus-circle-fill text-success me-2">
                            </i>

                            Tambah Merek

                        </div>


                        <div class="modal-subtitle">

                            Daftarkan brand kendaraan baru

                        </div>

                    </div>


                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                    </button>

                </div>


                <form
                    id="formTambahBrand"
                    action="{{ route('brands.store') }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf


                    <div class="modal-body">


                        <div class="mb-4">

                            <label class="form-label">

                                Nama Merek

                            </label>


                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Contoh: Toyota"
                                required>

                        </div>


                        <div class="mb-4">

                            <label class="form-label">

                                Logo Merek

                            </label>


                            <div class="logo-upload">


                                <div
                                    class="upload-preview"
                                    id="addLogoPreview">

                                    <div class="upload-placeholder">

                                        <i class="bi bi-image"></i>

                                        <div>
                                            Preview Logo
                                        </div>

                                    </div>

                                </div>


                                <input
                                    type="file"
                                    name="logo"
                                    id="addLogo"
                                    class="form-control"
                                    accept=".jpg,.jpeg,.png,.svg">


                                <small class="text-muted">

                                    JPG, JPEG, PNG, SVG.
                                    Maksimal 2 MB.

                                </small>

                            </div>

                        </div>


                        <div>

                            <label class="form-label">

                                Deskripsi

                            </label>


                            <textarea
                                name="description"
                                class="form-control"
                                rows="4"
                                placeholder="Ceritakan sedikit mengenai merek ini..."></textarea>

                        </div>

                    </div>


                    <div class="modal-footer">


                        <button
                            type="button"
                            class="btn-modal-cancel"
                            data-bs-dismiss="modal">

                            Batal

                        </button>


                        <button
                            type="submit"
                            class="btn-modal-save">

                            <i class="bi bi-check-lg me-1"></i>

                            Tambah Merek

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <div
        class="modal fade"
        id="editBrandModal"
        tabindex="-1"
        aria-hidden="true">


        <div
            class="modal-dialog modal-dialog-centered">

            <div class="modal-content">


                <div class="modal-header">

                    <div>

                        <div class="modal-title">

                            <i
                                class="bi bi-pencil-square text-success me-2">
                            </i>

                            Edit Merek

                        </div>


                        <div class="modal-subtitle">

                            Perbarui informasi brand kendaraan

                        </div>

                    </div>


                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                    </button>

                </div>


                <form
                    id="formEditBrand"
                    action=""
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    @method('PUT')


                    <div class="modal-body">


                        <div class="mb-4">

                            <label class="form-label">

                                Nama Merek

                            </label>


                            <input
                                type="text"
                                name="name"
                                id="editNamaBrand"
                                class="form-control"
                                required>

                        </div>


                        <div class="mb-4">

                            <label class="form-label">

                                Logo Merek

                            </label>


                            <div class="logo-upload">


                                <div
                                    class="upload-preview"
                                    id="editLogoPreview">

                                    <div
                                        class="upload-placeholder">

                                        <i class="bi bi-image"></i>

                                        <div>
                                            Logo saat ini
                                        </div>

                                    </div>

                                </div>


                                <input
                                    type="file"
                                    name="logo"
                                    id="editLogo"
                                    class="form-control"
                                    accept=".jpg,.jpeg,.png,.svg">


                                <small class="text-muted">

                                    Kosongkan jika tidak ingin
                                    mengganti logo.

                                </small>

                            </div>

                        </div>


                        <div>

                            <label class="form-label">

                                Deskripsi

                            </label>


                            <textarea
                                name="description"
                                id="editDeskripsiBrand"
                                class="form-control"
                                rows="4"></textarea>

                        </div>

                    </div>


                    <div class="modal-footer">


                        <button
                            type="button"
                            class="btn-modal-cancel"
                            data-bs-dismiss="modal">

                            Batal

                        </button>


                        <button
                            type="submit"
                            class="btn-modal-save">

                            <i class="bi bi-check-lg me-1"></i>

                            Simpan Perubahan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js">
    </script>


    <script
        src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.8/js/dataTables.min.js">
    </script>


    <script
        src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/js/dataTables.bootstrap5.min.js">
    </script>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>


    <script
        src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    </script>


    <script>


        const CSRF_TOKEN =
            '{{ csrf_token() }}';


        let brandsData = [];

        let brandTable = null;


        function escapeHtml(value) {

            if (value === null ||
                value === undefined) {

                return '';

            }

            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');

        }


        function asset(path) {

            if (!path) {
                return '';
            }

            return '{{ asset('') }}/' +
                String(path).replace(/^\/+/, '');

        }


        function logoHtml(row) {

            if (row.logo) {

                return `
                    <img
                        src="${asset(escapeHtml(row.logo))}"
                        class="brand-logo"
                        alt="${escapeHtml(row.name)}"
                        onerror="this.outerHTML='<div class=\\'no-logo\\'><i class=\\'bi bi-award-fill\\'></i></div>';">
                `;

            }


            return `
                <div class="no-logo">

                    <i class="bi bi-award-fill"></i>

                </div>
            `;

        }


        function createBrandCard(row, index) {


            const count =
                parseInt(row.mobils_count || 0);


            const description =
                row.description ||
                'Belum ada deskripsi untuk merek ini.';


            let actionHtml = `

                <button
                    type="button"
                    class="card-action edit"
                    title="Edit Merek"
                    onclick="editBrand(${row.id})">

                    <i class="bi bi-pencil-square"></i>

                </button>

            `;


            if (count === 0) {

                actionHtml += `

                    <button
                        type="button"
                        class="card-action delete"
                        title="Hapus Merek"
                        onclick="deleteBrand(
                            ${row.id},
                            ${JSON.stringify(row.name)}
                        )">

                        <i class="bi bi-trash3"></i>

                    </button>

                `;

            } else {

                actionHtml += `

                    <button
                        type="button"
                        class="card-action locked"
                        title="Brand masih digunakan mobil"
                        disabled>

                        <i class="bi bi-lock-fill"></i>

                    </button>

                `;

            }


            return `

                <article
                    class="brand-card"
                    data-brand-name="${escapeHtml(row.name).toLowerCase()}">

                    <div class="brand-number">

                        #${String(index + 1)
                            .padStart(2, '0')}

                    </div>


                    <div class="logo-stage">

                        ${logoHtml(row)}

                    </div>


                    <h3 class="brand-card-name">

                        ${escapeHtml(row.name)}

                    </h3>


                    <div class="brand-description">

                        ${escapeHtml(description)}

                    </div>


                    <div class="brand-bottom">


                        <span class="car-count">

                            <i class="bi bi-car-front-fill"></i>

                            ${count}

                            Mobil

                        </span>


                        <div class="card-actions">

                            ${actionHtml}

                        </div>


                    </div>

                </article>

            `;

        }


        function renderGallery(data) {

            brandsData = data || [];


            const gallery =
                $('#brandGallery');


            if (!brandsData.length) {

                gallery.html(`

                    <div
                        style="grid-column:1/-1;"
                        class="gallery-loading">

                        <i
                            class="bi bi-award"
                            style="font-size:48px;opacity:.35;">
                        </i>

                        <strong
                            class="mt-3"
                            style="color:#59645d;">

                            Belum ada merek

                        </strong>

                        <span
                            class="mt-1"
                            style="font-size:11px;">

                            Tambahkan merek pertama RentalKu.

                        </span>

                    </div>

                `);

                updateStatistics([]);

                return;

            }


            let html = '';


            brandsData.forEach(
                function(row, index) {

                    html +=
                        createBrandCard(
                            row,
                            index
                        );

                }
            );


            gallery.html(html);


            updateStatistics(
                brandsData
            );

        }


        function updateStatistics(data) {

            const totalBrands =
                data.length;


            const totalMobils =
                data.reduce(
                    function(total, row) {

                        return total +
                            parseInt(
                                row.mobils_count || 0
                            );

                    },
                    0
                );


            const brandsUsed =
                data.filter(
                    function(row) {

                        return parseInt(
                            row.mobils_count || 0
                        ) > 0;

                    }
                ).length;


            const brandsEmpty =
                totalBrands -
                brandsUsed;


            $('#totalBrands')
                .text(totalBrands);


            $('#totalMobils')
                .text(totalMobils);


            $('#brandsUsed')
                .text(brandsUsed);


            $('#brandsEmpty')
                .text(brandsEmpty);

        }


        $(document).ready(function() {


            brandTable =
                $('#brands-table').DataTable({

                    processing: true,

                    serverSide: true,

                    pageLength: 1000,

                    ajax: {

                        url:
                            '{{ route("brands.data") }}',

                        dataSrc: function(json) {

                            renderGallery(
                                json.data || []
                            );

                            return json.data || [];

                        }

                    },


                    columns: [

                        {
                            data: null
                        },

                        {
                            data: 'logo'
                        },

                        {
                            data: 'name'
                        },

                        {
                            data: 'description'
                        },

                        {
                            data: 'mobils_count'
                        },

                        {
                            data: 'id'
                        }

                    ],


                    order: [
                        [2, 'asc']
                    ],


                    language: {

                        processing:
                            'Memuat...',

                        search:
                            'Cari:',

                        lengthMenu:
                            'Tampilkan _MENU_ data',

                        info:
                            'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',

                        infoEmpty:
                            'Tidak ada data',

                        infoFiltered:
                            '(difilter dari _MAX_ total data)',

                        loadingRecords:
                            'Memuat...',

                        zeroRecords:
                            'Tidak ditemukan',

                        emptyTable:
                            'Belum ada merek'

                    }

                });


            $('#brandSearch').on(
                'keyup',
                function() {

                    brandTable
                        .search(this.value)
                        .draw();

                }
            );

        });


        function editBrand(id) {


            $.ajax({

                url:
                    '{{ url("brands") }}/' + id,

                method:
                    'GET',

                headers: {

                    'Accept':
                        'application/json'

                },


                beforeSend: function() {

                    Swal.fire({

                        title:
                            'Memuat data...',

                        text:
                            'Mohon tunggu.',

                        allowOutsideClick:
                            false,

                        didOpen: function() {

                            Swal.showLoading();

                        }

                    });

                },


                success: function(data) {


                    Swal.close();


                    $('#editNamaBrand')
                        .val(data.name || '');


                    $('#editDeskripsiBrand')
                        .val(
                            data.description || ''
                        );


                    $('#formEditBrand')
                        .attr(
                            'action',
                            '{{ url("brands") }}/' + id
                        );


                    if (data.logo) {

                        $('#editLogoPreview')
                            .html(`

                                <img
                                    src="${asset(data.logo)}"
                                    alt="Logo ${escapeHtml(data.name)}">

                            `);

                    } else {

                        $('#editLogoPreview')
                            .html(`

                                <div
                                    class="upload-placeholder">

                                    <i
                                        class="bi bi-image">
                                    </i>

                                    <div>
                                        Belum ada logo
                                    </div>

                                </div>

                            `);

                    }


                    $('#editLogo')
                        .val('');


                    const modal =
                        bootstrap.Modal
                            .getOrCreateInstance(
                                document.getElementById(
                                    'editBrandModal'
                                )
                            );


                    modal.show();

                },


                error: function(xhr) {

                    Swal.fire({

                        icon:
                            'error',

                        title:
                            'Gagal',

                        text:
                            xhr.responseJSON?.message ||
                            'Data brand tidak ditemukan.'

                    });

                }

            });

        }


        function deleteBrand(id, name) {


            Swal.fire({

                title:
                    'Hapus Merek?',

                html:
                    `Merek <strong>${escapeHtml(name)}</strong>
                     akan dihapus dari sistem.`,

                icon:
                    'warning',

                showCancelButton:
                    true,

                confirmButtonText:
                    'Ya, Hapus',

                cancelButtonText:
                    'Batal',

                reverseButtons:
                    true

            }).then(
                function(result) {

                    if (!result.isConfirmed) {
                        return;
                    }


                    $.ajax({

                        url:
                            '{{ url("brands") }}/' + id,

                        method:
                            'DELETE',

                        headers: {

                            'X-CSRF-TOKEN':
                                CSRF_TOKEN,

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest'

                        },


                        beforeSend: function() {

                            Swal.fire({

                                title:
                                    'Menghapus...',

                                text:
                                    'Mohon tunggu.',

                                allowOutsideClick:
                                    false,

                                didOpen: function() {

                                    Swal.showLoading();

                                }

                            });

                        },


                        success: function(res) {


                            Swal.fire({

                                icon:
                                    'success',

                                title:
                                    'Berhasil',

                                text:
                                    res.message ||
                                    'Merek berhasil dihapus.',

                                timer:
                                    1700,

                                showConfirmButton:
                                    false

                            });


                            brandTable
                                .ajax
                                .reload();

                        },


                        error: function(xhr) {

                            const response =
                                xhr.responseJSON || {};


                            Swal.fire({

                                icon:
                                    'error',

                                title:
                                    'Tidak Dapat Dihapus',

                                text:
                                    response.message ||
                                    'Terjadi kesalahan saat menghapus merek.'

                            });

                        }

                    });

                }
            );

        }


        $(document).on(
            'submit',
            '#formTambahBrand',
            function(e) {

                e.preventDefault();


                const form =
                    this;


                const formData =
                    new FormData(form);


                $.ajax({

                    url:
                        $(form).attr('action'),

                    method:
                        'POST',

                    data:
                        formData,

                    processData:
                        false,

                    contentType:
                        false,

                    headers: {

                        'X-CSRF-TOKEN':
                            CSRF_TOKEN,

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest'

                    },


                    beforeSend: function() {

                        Swal.fire({

                            title:
                                'Menyimpan...',

                            text:
                                'Menambahkan merek baru.',

                            allowOutsideClick:
                                false,

                            didOpen: function() {

                                Swal.showLoading();

                            }

                        });

                    },


                    success: function(result) {


                        const modal =
                            bootstrap.Modal
                                .getInstance(
                                    document.getElementById(
                                        'tambahBrandModal'
                                    )
                                );


                        if (modal) {
                            modal.hide();
                        }


                        form.reset();


                        $('#addLogoPreview')
                            .html(`

                                <div
                                    class="upload-placeholder">

                                    <i
                                        class="bi bi-image">
                                    </i>

                                    <div>
                                        Preview Logo
                                    </div>

                                </div>

                            `);


                        brandTable
                            .ajax
                            .reload();


                        Swal.fire({

                            icon:
                                'success',

                            title:
                                'Berhasil',

                            text:
                                result.message ||
                                'Merek berhasil ditambahkan.',

                            timer:
                                1700,

                            showConfirmButton:
                                false

                        });

                    },


                    error: function(xhr) {

                        const r =
                            xhr.responseJSON || {};


                        let msg =
                            'Terjadi kesalahan saat menambahkan merek.';


                        if (r.errors) {

                            const first =
                                Object.values(
                                    r.errors
                                )[0];

                            if (
                                Array.isArray(first) &&
                                first.length
                            ) {

                                msg =
                                    first[0];

                            }

                        } else if (r.message) {

                            msg =
                                r.message;

                        }


                        Swal.fire({

                            icon:
                                'error',

                            title:
                                'Gagal',

                            text:
                                msg

                        });

                    }

                });

            }
        );


        $(document).on(
            'submit',
            '#formEditBrand',
            function(e) {

                e.preventDefault();


                const form =
                    this;


                const formData =
                    new FormData(form);


                $.ajax({

                    url:
                        $(form).attr('action'),

                    method:
                        'POST',

                    data:
                        formData,

                    processData:
                        false,

                    contentType:
                        false,

                    headers: {

                        'X-CSRF-TOKEN':
                            CSRF_TOKEN,

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest'

                    },


                    beforeSend: function() {

                        Swal.fire({

                            title:
                                'Menyimpan...',

                            text:
                                'Memperbarui data merek.',

                            allowOutsideClick:
                                false,

                            didOpen: function() {

                                Swal.showLoading();

                            }

                        });

                    },


                    success: function(result) {


                        const modal =
                            bootstrap.Modal
                                .getInstance(
                                    document.getElementById(
                                        'editBrandModal'
                                    )
                                );


                        if (modal) {
                            modal.hide();
                        }


                        $('#editLogo')
                            .val('');


                        brandTable
                            .ajax
                            .reload();


                        Swal.fire({

                            icon:
                                'success',

                            title:
                                'Berhasil',

                            text:
                                result.message ||
                                'Merek berhasil diperbarui.',

                            timer:
                                1700,

                            showConfirmButton:
                                false

                        });

                    },


                    error: function(xhr) {

                        const r =
                            xhr.responseJSON || {};


                        let msg =
                            'Terjadi kesalahan saat memperbarui merek.';


                        if (r.errors) {

                            const first =
                                Object.values(
                                    r.errors
                                )[0];

                            if (
                                Array.isArray(first) &&
                                first.length
                            ) {

                                msg =
                                    first[0];

                            }

                        } else if (r.message) {

                            msg =
                                r.message;

                        }


                        Swal.fire({

                            icon:
                                'error',

                            title:
                                'Gagal',

                            text:
                                msg

                        });

                    }

                });

            }
        );


        $('#addLogo').on(
            'change',
            function() {

                const file =
                    this.files[0];


                if (!file) {

                    $('#addLogoPreview')
                        .html(`

                            <div
                                class="upload-placeholder">

                                <i
                                    class="bi bi-image">
                                </i>

                                <div>
                                    Preview Logo
                                </div>

                            </div>

                        `);

                    return;

                }


                const reader =
                    new FileReader();


                reader.onload =
                    function(e) {

                        $('#addLogoPreview')
                            .html(`

                                <img
                                    src="${e.target.result}"
                                    alt="Preview Logo">

                            `);

                    };


                reader.readAsDataURL(file);

            }
        );


        $('#editLogo').on(
            'change',
            function() {

                const file =
                    this.files[0];


                if (!file) {
                    return;
                }


                const reader =
                    new FileReader();


                reader.onload =
                    function(e) {

                        $('#editLogoPreview')
                            .html(`

                                <img
                                    src="${e.target.result}"
                                    alt="Preview Logo Baru">

                            `);

                    };


                reader.readAsDataURL(file);

            }
        );


        $('#tambahBrandModal').on(
            'hidden.bs.modal',
            function() {

                $('#formTambahBrand')[0]
                    .reset();


                $('#addLogoPreview')
                    .html(`

                        <div
                            class="upload-placeholder">

                            <i
                                class="bi bi-image">
                            </i>

                            <div>
                                Preview Logo
                            </div>

                        </div>

                    `);

            }
        );


    </script>


</body>

</html>
