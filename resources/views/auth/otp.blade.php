<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi OTP - RentalKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5" style="max-width: 440px;">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-2">Verifikasi Email</h4>
                <p class="text-muted">
                    Kami mengirim kode 6 digit ke <strong>{{ auth()->user()->email }}</strong>.
                    Kode berlaku 5 menit.
                </p>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('otp.verify') }}">
                    @csrf
                    <input type="text" name="otp_code" inputmode="numeric" maxlength="6" autofocus
                        class="form-control form-control-lg text-center @error('otp_code') is-invalid @enderror"
                        placeholder="123456">
                    @error('otp_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <button class="btn btn-primary w-100 mt-3">Verifikasi</button>
                </form>

                <form method="POST" action="{{ route('otp.resend') }}" class="text-center mt-3">
                    @csrf
                    <span class="text-muted small">Tidak menerima kode?</span>
                    <button class="btn btn-link btn-sm p-0 align-baseline">Kirim ulang</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
