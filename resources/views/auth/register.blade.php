<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: #f5f7f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-card {
            width: 100%;
            max-width: 520px;
            background: white;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
        }

        .brand {
            color: #198754;
            font-weight: 700;
            font-size: 28px;
        }

        .subtitle {
            color: #6c757d;
        }

        .form-control {
            padding: 12px 14px;
            border-radius: 10px;
        }

        .btn-register {
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
        }
    </style>
</head>

<body>

<div class="register-card">

    <div class="text-center mb-4">
        <div class="brand">RentalKu</div>
        <h4 class="mt-2 mb-1">Buat Akun Baru</h4>
        <p class="subtitle mb-0">
            Daftar untuk mulai menggunakan RentalKu
        </p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                placeholder="Masukkan nama lengkap"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                placeholder="Masukkan email"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor HP</label>
            <input
                type="text"
                name="phone"
                class="form-control"
                value="{{ old('phone') }}"
                placeholder="Contoh: 081234567890"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea
                name="address"
                class="form-control"
                rows="3"
                placeholder="Masukkan alamat lengkap"
                required
            >{{ old('address') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Minimal 8 karakter"
                required
            >
        </div>

        <div class="mb-4">
            <label class="form-label">Konfirmasi Password</label>
            <input
                type="password"
                name="password_confirmation"
                class="form-control"
                placeholder="Ulangi password"
                required
            >
        </div>

        <button type="submit" class="btn btn-success w-100 btn-register">
            Daftar
        </button>
    </form>

    <div class="text-center mt-4">
        <span class="text-muted">Sudah punya akun?</span>
        <a href="{{ url('/login') }}" class="text-success text-decoration-none fw-semibold">
            Masuk
        </a>
    </div>

</div>

</body>
</html>