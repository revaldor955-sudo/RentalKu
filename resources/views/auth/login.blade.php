<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Masuk - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: #f5f7f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
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

        .btn-login {
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
        }
    </style>
</head>

<body>

<div class="login-card">

    <div class="text-center mb-4">
        <div class="brand">RentalKu</div>

        <h4 class="mt-2 mb-1">Selamat Datang</h4>

        <p class="subtitle mb-0">
            Masuk ke akun RentalKu kamu
        </p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email</label>

            <input
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                placeholder="Masukkan email"
                required
                autofocus
            >
        </div>

        <div class="mb-4">
            <label class="form-label">Password</label>

            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Masukkan password"
                required
            >
        </div>

        <button type="submit" class="btn btn-success w-100 btn-login">
            Masuk
        </button>
    </form>

    <div class="text-center mt-4">
        <span class="text-muted">Belum punya akun?</span>

        <a
            href="{{ route('register') }}"
            class="text-success text-decoration-none fw-semibold"
        >
            Daftar
        </a>
    </div>

</div>

</body>
</html>