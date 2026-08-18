<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sewa {{ $mobil->name }} - RentalKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h3 class="fw-bold mb-1">
                        <i class="bi bi-car-front text-success me-2"></i>
                        Sewa Mobil
                    </h3>

                    <p class="text-muted">
                        Silakan tentukan tanggal rental mobil.
                    </p>

                    <hr>

                    {{-- DATA MOBIL --}}
                    <div class="d-flex gap-3 align-items-center mb-4">

                        @if($mobil->image)

                            <img
                                src="{{ asset($mobil->image) }}"
                                width="140"
                                height="100"
                                class="rounded-3"
                                style="object-fit: cover;">

                        @else

                            <div
                                class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                                style="width:140px;height:100px;">

                                <i class="bi bi-car-front fs-1 text-muted"></i>

                            </div>

                        @endif

                        <div>

                            <h5 class="fw-bold mb-1">
                                {{ $mobil->name }}
                            </h5>

                            <div class="text-muted">
                                {{ $mobil->brand?->name ?? '-' }}
                                •
                                {{ $mobil->tipeMobil?->name ?? '-' }}
                            </div>

                            <div class="text-success fw-bold mt-2">
                                Rp {{ number_format($mobil->harga_perhari, 0, ',', '.') }}
                                / hari
                            </div>

                        </div>

                    </div>


                    {{-- ERROR --}}
                    @if($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                            </ul>

                        </div>

                    @endif


                    {{-- FORM --}}
                    <form
                        action="{{ route('rentals.store', $mobil->id) }}"
                        method="POST">

                        @csrf

                        <div class="row g-4">

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Tanggal Mulai
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_mulai"
                                    class="form-control"
                                    min="{{ date('Y-m-d') }}"
                                    value="{{ old('tanggal_mulai') }}"
                                    required>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Tanggal Selesai
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_selesai"
                                    class="form-control"
                                    min="{{ date('Y-m-d') }}"
                                    value="{{ old('tanggal_selesai') }}"
                                    required>

                            </div>


                            <div class="col-12">

                                <label class="form-label fw-semibold">
                                    Catatan
                                </label>

                                <textarea
                                    name="catatan"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Catatan tambahan jika diperlukan...">{{ old('catatan') }}</textarea>

                            </div>


                            <div class="col-12">

                                <div class="alert alert-success">

                                    <div class="fw-bold">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Informasi Rental
                                    </div>

                                    <small>
                                        Harga rental dihitung berdasarkan jumlah hari.
                                        Deposit akan ditambahkan ke total pembayaran.
                                    </small>

                                </div>

                            </div>


                            <div class="col-12 d-flex justify-content-between">

                                <a
                                    href="{{ route('mobils.show', $mobil->id) }}"
                                    class="btn btn-outline-secondary">

                                    <i class="bi bi-arrow-left me-1"></i>
                                    Kembali

                                </a>

                                <button
                                    type="submit"
                                    class="btn btn-success px-4">

                                    <i class="bi bi-calendar-check me-1"></i>
                                    Ajukan Sewa

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>