<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Beri Rating - RentalKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

    <div class="container py-5">

        <div
            class="card border-0 shadow-sm mx-auto"
            style="max-width: 600px;"
        >

            <div class="card-body p-4">

                <h3 class="fw-bold mb-2">
                    <i class="bi bi-star-fill text-warning me-2"></i>
                    Beri Rating
                </h3>

                <p class="text-muted mb-4">
                    Bagaimana pengalaman rental mobil kamu?
                </p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    action="{{ url('/customer/ratings/' . $rental->id) }}"
                    method="POST"
                >

                    @csrf

                    <div class="mb-3">

                        <label
                            for="rating"
                            class="form-label fw-semibold"
                        >
                            Rating
                        </label>

                        <select
                            name="rating"
                            id="rating"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Pilih Rating
                            </option>

                            <option value="5">
                                ⭐⭐⭐⭐⭐ Sangat Baik
                            </option>

                            <option value="4">
                                ⭐⭐⭐⭐ Baik
                            </option>

                            <option value="3">
                                ⭐⭐⭐ Cukup
                            </option>

                            <option value="2">
                                ⭐⭐ Kurang
                            </option>

                            <option value="1">
                                ⭐ Sangat Kurang
                            </option>

                        </select>

                    </div>

                    <div class="mb-4">

                        <label
                            for="komentar"
                            class="form-label fw-semibold"
                        >
                            Komentar
                        </label>

                        <textarea
                            name="komentar"
                            id="komentar"
                            class="form-control"
                            rows="4"
                            placeholder="Tulis pengalaman kamu..."
                            required
                        >{{ old('komentar') }}</textarea>

                    </div>

                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-success"
                        >
                            <i class="bi bi-send me-1"></i>
                            Kirim Rating
                        </button>

                        <a
                            href="{{ route('customer.dashboard') }}"
                            class="btn btn-secondary"
                        >
                            Kembali
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</body>

</html>