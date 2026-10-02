<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Pesan - RentalKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body {
            background: #f5f7f8;
            font-family: Arial, Helvetica, sans-serif;
        }

        .card-custom {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        .page-title {
            color: #172033;
            font-weight: 700;
        }

        .message-box {
            background: #f7f9fa;
            border-radius: 12px;
            padding: 22px;
            white-space: pre-line;
            line-height: 1.8;
            color: #4b5563;
        }

        .reply-box {
            background: #eef8f5;
            border-radius: 12px;
            padding: 22px;
            border-left: 4px solid #2c666e;
            white-space: pre-line;
            line-height: 1.8;
            color: #4b5563;
        }

        .btn-rental {
            background: #2c666e;
            color: white;
            border: none;
        }

        .btn-rental:hover {
            background: #24555c;
            color: white;
        }

        .info-label {
            font-size: 13px;
            color: #7a8491;
            margin-bottom: 3px;
        }

        .info-value {
            font-weight: 600;
            color: #172033;
        }

    </style>

</head>

<body>

<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <div class="text-success fw-bold mb-1">
                HUBUNGI KAMI
            </div>

            <h2 class="page-title mb-0">
                Detail Pesan
            </h2>

        </div>

        <a
            href="{{ route('contacts.index') }}"
            class="btn btn-outline-secondary"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Kembali

        </a>

    </div>


    {{-- Alert --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <div class="row g-4">

        {{-- Pesan --}}
        <div class="col-lg-7">

            <div class="card-custom">

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-envelope me-2 text-success"></i>
                    Pesan Pengunjung
                </h5>


                <div class="row g-3 mb-4">

                    <div class="col-md-6">

                        <div class="info-label">
                            Nama
                        </div>

                        <div class="info-value">
                            {{ $contact->nama }}
                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="info-label">
                            Email
                        </div>

                        <div class="info-value">
                            {{ $contact->email }}
                        </div>

                    </div>


                    <div class="col-12">

                        <div class="info-label">
                            Subjek
                        </div>

                        <div class="info-value">
                            {{ $contact->subjek }}
                        </div>

                    </div>


                    <div class="col-12">

                        <div class="info-label">
                            Dikirim pada
                        </div>

                        <div class="info-value">
                            {{ $contact->created_at->format('d F Y, H:i') }}
                        </div>

                    </div>

                </div>


                <div class="info-label mb-2">
                    Isi Pesan
                </div>

                <div class="message-box">
                    {{ $contact->pesan }}
                </div>

            </div>

        </div>


        {{-- Balasan --}}
        <div class="col-lg-5">

            <div class="card-custom">

                <h5 class="fw-bold mb-4">

                    <i class="bi bi-reply me-2 text-success"></i>

                    Balasan

                </h5>


                @if($contact->balasan)

                    <div class="reply-box mb-3">

                        {{ $contact->balasan }}

                    </div>

                    <div class="small text-muted mb-4">

                        <i class="bi bi-check-circle me-1"></i>

                        Dibalas pada:

                        {{ $contact->dibalas_pada?->format('d F Y, H:i') }}

                    </div>

                @endif


                <form
                    action="{{ route('contacts.reply', $contact) }}"
                    method="POST"
                >

                    @csrf


                    <div class="mb-3">

                        <label
                            for="balasan"
                            class="form-label fw-semibold"
                        >
                            {{ $contact->balasan ? 'Kirim Balasan Baru' : 'Tulis Balasan' }}
                        </label>

                        <textarea
                            name="balasan"
                            id="balasan"
                            rows="8"
                            class="form-control"
                            placeholder="Tulis balasan untuk {{ $contact->nama }}..."
                            required
                        ></textarea>

                        @error('balasan')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <button
                        type="submit"
                        class="btn btn-rental w-100 py-2"
                        onclick="return confirm('Kirim balasan ke {{ $contact->email }}?')"
                    >

                        <i class="bi bi-send me-2"></i>

                        Kirim Balasan ke Email

                    </button>

                </form>

            </div>


            {{-- Hapus --}}
            <div class="card-custom mt-4">

                <h6 class="fw-bold">
                    Hapus Pesan
                </h6>

                <p class="text-muted small">
                    Pesan akan dihapus secara permanen dari sistem.
                </p>

                <form
                    action="{{ route('contacts.destroy', $contact) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus pesan ini?')"
                >

                    @csrf

                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-outline-danger w-100"
                    >

                        <i class="bi bi-trash me-2"></i>

                        Hapus Pesan

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>