<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email - RentalKu</title>
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
            --brand-darker: #116532;
            --brand-light: #e9f7ef;
            --background: #F0EDEE;
            --foreground: #1F2937;
            --muted: #6B7280;
            --border: #E5E7EB;
        }

        body {
            min-height: 100dvh;
            padding: 24px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(680px 420px at 12% -8%, rgba(25, 135, 84, 0.10), transparent 70%),
                radial-gradient(560px 380px at 100% 110%, rgba(44, 102, 110, 0.08), transparent 70%),
                var(--background);
            color: var(--foreground);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            line-height: 1.55;
        }

        .otp-card {
            width: 100%;
            max-width: 460px;
            padding: 32px 34px 24px;
            border-radius: 28px;
            background: #fff;
            box-shadow: 0 24px 60px rgba(15, 81, 50, 0.10), 0 2px 6px rgba(15, 81, 50, 0.04);
            animation: card-in 0.4s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes card-in {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .wordmark {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            font-family: 'Montserrat', system-ui, sans-serif;
            font-size: 0.98rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .wordmark-tile {
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: var(--brand-light);
            color: var(--brand);
            font-size: 1.25rem;
        }

        .otp-art {
            display: block;
            width: auto;
            height: 128px;
            margin: 0 auto 18px;
        }

        h1 {
            margin: 0 0 6px;
            font-family: 'Montserrat', system-ui, sans-serif;
            font-size: 1.7rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--foreground);
        }

        .otp-lede {
            margin: 0 0 16px;
            max-width: 34ch;
            font-size: 0.9rem;
            color: var(--muted);
        }

        .email-row {
            display: flex;
            align-items: center;
            gap: 10px;
            height: 46px;
            padding: 0 6px 0 12px;
            margin-bottom: 18px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #F3F4F6;
        }

        .email-row > .bi {
            flex: none;
            color: var(--brand);
            font-size: 1.05rem;
        }

        .email-text {
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 0.86rem;
            font-weight: 600;
        }

        .email-change {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            text-decoration: none;
            margin-left: auto;
            padding: 0 12px;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: var(--brand-dark);
            font-family: inherit;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
        }

        .email-change:hover {
            background: var(--brand-light);
        }

        .otp-alert {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            padding: 10px 12px;
            border: 1px solid;
            border-radius: 12px;
            font-size: 0.82rem;
            line-height: 1.45;
        }

        .otp-alert .bi {
            flex: none;
            font-size: 1rem;
        }

        .otp-alert-success {
            border-color: #D1E7DD;
            background: var(--brand-light);
            color: #0F5132;
        }

        .otp-alert-danger {
            border-color: #F1AEB5;
            background: #F8D7DA;
            color: #B02A37;
        }

        .otp-label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #374151;
        }

        .otp-box {
            position: relative;
            margin-bottom: 10px;
        }

        .otp-cells {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 9px;
        }

        .otp-cell {
            display: grid;
            place-items: center;
            height: 62px;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            background: #fff;
            color: var(--foreground);
            font-family: 'Montserrat', system-ui, sans-serif;
            font-size: 1.45rem;
            font-weight: 600;
        }

        .otp-cell.is-filled {
            border-color: #D1E7DD;
            background: #f5f8f6;
        }

        .otp-box.is-focused .otp-cell.is-active {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.14);
        }

        .otp-box.is-focused .otp-cell.is-active:not(.is-filled)::after {
            content: '';
            width: 2px;
            height: 24px;
            background: var(--brand);
            animation: caret-blink 1.1s steps(1) infinite;
        }

        @keyframes caret-blink {
            50% {
                opacity: 0;
            }
        }

        .otp-box.is-error .otp-cell {
            border-color: #dc3545;
            background: rgba(220, 53, 69, 0.04);
        }

        .otp-box.is-error.is-focused .otp-cell.is-active {
            border-color: #dc3545;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.12);
        }

        .otp-box.is-error {
            animation: otp-shake 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes otp-shake {
            20% {
                transform: translateX(-6px);
            }

            40% {
                transform: translateX(6px);
            }

            60% {
                transform: translateX(-4px);
            }

            80% {
                transform: translateX(4px);
            }
        }

        .otp-native {
            position: absolute;
            inset: 0;
            z-index: 2;
            width: 100%;
            height: 100%;
            padding: 0;
            border: 0;
            background: transparent;
            color: transparent;
            -webkit-text-fill-color: transparent;
            caret-color: transparent;
            font-size: 16px;
            opacity: 0;
        }

        .otp-help {
            margin: 0 0 16px;
            font-size: 0.78rem;
            color: var(--muted);
        }

        .otp-error {
            display: flex;
            align-items: center;
            gap: 6px;
            margin: -6px 0 14px;
            font-size: 0.8rem;
            color: #B02A37;
        }

        .btn-verify {
            width: 100%;
            height: 52px;
            border: 0;
            border-radius: 14px;
            background: var(--brand);
            color: #fff;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 600;
            transition: background-color 0.15s ease;
        }

        .btn-verify:hover:not(:disabled) {
            background: var(--brand-dark);
        }

        .btn-verify:disabled {
            background: #F3F4F6;
            color: #9CA3AF;
            cursor: not-allowed;
        }

        .resend-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 16px;
            font-size: 0.83rem;
            color: var(--muted);
        }

        .resend-row p {
            margin: 0;
        }

        .resend-btn {
            padding: 0;
            border: 0;
            background: none;
            color: var(--brand-dark);
            font-family: inherit;
            font-size: 0.83rem;
            font-weight: 600;
            cursor: pointer;
        }

        .resend-btn:hover:not(:disabled) {
            color: var(--brand-darker);
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .resend-btn:disabled {
            color: #9CA3AF;
            cursor: not-allowed;
        }

        .otp-footer {
            margin-top: 22px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            text-align: center;
        }

        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0;
            border: 0;
            background: none;
            color: var(--muted);
            font-family: inherit;
            font-size: 0.82rem;
            font-weight: 500;
            cursor: pointer;
        }

        .logout-btn:hover {
            color: var(--brand-dark);
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        :focus-visible {
            outline: 3px solid var(--brand);
            outline-offset: 2px;
        }

        .otp-native:focus-visible {
            outline: none;
        }

        @media (max-width: 419.98px) {
            .otp-card {
                padding: 26px 20px 22px;
                border-radius: 22px;
            }

            .otp-art {
                height: 108px;
            }

            h1 {
                font-size: 1.5rem;
            }

            .otp-cells {
                gap: 7px;
            }

            .otp-cell {
                height: 52px;
                font-size: 1.25rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .otp-card,
            .otp-box.is-error,
            .otp-box.is-focused .otp-cell.is-active:not(.is-filled)::after {
                animation: none;
            }

            .btn-verify {
                transition: none;
            }
        }
    </style>
    <noscript>
        <style>
            .otp-cells {
                display: none;
            }

            .otp-native {
                position: static;
                width: 100%;
                height: 56px;
                border: 1px solid var(--border);
                border-radius: 14px;
                background: #fff;
                color: var(--foreground);
                -webkit-text-fill-color: currentColor;
                text-align: center;
                letter-spacing: 0.4em;
                font-size: 1.4rem;
                opacity: 1;
            }
        </style>
    </noscript>
</head>

<body>
    <main class="otp-card">
        <div class="wordmark">
            <span class="wordmark-tile"><i class="bi bi-car-front-fill" aria-hidden="true"></i></span>
            RentalKu
        </div>

        <svg class="otp-art" viewBox="0 0 220 150" width="188" height="128" aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="110" cy="138" rx="54" ry="9" fill="#0f5132" fill-opacity=".08" />
            <circle cx="92" cy="76" r="66" fill="#E9F7EF" />
            <circle cx="92" cy="76" r="51" fill="none" stroke="#D1E7DD" stroke-width="1.5"
                stroke-dasharray="6 5" />
            <rect x="52" y="52" width="104" height="72" rx="12" fill="#fff" stroke="#198754"
                stroke-width="2.5" />
            <path d="M52 56 104 90 156 56" fill="none" stroke="#198754" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round" />
            <circle cx="164" cy="56" r="21" fill="#198754" />
            <path d="M155.5 56.5 161 62.5 172.5 50" fill="none" stroke="#fff" stroke-width="3"
                stroke-linecap="round" stroke-linejoin="round" />
            <path d="M187 95v8M183 99h8" fill="none" stroke="#D1E7DD" stroke-width="1.6"
                stroke-linecap="round" />
            <circle cx="205" cy="128" r="2.5" fill="#D1E7DD" />
            <circle cx="26" cy="132" r="2" fill="#D1E7DD" />
        </svg>

        <h1>Verifikasi email</h1>
        <p class="otp-lede">Masukkan 6 digit kode yang kami kirim ke</p>

        <div class="email-row">
            <i class="bi bi-envelope" aria-hidden="true"></i>
            <span class="email-text" title="{{ auth()->user()->email }}">{{ auth()->user()->email }}</span>
            <a href="{{ route('profile.email.edit') }}" class="email-change">Ganti</a>
        </div>

        @if (session('status'))
            <div class="otp-alert otp-alert-success" role="status">
                <i class="bi bi-check-circle" aria-hidden="true"></i>
                {{ session('status') }}
            </div>
        @endif

        @error('resend')
            <div class="otp-alert otp-alert-danger" role="alert">
                <i class="bi bi-exclamation-circle" aria-hidden="true"></i>
                {{ $message }}
            </div>
        @enderror

        <form method="POST" action="{{ route('otp.verify') }}" id="otpForm">
            @csrf
            <label for="otp_code" class="otp-label">Kode verifikasi</label>
            <div id="otpBox" class="otp-box{{ $errors->has('otp_code') ? ' is-error' : '' }}">
                <div class="otp-cells" aria-hidden="true">
                    @for ($i = 0; $i < 6; $i++)
                        <span class="otp-cell" data-otp-cell></span>
                    @endfor
                </div>
                <input type="text" name="otp_code" id="otp_code" class="otp-native" inputmode="numeric"
                    autocomplete="one-time-code" pattern="[0-9]{6}" required autofocus
                    aria-describedby="otpHelp{{ $errors->has('otp_code') ? ' otpError' : '' }}"
                    aria-invalid="{{ $errors->has('otp_code') ? 'true' : 'false' }}">
            </div>
            <p id="otpHelp" class="otp-help">Berlaku 5 menit. Cek folder spam bila belum terlihat.</p>
            @error('otp_code')
                <p id="otpError" class="otp-error" role="alert">
                    <i class="bi bi-exclamation-circle" aria-hidden="true"></i>
                    {{ $message }}
                </p>
            @enderror
            <button type="submit" class="btn-verify">Verifikasi</button>
        </form>

        <div class="resend-row">
            <p>Belum menerima kode?</p>
            <form method="POST" action="{{ route('otp.resend') }}">
                @csrf
                <button type="submit" id="resendBtn" class="resend-btn" @if ($resendAvailableIn > 0) disabled @endif>
                    <span id="resendLabel">
                        @if ($resendAvailableIn > 0)
                            Kirim ulang dalam {{ $resendAvailableIn }} dtk
                        @else
                            Kirim ulang
                        @endif
                    </span>
                </button>
            </form>
        </div>

        <footer class="otp-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                    Keluar
                </button>
            </form>
        </footer>
    </main>

    <script>
        (function () {
            const form = document.getElementById('otpForm');
            const input = document.getElementById('otp_code');
            const box = document.getElementById('otpBox');
            if (!form || !input || !box) return;

            const cells = box.querySelectorAll('[data-otp-cell]');
            const submit = form.querySelector('button[type="submit"]');
            const error = document.getElementById('otpError');
            let focused = document.activeElement === input;

            const render = function () {
                const digits = input.value.replace(/\D/g, '').slice(0, 6);
                if (digits !== input.value) {
                    input.value = digits;
                }

                const active = digits.length >= cells.length ? cells.length - 1 : digits.length;

                cells.forEach(function (cell, index) {
                    cell.textContent = digits[index] || '';
                    cell.classList.toggle('is-filled', index < digits.length);
                    cell.classList.toggle('is-active', focused && index === active);
                });

                if (submit) {
                    submit.disabled = digits.length !== 6;
                }
            };

            const clearError = function () {
                if (!box.classList.contains('is-error')) return;
                box.classList.remove('is-error');
                input.setAttribute('aria-invalid', 'false');
                if (error) error.hidden = true;
            };

            input.addEventListener('focus', function () {
                focused = true;
                box.classList.add('is-focused');
                render();
            });

            input.addEventListener('blur', function () {
                focused = false;
                box.classList.remove('is-focused');
                render();
            });

            input.addEventListener('input', function () {
                clearError();
                render();
            });

            form.addEventListener('submit', function (event) {
                if (input.value.replace(/\D/g, '').length !== 6) {
                    event.preventDefault();
                    input.focus();
                }
            });

            if (focused) {
                box.classList.add('is-focused');
            }

            render();

            const resendBtn = document.getElementById('resendBtn');
            const resendLabel = document.getElementById('resendLabel');
            if (!resendBtn || !resendLabel) return;

            let remaining = {{ (int) $resendAvailableIn }};

            if (remaining > 0) {
                const renderResend = function () {
                    resendLabel.textContent = remaining > 0 ? 'Kirim ulang dalam ' + remaining + ' dtk' : 'Kirim ulang';
                    resendBtn.disabled = remaining > 0;
                };

                renderResend();

                const timer = setInterval(function () {
                    remaining -= 1;
                    renderResend();
                    if (remaining <= 0) {
                        clearInterval(timer);
                    }
                }, 1000);
            }
        })();
    </script>
</body>

</html>
