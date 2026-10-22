<x-guest-layout>
    <style>
        .login-wrap {
            --brand: #198754;
            --brand-dark: #146c43;
            --brand-light: #e9f7ef;
            --ink: #1F2937;
            --muted: #6B7280;
            --line: #E5E7EB;
            --danger: #dc3545;
        }

        .login-head {
            margin-bottom: 20px;
        }

        .login-head h1 {
            margin: 0 0 4px;
            color: var(--ink);
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.25;
        }

        .login-head p {
            margin: 0;
            color: var(--muted);
            font-size: 0.84rem;
            line-height: 1.5;
        }

        .auth-field + .auth-field {
            margin-top: 12px;
        }

        .auth-label {
            display: block;
            margin-bottom: 6px;
            color: #374151;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .auth-control {
            position: relative;
        }

        .auth-input {
            width: 100%;
            height: 48px;
            padding: 0 44px 0 14px;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #fff;
            color: var(--ink);
            font-family: inherit;
            font-size: 0.9rem;
            transition: border-color 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease;
        }

        .auth-input::placeholder {
            color: #9CA3AF;
        }

        .auth-input:hover {
            border-color: #D1D5DB;
        }

        .auth-input:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.14);
        }

        .auth-input.is-invalid {
            border-color: var(--danger);
            background: #fffafa;
        }

        .auth-input.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.12);
        }

        .auth-control::after,
        .auth-control::before {
            content: "";
            position: absolute;
            top: 50%;
            right: 14px;
            width: 18px;
            height: 18px;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 18px 18px;
            opacity: 0;
            transform: translateY(-50%);
            transition: opacity 0.15s ease;
            pointer-events: none;
        }

        .auth-control::after {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='%23198754' d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l4.992-5.992a.75.75 0 0 0-.01-1.05z'/%3E%3C/svg%3E");
        }

        .auth-control::before {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='%23dc3545' d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z'/%3E%3C/svg%3E");
        }

        .auth-field[data-state="valid"] .auth-control::after {
            opacity: 1;
        }

        .auth-field[data-state="invalid"] .auth-control::before {
            opacity: 1;
        }

        .auth-field.has-toggle .auth-input {
            padding-right: 82px;
        }

        .auth-field.has-toggle .auth-control::after,
        .auth-field.has-toggle .auth-control::before {
            right: 48px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 8px;
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: var(--muted);
            cursor: pointer;
            transform: translateY(-50%);
        }

        .password-toggle:hover {
            background: #F3F4F6;
            color: #374151;
        }

        .password-toggle:focus-visible {
            outline: 2px solid var(--brand);
            outline-offset: 1px;
        }

        .password-toggle svg {
            width: 18px;
            height: 18px;
        }

        .password-toggle .icon-hide {
            display: none;
        }

        .password-toggle.is-visible .icon-show {
            display: none;
        }

        .password-toggle.is-visible .icon-hide {
            display: block;
        }

        .field-msg {
            min-height: 18px;
            margin: 5px 0 0;
            color: #B02A37;
            font-size: 0.75rem;
            line-height: 1.35;
        }

        .login-options {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 10px;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #374151;
            font-size: 0.8rem;
            cursor: pointer;
        }

        .remember-label input {
            width: 16px;
            height: 16px;
            border: 1px solid var(--line);
            border-radius: 4px;
            accent-color: var(--brand);
        }

        .login-link {
            color: var(--brand-dark);
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .btn-login {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            height: 48px;
            margin-top: 16px;
            border: 1px solid transparent;
            border-radius: 12px;
            background: var(--brand);
            color: #fff;
            font-family: inherit;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.15s ease;
        }

        .btn-login:hover {
            background: var(--brand-dark);
        }

        .btn-login:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        .btn-login.is-loading {
            pointer-events: none;
        }

        .spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: login-spin 0.7s linear infinite;
        }

        .btn-login.is-loading .spinner {
            display: inline-block;
        }

        @keyframes login-spin {
            to {
                transform: rotate(360deg);
            }
        }

        .auth-switch {
            margin: 18px 0 0;
            padding-top: 14px;
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: 0.8rem;
            text-align: center;
        }

        .auth-switch a {
            color: var(--brand-dark);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-switch a:hover {
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        @media (max-width: 419.98px) {
            .login-head h1 {
                font-size: 1.3rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .auth-input,
            .auth-control::after,
            .auth-control::before,
            .btn-login,
            .spinner {
                transition: none;
                animation: none;
            }
        }
    </style>

    <div class="login-wrap">
        <header class="login-head">
            <h1>Selamat datang kembali</h1>
            <p>Gunakan email dan password akun RentalKu Anda.</p>
        </header>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate
            data-auth-error="{{ $errors->has('email') ? '1' : '0' }}">
            @csrf

            <div class="auth-field" data-field="email">
                <label for="email" class="auth-label">Email</label>
                <div class="auth-control">
                    <input id="email" name="email" type="email"
                        class="auth-input @error('email') is-invalid @enderror" value="{{ old('email') }}"
                        placeholder="nama@email.com" maxlength="255" autocomplete="username" inputmode="email"
                        autofocus aria-describedby="email-msg" aria-required="true" data-validate="email"
                        data-server-error="{{ $errors->has('email') ? '1' : '0' }}">
                </div>
                <p class="field-msg" id="email-msg" data-msg-for="email" aria-live="polite">{{ $errors->first('email') }}</p>
            </div>

            <div class="auth-field has-toggle" data-field="password">
                <label for="password" class="auth-label">Password</label>
                <div class="auth-control">
                    <input id="password" name="password" type="password"
                        class="auth-input @error('password') is-invalid @enderror" autocomplete="current-password"
                        aria-describedby="password-msg" aria-required="true" data-validate="password"
                        data-server-error="{{ $errors->has('password') ? '1' : '0' }}">
                    <button type="button" class="password-toggle" data-toggle-password="password"
                        aria-label="Tampilkan password" aria-pressed="false">
                        <svg class="icon-show" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                            focusable="false">
                            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z" />
                            <circle cx="12" cy="12" r="2.6" />
                        </svg>
                        <svg class="icon-hide" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                            focusable="false">
                            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z" />
                            <circle cx="12" cy="12" r="2.6" />
                            <path d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                <p class="field-msg" id="password-msg" data-msg-for="password" aria-live="polite">{{ $errors->first('password') }}</p>
            </div>

            <div class="login-options">
                <label for="remember_me" class="remember-label">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="login-link" href="{{ route('password.request') }}">Lupa password?</a>
                @endif
            </div>

            <button type="submit" class="btn-login" data-submit>
                <span class="spinner" aria-hidden="true"></span>
                <span data-submit-label>Masuk</span>
            </button>
        </form>

        <p class="auth-switch">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
    </div>

    <script>
        (function () {
            const form = document.getElementById('loginForm');

            if (!form) {
                return;
            }

            const fields = Array.from(form.querySelectorAll('[data-field]'));
            const fieldsByName = {};
            const touched = new Set();
            let submitting = false;

            fields.forEach(function (field) {
                fieldsByName[field.dataset.field] = field;
            });

            const rules = {
                email: function (value) {
                    const email = value.trim();

                    if (!email) {
                        return 'Email wajib diisi.';
                    }
                    if (email.length > 255 || !/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(email)) {
                        return 'Format email tidak valid.';
                    }

                    return '';
                },
                password: function (value) {
                    return value ? '' : 'Password wajib diisi.';
                },
            };

            function validate(name, showMessage) {
                const field = fieldsByName[name];

                if (!field || !rules[name]) {
                    return true;
                }

                const input = field.querySelector('[data-validate]');
                const message = field.querySelector('[data-msg-for]');
                const error = rules[name](input.value);
                const hasValue = input.value.trim().length > 0;

                if (error) {
                    if (showMessage) {
                        field.dataset.state = 'invalid';
                        message.textContent = error;
                        input.classList.add('is-invalid');
                        input.setAttribute('aria-invalid', 'true');
                    } else {
                        field.dataset.state = '';
                        message.textContent = '';
                        input.classList.remove('is-invalid');
                        input.setAttribute('aria-invalid', 'false');
                    }

                    return false;
                }

                field.dataset.state = hasValue ? 'valid' : '';
                message.textContent = '';
                input.classList.remove('is-invalid');
                input.setAttribute('aria-invalid', 'false');

                return true;
            }

            fields.forEach(function (field) {
                const input = field.querySelector('[data-validate]');
                const name = field.dataset.field;

                if (!input) {
                    return;
                }

                if (input.dataset.serverError === '1') {
                    touched.add(name);
                    field.dataset.state = 'invalid';
                    input.classList.add('is-invalid');
                    input.setAttribute('aria-invalid', 'true');
                }

                input.addEventListener('input', function () {
                    validate(name, touched.has(name));
                });

                input.addEventListener('blur', function () {
                    touched.add(name);
                    validate(name, true);
                });
            });

            form.querySelectorAll('[data-toggle-password]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const input = document.getElementById(button.dataset.togglePassword);
                    const visible = input.type === 'password';

                    input.type = visible ? 'text' : 'password';
                    button.classList.toggle('is-visible', visible);
                    button.setAttribute('aria-pressed', visible ? 'true' : 'false');
                    button.setAttribute('aria-label', visible ? 'Sembunyikan password' : 'Tampilkan password');
                    input.focus({ preventScroll: true });
                });
            });

            form.addEventListener('submit', function (event) {
                const results = ['email', 'password'].map(function (name) {
                    touched.add(name);

                    return validate(name, true);
                });

                if (results.includes(false)) {
                    event.preventDefault();

                    const firstInvalid = ['email', 'password'].find(function (name) {
                        return fieldsByName[name] && fieldsByName[name].dataset.state === 'invalid';
                    });

                    if (firstInvalid) {
                        fieldsByName[firstInvalid].querySelector('[data-validate]').focus();
                    }

                    return;
                }

                if (submitting) {
                    event.preventDefault();

                    return;
                }

                submitting = true;

                const submitButton = form.querySelector('[data-submit]');
                const label = form.querySelector('[data-submit-label]');

                submitButton.disabled = true;
                submitButton.classList.add('is-loading');
                submitButton.setAttribute('aria-busy', 'true');

                if (label) {
                    label.textContent = 'Memproses...';
                }
            });

            // Sesi baru = sidebar mulai dari atas lagi.
            try {
                sessionStorage.removeItem('rentalku_sidebar_nav_scroll');
            } catch (e) {}
        })();
    </script>
</x-guest-layout>
