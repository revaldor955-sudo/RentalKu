
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manajemen FAQ - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --rk-green: #20c77a;
            --rk-dark: #15251f;
            --rk-bg: #f5f7f6;
            --rk-border: #e9eeeb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--rk-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #26352e;
        }

        .page-wrapper {
            padding: 36px 28px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 800;
            color: var(--rk-dark);
            margin: 0;
        }

        .page-subtitle {
            color: #89958e;
            font-size: 13px;
            margin-top: 8px;
        }

        .btn-green {
            background: var(--rk-green);
            border: none;
            color: #fff;
            padding: 13px 20px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 13px;
            transition: .2s;
        }

        .btn-green:hover {
            background: #16a966;
            color: #fff;
            transform: translateY(-1px);
        }

        .stat-card {
            background: #fff;
            border: 1px solid var(--rk-border);
            border-radius: 18px;
            padding: 22px;
            height: 100%;
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: #e6faef;
            color: #18ad68;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            margin-bottom: 18px;
        }

        .stat-label {
            font-size: 12px;
            color: #8a978f;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .stat-number {
            font-size: 27px;
            font-weight: 800;
            color: var(--rk-dark);
        }

        .content-card {
            background: #fff;
            border: 1px solid var(--rk-border);
            border-radius: 20px;
            overflow: hidden;
        }

        .card-heading {
            padding: 24px 26px;
            border-bottom: 1px solid var(--rk-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .card-heading h5 {
            font-size: 16px;
            font-weight: 800;
            margin: 0;
        }

        .table-responsive {
            width: 100%;
        }

        .table {
            margin: 0;
            min-width: 850px;
        }

        .table thead th {
            background: #f9fbfa;
            color: #8b9890;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 18px 22px;
            border-bottom: 1px solid var(--rk-border);
            white-space: nowrap;
        }

        .table tbody td {
            padding: 20px 22px;
            vertical-align: middle;
            font-size: 13px;
            border-bottom: 1px solid #f0f3f1;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background: #fcfefd;
        }

        .number-badge {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #effaf4;
            color: #18a965;
            border-radius: 10px;
            font-weight: 800;
            font-size: 12px;
        }

        .question-text {
            font-weight: 700;
            color: #26352e;
            max-width: 280px;
            line-height: 1.6;
        }

        .answer-text {
            color: #87948c;
            max-width: 300px;
            line-height: 1.7;
        }

        .order-badge {
            background: #f1f4f2;
            color: #6d7c72;
            border-radius: 8px;
            padding: 6px 10px;
            font-weight: 700;
            font-size: 11px;
        }

        .action-group {
            display: flex;
            gap: 7px;
        }

        .btn-action {
            width: 35px;
            height: 35px;
            border: none;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: .2s;
        }

        .btn-edit {
            background: #fff5df;
            color: #e3a329;
        }

        .btn-edit:hover {
            background: #ffe8b6;
        }

        .btn-delete {
            background: #fff0f0;
            color: #e25e5e;
        }

        .btn-delete:hover {
            background: #ffdede;
        }

        .empty-state {
            padding: 70px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 65px;
            height: 65px;
            background: #effaf4;
            color: #20c77a;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .empty-state h6 {
            font-weight: 800;
            font-size: 16px;
        }

        .empty-state p {
            color: #9aa69f;
            font-size: 13px;
        }

        .modal-content {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .modal-header {
            padding: 24px 28px;
            border-bottom: 1px solid var(--rk-border);
        }

        .modal-title {
            font-size: 17px;
            font-weight: 800;
            color: var(--rk-dark);
        }

        .modal-body {
            padding: 28px;
        }

        .form-label {
            font-size: 12px;
            font-weight: 800;
            color: #425148;
            margin-bottom: 9px;
        }

        .form-control {
            border: 1px solid #e1e9e4;
            border-radius: 11px;
            padding: 12px 14px;
            font-size: 13px;
            font-family: inherit;
        }

        .form-control:focus {
            border-color: var(--rk-green);
            box-shadow: 0 0 0 3px rgba(32, 199, 122, .1);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .modal-footer {
            padding: 18px 28px;
            border-top: 1px solid var(--rk-border);
        }

        .btn-cancel {
            border: 1px solid #e1e9e4;
            background: #fff;
            color: #65746b;
            border-radius: 11px;
            padding: 12px 18px;
            font-size: 12px;
            font-weight: 700;
        }

        .btn-submit {
            border: none;
            background: var(--rk-green);
            color: #fff;
            border-radius: 11px;
            padding: 12px 22px;
            font-size: 12px;
            font-weight: 700;
        }

        .btn-submit:hover {
            background: #16a966;
            color: #fff;
        }

        .alert {
            border: none;
            border-radius: 13px;
            font-size: 13px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .page-wrapper {
                padding: 25px 15px;
            }

            .page-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .page-title {
                font-size: 23px;
            }

            .card-heading {
                padding: 20px;
            }

            .modal-body {
                padding: 22px;
            }

            .modal-header,
            .modal-footer {
                padding: 20px 22px;
            }
        }
    </style>
</head>

<body>

    @include('layouts.partials.admin-navbar')

    <main class="page-wrapper">

        {{-- HEADER --}}
        <div class="page-header">

            <div>
                <h1 class="page-title">
                    Manajemen FAQ
                </h1>

                <p class="page-subtitle">
                    Kelola pertanyaan dan jawaban yang ditampilkan pada website RentalKu.
                </p>
            </div>

            <button type="button"
                class="btn btn-green"
                data-bs-toggle="modal"
                data-bs-target="#modalTambah">

                <i class="bi bi-plus-lg me-2"></i>
                Tambah FAQ

            </button>

        </div>


        {{-- ALERT SUCCESS --}}
        @if (session('success'))

            <div class="alert alert-success alert-dismissible fade show mb-4"
                role="alert">

                <i class="bi bi-check-circle-fill me-2"></i>

                {{ session('success') }}

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- ALERT ERROR --}}
        @if ($errors->any())

            <div class="alert alert-danger alert-dismissible fade show mb-4"
                role="alert">

                <strong>
                    <i class="bi bi-exclamation-circle me-2"></i>
                    Terdapat kesalahan:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- STATISTIC --}}
        <div class="row g-4 mb-4">

            <div class="col-md-4">

                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-question-circle"></i>
                    </div>

                    <div class="stat-label">
                        TOTAL FAQ
                    </div>

                    <div class="stat-number">
                        {{ $faqs->count() }}
                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-chat-left-text"></i>
                    </div>

                    <div class="stat-label">
                        DATA PERTANYAAN
                    </div>

                    <div class="stat-number">
                        {{ $faqs->count() }}
                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-check2-circle"></i>
                    </div>

                    <div class="stat-label">
                        STATUS
                    </div>

                    <div class="stat-number"
                        style="font-size: 20px; padding-top: 5px;">

                        Aktif

                    </div>

                </div>

            </div>

        </div>


        {{-- TABLE --}}
        <div class="content-card">

            <div class="card-heading">

                <div>

                    <h5>
                        <i class="bi bi-list-check me-2"
                            style="color: #20c77a;"></i>

                        Daftar Pertanyaan FAQ

                    </h5>

                    <small class="text-muted"
                        style="font-size: 11px;">

                        Kelola seluruh FAQ RentalKu

                    </small>

                </div>

                <span class="badge rounded-pill"
                    style="background: #e7f9ef; color: #16a966; padding: 9px 13px;">

                    {{ $faqs->count() }} Data

                </span>

            </div>


            @if ($faqs->count() > 0)

                <div class="table-responsive">

                    <table class="table">

                        <thead>

                            <tr>

                                <th style="width: 80px;">
                                    No
                                </th>

                                <th>
                                    Pertanyaan
                                </th>

                                <th>
                                    Jawaban
                                </th>

                                <th style="width: 100px;">
                                    Urutan
                                </th>

                                <th style="width: 130px;">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($faqs as $faq)

                                <tr>

                                    <td>

                                        <span class="number-badge">

                                            {{ $loop->iteration }}

                                        </span>

                                    </td>


                                    <td>

                                        <div class="question-text">

                                            {{ $faq->pertanyaan }}

                                        </div>

                                    </td>


                                    <td>

                                        <div class="answer-text">

                                            {{ $faq->jawaban }}

                                        </div>

                                    </td>


                                    <td>

                                        <span class="order-badge">

                                            {{ $faq->urutan ?? 0 }}

                                        </span>

                                    </td>


                                    <td>

                                        <div class="action-group">

                                            {{-- EDIT --}}

                                            <button type="button"
                                                class="btn-action btn-edit"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEdit{{ $faq->id }}"
                                                title="Edit FAQ">

                                                <i class="bi bi-pencil-square"></i>

                                            </button>


                                            {{-- DELETE --}}

                                            <button type="button"
                                                class="btn-action btn-delete"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalHapus{{ $faq->id }}"
                                                title="Hapus FAQ">

                                                <i class="bi bi-trash3"></i>

                                            </button>

                                        </div>

                                    </td>

                                </tr>


                                {{-- MODAL EDIT --}}

                                <div class="modal fade"
                                    id="modalEdit{{ $faq->id }}"
                                    tabindex="-1"
                                    aria-hidden="true">

                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content">

                                            <div class="modal-header">

                                                <h5 class="modal-title">

                                                    <i class="bi bi-pencil-square me-2"
                                                        style="color: #20c77a;"></i>

                                                    Edit FAQ

                                                </h5>

                                                <button type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal">
                                                </button>

                                            </div>


                                            <form action="{{ route('faqs.update', $faq->id) }}"
                                                method="POST">

                                                @csrf

                                                @method('PUT')


                                                <div class="modal-body">

                                                    <div class="mb-3">

                                                        <label class="form-label">
                                                            Pertanyaan
                                                        </label>

                                                        <textarea name="pertanyaan"
                                                            class="form-control"
                                                            rows="3"
                                                            required>{{ old('pertanyaan', $faq->pertanyaan) }}</textarea>

                                                    </div>


                                                    <div class="mb-3">

                                                        <label class="form-label">
                                                            Jawaban
                                                        </label>

                                                        <textarea name="jawaban"
                                                            class="form-control"
                                                            rows="5"
                                                            required>{{ old('jawaban', $faq->jawaban) }}</textarea>

                                                    </div>


                                                    <div class="mb-2">

                                                        <label class="form-label">
                                                            Urutan
                                                        </label>

                                                        <input type="number"
                                                            name="urutan"
                                                            class="form-control"
                                                            min="0"
                                                            value="{{ old('urutan', $faq->urutan ?? 0) }}">

                                                    </div>

                                                </div>


                                                <div class="modal-footer">

                                                    <button type="button"
                                                        class="btn-cancel"
                                                        data-bs-dismiss="modal">

                                                        Batal

                                                    </button>

                                                    <button type="submit"
                                                        class="btn-submit">

                                                        <i class="bi bi-check-lg me-1"></i>

                                                        Simpan Perubahan

                                                    </button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>


                                {{-- MODAL HAPUS --}}

                                <div class="modal fade"
                                    id="modalHapus{{ $faq->id }}"
                                    tabindex="-1"
                                    aria-hidden="true">

                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content">

                                            <div class="modal-header">

                                                <h5 class="modal-title">

                                                    <i class="bi bi-trash3 me-2"
                                                        style="color: #e25e5e;"></i>

                                                    Hapus FAQ

                                                </h5>

                                                <button type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal">
                                                </button>

                                            </div>


                                            <div class="modal-body text-center">

                                                <div style="font-size: 45px; color: #e25e5e; margin-bottom: 15px;">

                                                    <i class="bi bi-exclamation-circle"></i>

                                                </div>

                                                <h6 style="font-weight: 800;">

                                                    Yakin ingin menghapus FAQ ini?

                                                </h6>

                                                <p class="text-muted"
                                                    style="font-size: 13px; line-height: 1.7;">

                                                    Data FAQ yang dihapus tidak dapat dikembalikan.

                                                </p>

                                                <div class="p-3 rounded-3 text-start"
                                                    style="background: #fff7f7;">

                                                    <small style="font-size: 12px; color: #9a7777;">

                                                        {{ $faq->pertanyaan }}

                                                    </small>

                                                </div>

                                            </div>


                                            <div class="modal-footer">

                                                <button type="button"
                                                    class="btn-cancel"
                                                    data-bs-dismiss="modal">

                                                    Batal

                                                </button>


                                                <form action="{{ route('faqs.destroy', $faq->id) }}"
                                                    method="POST">

                                                    @csrf

                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="btn-submit"
                                                        style="background: #e25e5e;">

                                                        <i class="bi bi-trash3 me-1"></i>

                                                        Hapus FAQ

                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="empty-state">

                    <div class="empty-icon">

                        <i class="bi bi-question-circle"></i>

                    </div>

                    <h6>

                        Belum Ada Data FAQ

                    </h6>

                    <p>

                        Tambahkan pertanyaan dan jawaban pertama untuk website RentalKu.

                    </p>

                    <button type="button"
                        class="btn btn-green mt-2"
                        data-bs-toggle="modal"
                        data-bs-target="#modalTambah">

                        <i class="bi bi-plus-lg me-2"></i>

                        Tambah FAQ

                    </button>

                </div>

            @endif

        </div>

    </main>


    {{-- MODAL TAMBAH --}}

    <div class="modal fade"
        id="modalTambah"
        tabindex="-1"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="bi bi-plus-circle me-2"
                            style="color: #20c77a;"></i>

                        Tambah FAQ Baru

                    </h5>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>


                <form action="{{ route('faqs.store') }}"
                    method="POST">

                    @csrf


                    <div class="modal-body">

                        <div class="mb-3">

                            <label class="form-label">

                                Pertanyaan

                                <span style="color: #e25e5e;">*</span>

                            </label>

                            <textarea name="pertanyaan"
                                class="form-control"
                                rows="3"
                                placeholder="Contoh: Bagaimana cara menyewa mobil di RentalKu?"
                                required>{{ old('pertanyaan') }}</textarea>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">

                                Jawaban

                                <span style="color: #e25e5e;">*</span>

                            </label>

                            <textarea name="jawaban"
                                class="form-control"
                                rows="5"
                                placeholder="Tuliskan jawaban untuk pertanyaan tersebut..."
                                required>{{ old('jawaban') }}</textarea>

                        </div>


                        <div class="mb-2">

                            <label class="form-label">

                                Urutan Tampilan

                            </label>

                            <input type="number"
                                name="urutan"
                                class="form-control"
                                min="0"
                                value="{{ old('urutan', 0) }}"
                                placeholder="0">

                            <small class="text-muted"
                                style="font-size: 11px;">

                                Angka lebih kecil akan ditampilkan terlebih dahulu.

                            </small>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button"
                            class="btn-cancel"
                            data-bs-dismiss="modal">

                            Batal

                        </button>

                        <button type="submit"
                            class="btn-submit">

                            <i class="bi bi-check-lg me-1"></i>

                            Simpan FAQ

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>