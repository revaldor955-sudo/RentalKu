<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pembayaran - RentalKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        body {
            background: #f5f7f6;
            color: #1f2937;
            font-family: Arial, Helvetica, sans-serif;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #e9ecef;
        }

        .brand {
            font-size: 27px;
            font-weight: 800;
            color: #1f2937;
        }

        .brand span {
            color: #198754;
        }

        .payment-wrapper {
            max-width: 900px;
            margin: 50px auto;
        }

        .payment-card {
            background: white;
            border-radius: 22px;
            border: 1px solid #edf0ee;
            box-shadow: 0 10px 30px rgba(0,0,0,.06);
            overflow: hidden;
        }

        .payment-header {
            background: linear-gradient(
                110deg,
                #08462a,
                #198754
            );
            color: white;
            padding: 30px;
        }

        .payment-header h2 {
            font-weight: 800;
            margin-bottom: 5px;
        }

        .payment-header p {
            margin: 0;
            color: #dff5e8;
        }

        .payment-body {
            padding: 30px;
        }

        .rental-info {
            background: #f5f8f6;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .rental-info h5 {
            font-weight: 800;
            margin-bottom: 15px;
        }

        .info-label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 3px;
        }

        .info-value {
            font-weight: 700;
        }

        .total-box {
            background: #e9f7ef;
            border-radius: 14px;
            padding: 16px;
            margin-top: 15px;
        }

        .total-price {
            color: #198754;
            font-size: 24px;
            font-weight: 800;
        }

        .form-label {
            font-weight: 700;
        }

        .form-control,
        .form-select {
            border-radius: 11px;
            padding: 11px 13px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 .2rem rgba(25,135,84,.12);
        }

        .payment-method {
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 10px;
        }

        .payment-method:hover {
            border-color: #198754;
            background: #f8fffa;
        }

        .payment-method strong {
            display: block;
        }

        .payment-method small {
            color: #6b7280;
        }

        .btn-payment {
            background: #198754;
            border: none;
            color: white;
            border-radius: 11px;
            padding: 12px 20px;
            font-weight: 700;
        }

        .btn-payment:hover {
            background: #146c43;
            color: white;
        }

        .btn-back {
            border-radius: 11px;
            padding: 11px 20px;
        }

        .preview-image {
            max-width: 250px;
            max-height: 250px;
            object-fit: cover;
            border-radius: 12px;
            margin-top: 12px;
            display: none;
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="container py-3">

        <a href="{{ route('customer.dashboard') }}"
           class="text-decoration-none brand">
            Rental<span>ku</span>.
        </a>

    </div>
</nav>


<div class="container">

    <div class="payment-wrapper">

        <div class="payment-card">

            {{-- HEADER --}}
            <div class="payment-header">

                <h2>
                    <i class="bi bi-credit-card me-2"></i>
                    Pembayaran Rental
                </h2>

                <p>
                    Silakan lengkapi pembayaran untuk rental kendaraanmu.
                </p>

            </div>


            <div class="payment-body">

                {{-- ERROR --}}
                @if($errors->any())

                    <div class="alert alert-danger">

                        <strong>
                            Terdapat kesalahan:
                        </strong>

                        <ul class="mb-0 mt-2">

                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- INFORMASI RENTAL --}}
                <div class="rental-info">

                    <h5>
                        <i class="bi bi-car-front-fill text-success me-2"></i>
                        Informasi Rental
                    </h5>

                    <div class="row g-3">

                        <div class="col-md-6">

                            <div class="info-label">
                                Mobil
                            </div>

                            <div class="info-value">
                                {{ $rental->mobil->name ?? 'Mobil' }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="info-label">
                                Nomor Rental
                            </div>

                            <div class="info-value">
                                #{{ $rental->id }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="info-label">
                                Tanggal Mulai
                            </div>

                            <div class="info-value">
                                {{ $rental->tanggal_mulai->format('d/m/Y') }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="info-label">
                                Tanggal Selesai
                            </div>

                            <div class="info-value">
                                {{ $rental->tanggal_selesai->format('d/m/Y') }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="info-label">
                                Jumlah Hari
                            </div>

                            <div class="info-value">
                                {{ $rental->jumlah_hari }} Hari
                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="info-label">
                                Status Rental
                            </div>

                            <span class="badge bg-success">
                                {{ $rental->status }}
                            </span>

                        </div>

                    </div>


                    <div class="total-box">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="info-label">
                                    Total yang harus dibayar
                                </div>

                                <div class="total-price">
                                    Rp {{ number_format($rental->total_harga, 0, ',', '.') }}
                                </div>

                            </div>

                            <i class="bi bi-wallet2 text-success fs-1"></i>

                        </div>

                    </div>

                </div>


                {{-- FORM PEMBAYARAN --}}
                <form
                    action="{{ route('pembayaran.store', $rental->id) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf


                    {{-- METODE PEMBAYARAN --}}
                    <div class="mb-4">

                        <label class="form-label">
                            Metode Pembayaran
                        </label>

                        <select
                            name="metode_pembayaran_id"
                            id="metodeSelect"
                            class="form-select @error('metode_pembayaran_id') is-invalid @enderror"
                            required
                        >

                            <option value="">
                                -- Pilih Metode Pembayaran --
                            </option>

                            @foreach($metodePembayarans as $metode)

                                <option
                                    value="{{ $metode->id }}"
                                    {{ old('metode_pembayaran_id') == $metode->id ? 'selected' : '' }}
                                >

                                    {{ $metode->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('metode_pembayaran_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- DETAIL METODE --}}
                    @if($metodePembayarans->count())

                        <div class="mb-4" id="metodeDetail">

                            <label class="form-label">
                                Rekening / Akun Pembayaran
                            </label>

                            @foreach($metodePembayarans as $metode)

                                <div
                                    class="payment-method metode-detail d-none"
                                    id="metode-{{ $metode->id }}"
                                >

                                    <strong>
                                        <i class="bi bi-wallet2 text-success me-2"></i>
                                        {{ $metode->name }}
                                    </strong>

                                    <small>
                                        Nomor akun:
                                        <strong>
                                            {{ $metode->nomor_akun }}
                                        </strong>
                                    </small>

                                </div>

                            @endforeach

                            <div class="payment-method" id="metode-placeholder">

                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Pilih metode pembayaran untuk melihat
                                    nomor rekening / akun.
                                </small>

                            </div>

                        </div>

                    @endif


                    {{-- TANGGAL BAYAR --}}
                    <div class="mb-4">

                        <label class="form-label">
                            Tanggal Pembayaran
                        </label>

                        <input
                            type="date"
                            name="tanggal_bayar"
                            class="form-control @error('tanggal_bayar') is-invalid @enderror"
                            value="{{ old('tanggal_bayar', date('Y-m-d')) }}"
                            required
                        >

                        @error('tanggal_bayar')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- BUKTI PEMBAYARAN --}}
                    <div class="mb-4">

                        <label class="form-label">
                            Bukti Pembayaran
                        </label>

                        <input
                            type="file"
                            name="bukti"
                            id="bukti"
                            class="form-control @error('bukti') is-invalid @enderror"
                            accept=".jpg,.jpeg,.png"
                            required
                        >

                        <div class="form-text">
                            Format JPG, JPEG, atau PNG. Maksimal 2 MB.
                        </div>

                        @error('bukti')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror


                        <img
                            id="preview"
                            class="preview-image"
                            alt="Preview bukti pembayaran"
                        >

                    </div>


                    {{-- INFO --}}
                    <div class="alert alert-warning">

                        <i class="bi bi-info-circle me-2"></i>

                        Pastikan bukti pembayaran yang diupload
                        terlihat jelas dan sesuai dengan jumlah
                        pembayaran sebesar

                        <strong>
                            Rp {{ number_format($rental->total_harga, 0, ',', '.') }}
                        </strong>.

                    </div>


                    {{-- BUTTON --}}
                    <div class="d-flex justify-content-between gap-2 mt-4">

                        <a
                            href="{{ route('customer.dashboard') }}"
                            class="btn btn-outline-secondary btn-back"
                        >
                            <i class="bi bi-arrow-left me-1"></i>
                            Kembali
                        </a>


                        <button
                            type="submit"
                            class="btn btn-payment"
                        >

                            <i class="bi bi-send me-1"></i>

                            Kirim Pembayaran

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


<script>

document.getElementById('metodeSelect').addEventListener('change', function() {

    const select = document.getElementById('metodeSelect');
    const detailBox = document.getElementById('metodeDetail');
    const placeholder = document.getElementById('metode-placeholder');

    if (!detailBox) {
        return;
    }

    const selectedId = select.value;

    detailBox.querySelectorAll('.metode-detail').forEach(function(el) {
        el.classList.add('d-none');
    });

    if (selectedId) {

        const target = document.getElementById('metode-' + selectedId);

        if (target) {
            target.classList.remove('d-none');
        }

        if (placeholder) {
            placeholder.classList.add('d-none');
        }

    } else if (placeholder) {

        placeholder.classList.remove('d-none');

    }

});

showMetodeDetail();

function showMetodeDetail() {

    const select = document.getElementById('metodeSelect');

    if (!select) {
        return;
    }

    select.dispatchEvent(new Event('change'));

}

document.getElementById('bukti').addEventListener('change', function(event) {

    const file = event.target.files[0];

    const preview = document.getElementById('preview');

    if (file) {

        preview.src = URL.createObjectURL(file);

        preview.style.display = 'block';

    } else {

        preview.style.display = 'none';

    }

});

</script>

</body>
</html>