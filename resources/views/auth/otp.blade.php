<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi OTP - RentalKu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --brand: #198754;
            --brand-dark: #146c43;
            --brand-light: #e9f7ef;
            --background: #F0EDEE;
            --foreground: #1F2937;
            --muted: #6B7280;
            --border: #E5E7EB;
            --gray-100: #F3F4F6;
        }

        body {
            min-height: 100vh;
            padding: 24px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--background);
            color: var(--foreground);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            line-height: 1.6;
        }

        h1,
        h2,
        h3 {
            font-family: 'Montserrat', system-ui, sans-serif;
            letter-spacing: -0.02em;
        }

        .auth-card {
            width: 100%;
            max-width: 440px;
            background: #fff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            animation: card-rise 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes card-rise {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-header {
            background: linear-gradient(110deg, #08462a, #198754);
            padding: 28px 28px 32px;
            color: #fff;
        }

        .wordmark {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
            font-family: 'Montserrat', system-ui, sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: 0.01em;
        }

        .wordmark i {
            font-size: 1rem;
            color: var(--brand-light);
        }

        .auth-header h1 {
            margin: 0 0 6px;
            font-size: 1.55rem;
            font-weight: 700;
        }

        .auth-header p {
            margin: 0;
            max-width: 30ch;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.82);
        }

        .auth-body {
            padding: 26px 28px 28px;
        }

        .auth-lead {
            margin: 0;
            font-size: 0.925rem;
            color: var(--muted);
        }

        .email-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            max-width: 100%;
            margin: 10px 0 0;
            padding: 8px 14px;
            border: 1px solid var(--border);
            border-radius: 999px;
            background: var(--gray-100);
            color: var(--foreground);
            font-size: 0.9rem;
            font-weight: 600;
            word-break: break-all;
        }

        .email-pill i {
            flex: none;
            color: var(--brand);
        }

        .auth-note {
            margin: 8px 0 0;
            font-size: 0.85rem;
            color: var(--muted);
        }

        .alert {
            margin: 18px 0 0;
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 0.875rem;
        }

        .alert-soft-success {
            background: var(--brand-light);
            border: 1px solid #19875433;
            color: #0f5132;
        }

        .alert-soft-danger {
            background: #f8d7da;
            border: 1px solid #f1aeb5;
            color: #b02a37;
        }

        .otp-form {
            margin-top: 22px;
        }

        .form-label {
            margin-bottom: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--foreground);
        }

        .otp-input {
            height: 64px;
            padding: 0.5rem 0.75rem;
            border: 1px solid #D1D5DB;
            border-radius: 14px;
            background: #fff;
            color: var(--foreground);
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            font-size: 1.75rem;
            font-weight: 600;
            text-align: center;
            text-indent: 0.45em;
            letter-spacing: 0.45em;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .otp-input:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.15);
            outline: none;
        }

        .otp-input.is-invalid {
            border-color: #dc3545;
        }

        .otp-input.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
        }

        .form-text {
            font-size: 0.8rem;
            color: var(--muted);
        }

        .invalid-feedback {
            font-size: 0.8rem;
        }

        .btn-verify {
            width: 100%;
            margin-top: 18px;
            padding: 0.85rem 1rem;
            border: 1px solid var(--brand);
            border-radius: 12px;
            background: var(--brand);
            color: #fff;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            transition: background-color 0.15s ease, border-color 0.15s ease;
        }

        .btn-verify:hover {
            background: var(--brand-dark);
            border-color: var(--brand-dark);
            color: #fff;
        }

        .btn-verify:active {
            background: var(--brand-dark);
            border-color: var(--brand-dark);
        }

        .resend-row {
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid var(--border);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .resend-row p {
            margin: 0;
            font-size: 0.85rem;
            color: var(--muted);
        }

        .resend-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0;
            border: none;
            background: none;
            color: var(--brand);
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
        }

        .resend-btn:hover:not(:disabled) {
            color: var(--brand-dark);
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .resend-btn:disabled {
            color: #9CA3AF;
            cursor: not-allowed;
        }

        .auth-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px 28px;
            border-top: 1px solid var(--border);
        }

        .auth-footer a,
        .auth-footer-link,
        .logout-btn {
            padding: 0;
            border: none;
            background: none;
            color: var(--muted);
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            font-size: 0.825rem;
            font-weight: 500;
            text-decoration: none;
        }

        .auth-footer a:hover,
        .auth-footer-link:hover,
        .logout-btn:hover {
            color: var(--brand-dark);
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .auth-footer-link {
            cursor: pointer;
        }

        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }

        :focus-visible {
            outline: 3px solid rgba(25, 135, 84, 0.5);
            outline-offset: 2px;
        }

        @media (max-width: 419.98px) {
            body {
                padding: 12px;
            }

            .auth-header {
                padding: 24px 22px 28px;
            }

            .auth-body {
                padding: 22px 22px 24px;
            }

            .auth-footer {
                padding: 14px 22px;
            }

            .auth-header h1 {
                font-size: 1.4rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .auth-card {
                animation: none;
            }

            .otp-input,
            .btn-verify {
                transition: none;
            }
        }
    </style>
</head>

<body>
    <main class="auth-card">
        <header class="auth-header">
            <div class="wordmark"><i class="bi bi-car-front-fill" aria-hidden="true"></i> RentalKu</div>
            <h1>Verifikasi Email</h1>
            <p>Masukkan kode yang kami kirim untuk mengaktifkan akun Anda.</p>
        </header>

        <div class="auth-body">
            @if (session('status'))
                <div class="alert alert-soft-success" role="status">{{ session('status') }}</div>
            @endif

            @error('resend')
                <div class="alert alert-soft-danger" role="alert">{{ $message }}</div>
            @enderror

            <p class="auth-lead">Masukkan kode 6 digit untuk email berikut.</p>
            <div class="email-pill">
                <i class="bi bi-envelope" aria-hidden="true"></i>
                <span>{{ auth()->user()->email }}</span>
            </div>
            <p class="auth-note">Kode berlaku 5 menit. Cek folder spam bila belum terlihat.</p>

            <form method="POST" action="{{ route('otp.verify') }}" class="otp-form">
                @csrf
                <label for="otp_code" class="form-label">Kode OTP</label>
                <input type="text" name="otp_code" id="otp_code" inputmode="numeric" autocomplete="one-time-code"
                    pattern="[0-9]{6}" maxlength="6" required autofocus
                    aria-describedby="otpHelp @error('otp_code') otpError @enderror"
                    aria-invalid="@error('otp_code') true @else false @enderror"
                    class="form-control otp-input @error('otp_code') is-invalid @enderror">
                <div id="otpHelp" class="form-text mt-2">Hanya angka, tanpa spasi.</div>
                @error('otp_code')
                    <div id="otpError" class="invalid-feedback" aria-live="polite">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn btn-verify">Verifikasi</button>
            </form>

            <div class="resend-row">
                <p>Tidak menerima kode?</p>
                <form method="POST" action="{{ route('otp.resend') }}">
                    @csrf
                    <button type="submit" id="resendBtn" class="resend-btn"
                        @if ($resendAvailableIn > 0) disabled @endif>
                        <i class="bi bi-arrow-repeat" aria-hidden="true"></i>
                        <span id="resendLabel">
                            @if ($resendAvailableIn > 0)
                                Kirim ulang ({{ $resendAvailableIn }}s)
                            @else
                                Kirim ulang
                            @endif
                        </span>
                    </button>
                </form>
            </div>
        </div>

        <footer class="auth-footer">
            <button type="button" class="auth-footer-link"
                data-bs-toggle="modal" data-bs-target="#profileModal" data-mode="edit">
                Ganti email
            </button>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                    Keluar
                </button>
            </form>
        </footer>
    </main>

    @include('layouts.partials.profile-modal')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        (function () {
            const btn = document.getElementById('resendBtn');
            const label = document.getElementById('resendLabel');
            if (!btn || !label) return;

            let remaining = {{ (int) $resendAvailableIn }};

            if (remaining > 0) {
                const render = function () {
                    label.textContent = remaining > 0 ? 'Kirim ulang (' + remaining + 's)' : 'Kirim ulang';
                    btn.disabled = remaining > 0;
                };

                render();

                const timer = setInterval(function () {
                    remaining -= 1;
                    render();
                    if (remaining <= 0) {
                        clearInterval(timer);
                    }
                }, 1000);
            }
        })();
    </script>
</body>

</html>
