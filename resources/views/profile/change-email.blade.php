<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ganti Email - RentalKu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap"
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
            --danger: #dc3545;
            --danger-text: #B02A37;
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

        .change-card {
            width: 100%;
            max-width: 460px;
            padding: 32px 34px 28px;
            border-radius: 28px;
            background: #fff;
            box-shadow: 0 24px 60px rgba(15, 81, 50, 0.10), 0 2px 6px rgba(15, 81, 50, 0.04);
        }

        .wordmark {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            font-family: 'Montserrat', system-ui, sans-serif;
            font-size: 0.98rem;
            font-weight: 700;
            letter-spacing: -0.01em;
            color: var(--foreground);
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

        .swap-motif {
            display: block;
            width: auto;
            height: 110px;
            margin: 0 auto 16px;
        }

        h1 {
            margin: 0 0 8px;
            font-family: 'Montserrat', system-ui, sans-serif;
            font-size: 1.7rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--foreground);
        }

        .change-lede {
            margin: 0 0 20px;
            max-width: 34ch;
            font-size: 0.9rem;
            color: var(--muted);
        }

        .change-alert {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            padding: 10px 12px;
            border: 1px solid;
            border-radius: 12px;
            font-size: 0.82rem;
            line-height: 1.45;
        }

        .change-alert .bi {
            flex: none;
            font-size: 1rem;
        }

        .change-alert-success {
            border-color: #D1E7DD;
            background: var(--brand-light);
            color: #0F5132;
        }

        .change-alert-danger {
            border-color: #F1AEB5;
            background: #F8D7DA;
            color: var(--danger-text);
        }

        .change-label {
            display: block;
            margin-bottom: 8px;
            font-size: 1rem;
            font-weight: 600;
            color: #374151;
        }

        .email-row {
            display: flex;
            align-items: center;
            gap: 10px;
            height: 46px;
            padding: 0 14px;
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
            color: var(--foreground);
        }

        .change-input {
            display: block;
            width: 100%;
            height: 48px;
            padding: 0 14px;
            margin-bottom: 10px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fff;
            color: var(--foreground);
            font-family: inherit;
            font-size: 1rem;
            line-height: 1.5;
        }

        .change-input::placeholder {
            color: #9CA3AF;
        }

        .change-input:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.14);
            outline: none;
        }

        .change-input.is-invalid {
            border-color: var(--danger);
        }

        .change-input.is-invalid:focus {
            border-color: var(--danger);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.12);
        }

        .field-helper {
            margin: 0 0 16px;
            font-size: 0.875rem;
            color: var(--muted);
        }

        .change-error {
            display: flex;
            align-items: center;
            gap: 6px;
            margin: -6px 0 16px;
            font-size: 0.8rem;
            color: var(--danger-text);
        }

        .change-error .bi {
            flex: none;
            font-size: 0.9rem;
        }

        .btn-save {
            width: 100%;
            height: 48px;
            border: 0;
            border-radius: 14px;
            background: var(--brand);
            color: #fff;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.15s ease;
        }

        .btn-save:hover:not(:disabled) {
            background: var(--brand-dark);
        }

        .btn-save:active:not(:disabled) {
            background: var(--brand-darker);
        }

        .btn-save:disabled {
            background: #F3F4F6;
            color: #9CA3AF;
            cursor: not-allowed;
        }

        .change-footer {
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            text-align: center;
        }

        .change-cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 44px;
            padding: 0 12px;
            border: 0;
            background: none;
            color: var(--muted);
            font-family: inherit;
            font-size: 0.82rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
        }

        .change-cancel:hover {
            color: var(--brand-dark);
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        :focus-visible {
            outline: 3px solid var(--brand);
            outline-offset: 2px;
        }

        @media (max-width: 419.98px) {
            .change-card {
                padding: 26px 20px 22px;
                border-radius: 22px;
            }

            .swap-motif {
                height: 92px;
            }

            h1 {
                font-size: 1.5rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .btn-save {
                transition: none;
            }
        }
    </style>
</head>

<body>
    <main class="change-card">
        <div class="wordmark">
            <span class="wordmark-tile"><i class="bi bi-car-front-fill" aria-hidden="true"></i></span>
            RentalKu
        </div>

        <svg class="swap-motif" viewBox="0 0 180 120" width="165" height="110" aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg">
            <rect x="16" y="38" width="58" height="44" rx="10" fill="#e9f7ef" stroke="#198754" stroke-width="2" />
            <path d="M16 48 45 68 74 48" fill="none" stroke="#198754" stroke-width="2" stroke-linejoin="round" />
            <rect x="106" y="38" width="58" height="44" rx="10" fill="#fff" stroke="#198754" stroke-width="2" />
            <path d="M106 48 135 68 164 48" fill="none" stroke="#198754" stroke-width="2" stroke-linejoin="round" />
            <circle cx="90" cy="60" r="15" fill="#198754" />
            <path d="M84 56h9l-3-3M96 64h-9l3 3" fill="none" stroke="#fff" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" />
        </svg>

        <h1>Ganti email</h1>
        <p class="change-lede">Alamat email baru akan menerima kode verifikasi 6 digit. Password saat ini mengonfirmasi bahwa Anda yang mengubah alamat ini.</p>

        @if (session('status'))
            <div class="change-alert change-alert-success" role="status">
                <i class="bi bi-check-circle" aria-hidden="true"></i>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.email.update') }}">
            @csrf
            @method('PATCH')

            <span class="change-label">Email saat ini</span>
            <div class="email-row">
                <i class="bi bi-envelope" aria-hidden="true"></i>
                <span class="email-text" title="{{ $user->email }}">{{ $user->email }}</span>
            </div>

            <label for="email" class="change-label">Email baru</label>
            <input type="email" name="email" id="email"
                value="{{ old('email', $user->email) }}"
                autocomplete="email" inputmode="email" spellcheck="false" required
                class="change-input{{ $errors->has('email') ? ' is-invalid' : '' }}"
                aria-describedby="emailHelp{{ $errors->has('email') ? ' emailError' : '' }}"
                aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
            <p id="emailHelp" class="field-helper">Kode verifikasi 6 digit akan dikirim ke alamat baru ini.</p>
            @error('email')
                <p id="emailError" class="change-error" role="alert">
                    <i class="bi bi-exclamation-circle" aria-hidden="true"></i>
                    {{ $message }}
                </p>
            @enderror

            <label for="current_password" class="change-label">Password saat ini</label>
            <input type="password" name="current_password" id="current_password"
                autocomplete="current-password" required
                class="change-input{{ $errors->has('current_password') ? ' is-invalid' : '' }}"
                aria-describedby="currentPasswordHelp{{ $errors->has('current_password') ? ' currentPasswordError' : '' }}"
                aria-invalid="{{ $errors->has('current_password') ? 'true' : 'false' }}">
            <p id="currentPasswordHelp" class="field-helper">Gunakan password akun kamu, bukan kode OTP.</p>
            @error('current_password')
                <p id="currentPasswordError" class="change-error" role="alert">
                    <i class="bi bi-exclamation-circle" aria-hidden="true"></i>
                    {{ $message }}
                </p>
            @enderror

            <button type="submit" class="btn-save">
                <i class="bi bi-envelope-fill" aria-hidden="true"></i>
                Simpan dan kirim kode
            </button>
        </form>

        <div class="change-footer">
            <a href="{{ route('otp.show') }}" class="change-cancel">Batal, kembali ke verifikasi</a>
        </div>
    </main>
</body>

</html>
