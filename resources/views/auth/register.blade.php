<x-guest-layout>
    @php
        $errorStep = $errors->hasAny(['name', 'address'])
            ? 1
            : ($errors->hasAny(['email', 'phone'])
                ? 2
                : ($errors->hasAny(['password', 'password_confirmation']) ? 3 : 1));
    @endphp

    <style>
        .reg-wrap {
            --brand: #198754;
            --brand-dark: #146c43;
            --brand-light: #e9f7ef;
            --ink: #1F2937;
            --muted: #6B7280;
            --line: #E5E7EB;
            --danger: #dc3545;
        }

        .reg-head {
            margin-bottom: 18px;
        }

        .reg-head h1 {
            margin: 0 0 4px;
            color: var(--ink);
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.25;
        }

        .reg-head p {
            margin: 0;
            color: var(--muted);
            font-size: 0.84rem;
            line-height: 1.5;
        }

        .reg-steps {
            display: flex;
            margin: 0 0 20px;
            padding: 0;
            list-style: none;
        }

        .reg-step {
            position: relative;
            flex: 1;
            text-align: center;
        }

        .reg-step:not(:last-child)::before {
            content: "";
            position: absolute;
            top: 15px;
            left: calc(50% + 18px);
            width: calc(100% - 36px);
            height: 2px;
            background: var(--line);
            transition: background-color 0.2s ease;
        }

        .reg-step.is-done:not(:last-child)::before {
            background: var(--brand);
        }

        .reg-step-num {
            position: relative;
            z-index: 1;
            display: grid;
            place-items: center;
            width: 30px;
            height: 30px;
            margin: 0 auto 6px;
            border: 1.5px solid var(--line);
            border-radius: 50%;
            background: #fff;
            color: #9CA3AF;
            font-size: 0.76rem;
            font-weight: 700;
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease;
        }

        .reg-step.is-active .reg-step-num {
            border-color: var(--brand);
            background: var(--brand);
            color: #fff;
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.12);
        }

        .reg-step.is-done .reg-step-num {
            border-color: #D1E7DD;
            background: var(--brand-light);
            color: var(--brand-dark);
        }

        .reg-step-label {
            display: block;
            color: #9CA3AF;
            font-size: 0.68rem;
            font-weight: 600;
        }

        .reg-step.is-active .reg-step-label {
            color: var(--ink);
        }

        .reg-step.is-done .reg-step-label {
            color: var(--brand-dark);
        }

        .wizard-title {
            margin: 0 0 2px;
            color: var(--ink);
            font-size: 1rem;
            font-weight: 700;
        }

        .wizard-desc {
            margin: 0 0 14px;
            color: var(--muted);
            font-size: 0.8rem;
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

        textarea.auth-input {
            height: auto;
            min-height: 92px;
            padding: 12px 44px 12px 14px;
            line-height: 1.5;
            resize: vertical;
        }

        /* Ikon status dekoratif: teks error tetap sumber informasi untuk pembaca layar. */
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

        .auth-field.has-textarea .auth-control::after,
        .auth-field.has-textarea .auth-control::before {
            top: 22px;
            transform: none;
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

        .wizard-actions {
            display: flex;
            gap: 10px;
            margin-top: 16px;
        }

        .btn-auth {
            display: inline-flex;
            flex: 1;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 48px;
            border: 1px solid transparent;
            border-radius: 12px;
            font-family: inherit;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.15s ease, border-color 0.15s ease;
        }

        .btn-auth:active {
            transform: translateY(1px);
        }

        .btn-auth-primary {
            background: var(--brand);
            color: #fff;
        }

        .btn-auth-primary:hover {
            background: var(--brand-dark);
        }

        .btn-auth-secondary {
            flex: 0 0 auto;
            padding: 0 18px;
            border-color: var(--line);
            background: #fff;
            color: #374151;
        }

        .btn-auth-secondary:hover {
            border-color: #D1D5DB;
            background: #F9FAFB;
        }

        .btn-auth:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        .btn-auth.is-loading {
            pointer-events: none;
        }

        .spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: reg-spin 0.7s linear infinite;
        }

        .btn-auth.is-loading .spinner {
            display: inline-block;
        }

        @keyframes reg-spin {
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
            .reg-head h1 {
                font-size: 1.3rem;
            }

            .reg-step-label {
                font-size: 0.62rem;
            }

            .btn-auth-secondary {
                padding: 0 14px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .reg-step-num,
            .auth-input,
            .auth-control::after,
            .auth-control::before,
            .btn-auth,
            .spinner {
                transition: none;
                animation: none;
            }
        }
    </style>

    <div class="reg-wrap">
        <header class="reg-head">
            <h1>Mulai perjalanan Anda</h1>
            <p>Tiga langkah singkat, lalu verifikasi email lewat kode OTP.</p>
        </header>

        <ol class="reg-steps" aria-label="Langkah pendaftaran">
            <li class="reg-step is-active" data-step-indicator="1" aria-current="step">
                <span class="reg-step-num">1</span>
                <span class="reg-step-label">Pribadi</span>
            </li>
            <li class="reg-step" data-step-indicator="2">
                <span class="reg-step-num">2</span>
                <span class="reg-step-label">Kontak</span>
            </li>
            <li class="reg-step" data-step-indicator="3">
                <span class="reg-step-num">3</span>
                <span class="reg-step-label">Keamanan</span>
            </li>
        </ol>

        <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate
            data-error-step="{{ $errorStep }}">
            @csrf

            <section data-step-panel="1" aria-labelledby="reg-step-1-title" @if ($errorStep !== 1) hidden @endif>
                <h2 id="reg-step-1-title" class="wizard-title">Informasi pribadi</h2>
                <p class="wizard-desc">Nama dan alamat yang bisa kami hubungi.</p>

                <div class="auth-field" data-field="name">
                    <label for="name" class="auth-label">Nama lengkap</label>
                    <div class="auth-control">
                        <input id="name" name="name" type="text"
                            class="auth-input @error('name') is-invalid @enderror" value="{{ old('name') }}"
                            placeholder="Nama sesuai identitas" maxlength="255" autocomplete="name"
                            aria-describedby="name-msg" aria-required="true" data-validate="name"
                            data-server-error="{{ $errors->has('name') ? '1' : '0' }}">
                    </div>
                    <p class="field-msg" id="name-msg" data-msg-for="name" aria-live="polite">{{ $errors->first('name') }}</p>
                </div>

                <div class="auth-field has-textarea" data-field="address">
                    <label for="address" class="auth-label">Alamat lengkap</label>
                    <div class="auth-control">
                        <textarea id="address" name="address" rows="3"
                            class="auth-input @error('address') is-invalid @enderror"
                            placeholder="Jalan, nomor rumah, kota" maxlength="500" autocomplete="street-address"
                            aria-describedby="address-msg" aria-required="true" data-validate="address"
                            data-server-error="{{ $errors->has('address') ? '1' : '0' }}">{{ old('address') }}</textarea>
                    </div>
                    <p class="field-msg" id="address-msg" data-msg-for="address" aria-live="polite">{{ $errors->first('address') }}</p>
                </div>

                <div class="wizard-actions">
                    <button type="button" class="btn-auth btn-auth-primary" data-next>Lanjut</button>
                </div>
            </section>

            <section data-step-panel="2" aria-labelledby="reg-step-2-title" @if ($errorStep !== 2) hidden @endif>
                <h2 id="reg-step-2-title" class="wizard-title">Informasi kontak</h2>
                <p class="wizard-desc">Kode OTP dikirim ke email ini. Nomor HP dipakai tim kami untuk konfirmasi.</p>

                <div class="auth-field" data-field="email">
                    <label for="email" class="auth-label">Email</label>
                    <div class="auth-control">
                        <input id="email" name="email" type="email"
                            class="auth-input @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            placeholder="nama@email.com" maxlength="255" autocomplete="email" inputmode="email"
                            aria-describedby="email-msg" aria-required="true" data-validate="email"
                            data-server-error="{{ $errors->has('email') ? '1' : '0' }}">
                    </div>
                    <p class="field-msg" id="email-msg" data-msg-for="email" aria-live="polite">{{ $errors->first('email') }}</p>
                </div>

                <div class="auth-field" data-field="phone">
                    <label for="phone" class="auth-label">Nomor HP</label>
                    <div class="auth-control">
                        <input id="phone" name="phone" type="tel"
                            class="auth-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                            placeholder="081234567890" maxlength="25" autocomplete="tel" inputmode="tel"
                            aria-describedby="phone-msg" aria-required="true" data-validate="phone"
                            data-server-error="{{ $errors->has('phone') ? '1' : '0' }}">
                    </div>
                    <p class="field-msg" id="phone-msg" data-msg-for="phone" aria-live="polite">{{ $errors->first('phone') }}</p>
                </div>

                <div class="wizard-actions">
                    <button type="button" class="btn-auth btn-auth-secondary" data-prev>Kembali</button>
                    <button type="button" class="btn-auth btn-auth-primary" data-next>Lanjut</button>
                </div>
            </section>

            <section data-step-panel="3" aria-labelledby="reg-step-3-title" @if ($errorStep !== 3) hidden @endif>
                <h2 id="reg-step-3-title" class="wizard-title">Keamanan akun</h2>
                <p class="wizard-desc">Minimal 8 karakter. Gunakan kombinasi yang tidak mudah ditebak.</p>

                <div class="auth-field has-toggle" data-field="password">
                    <label for="password" class="auth-label">Password</label>
                    <div class="auth-control">
                        <input id="password" name="password" type="password"
                            class="auth-input @error('password') is-invalid @enderror" autocomplete="new-password"
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

                <div class="auth-field has-toggle" data-field="password_confirmation">
                    <label for="password_confirmation" class="auth-label">Konfirmasi password</label>
                    <div class="auth-control">
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            class="auth-input @error('password_confirmation') is-invalid @enderror"
                            autocomplete="new-password" aria-describedby="password_confirmation-msg"
                            aria-required="true" data-validate="password_confirmation"
                            data-server-error="{{ $errors->has('password_confirmation') ? '1' : '0' }}">
                        <button type="button" class="password-toggle" data-toggle-password="password_confirmation"
                            aria-label="Tampilkan konfirmasi password" aria-pressed="false">
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
                    <p class="field-msg" id="password_confirmation-msg" data-msg-for="password_confirmation"
                        aria-live="polite">{{ $errors->first('password_confirmation') }}</p>
                </div>

                <div class="wizard-actions">
                    <button type="button" class="btn-auth btn-auth-secondary" data-prev>Kembali</button>
                    <button type="submit" class="btn-auth btn-auth-primary" data-submit>
                        <span class="spinner" aria-hidden="true"></span>
                        <span data-submit-label>Daftar</span>
                    </button>
                </div>
            </section>
        </form>

        <p class="auth-switch">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
    </div>

    <noscript>
        <style>
            [data-step-panel][hidden] {
                display: block;
            }

            [data-step-panel] + [data-step-panel] {
                margin-top: 22px;
                padding-top: 18px;
                border-top: 1px solid #E5E7EB;
            }

            [data-next],
            [data-prev] {
                display: none !important;
            }
        </style>
    </noscript>

    <script>
        (function () {
            const form = document.getElementById('registerForm');

            if (!form) {
                return;
            }

            const panels = Array.from(form.querySelectorAll('[data-step-panel]'));
            const indicators = Array.from(document.querySelectorAll('[data-step-indicator]'));
            const fields = Array.from(form.querySelectorAll('[data-field]'));
            const fieldsByName = {};
            const touched = new Set();
            let currentStep = Number(form.dataset.errorStep) || 1;
            let submitting = false;

            fields.forEach(function (field) {
                fieldsByName[field.dataset.field] = field;
            });

            const rules = {
                name: function (value) {
                    const name = value.trim();

                    if (!name) {
                        return 'Nama lengkap wajib diisi.';
                    }
                    if (name.length < 2) {
                        return 'Nama lengkap minimal 2 karakter.';
                    }
                    if (name.length > 255) {
                        return 'Nama lengkap maksimal 255 karakter.';
                    }
                    if (!/\p{L}/u.test(name)) {
                        return 'Nama lengkap harus mengandung huruf.';
                    }

                    return '';
                },
                address: function (value) {
                    const address = value.trim();

                    if (!address) {
                        return 'Alamat wajib diisi.';
                    }
                    if (address.length < 10) {
                        return 'Alamat minimal 10 karakter.';
                    }
                    if (address.length > 500) {
                        return 'Alamat maksimal 500 karakter.';
                    }

                    return '';
                },
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
                phone: function (value) {
                    if (!value.trim()) {
                        return 'Nomor HP wajib diisi.';
                    }

                    let digits = value.replace(/[\s\-().]+/g, '');

                    if (digits.startsWith('+62')) {
                        digits = '0' + digits.slice(3);
                    } else if (digits.startsWith('62')) {
                        digits = '0' + digits.slice(2);
                    }

                    if (!/^08\d{8,11}$/.test(digits)) {
                        return 'Format nomor HP tidak valid. Contoh: 081234567890.';
                    }

                    return '';
                },
                password: function (value) {
                    if (!value) {
                        return 'Password wajib diisi.';
                    }
                    if (value.length < 8) {
                        return 'Password minimal 8 karakter.';
                    }

                    return '';
                },
                password_confirmation: function (value) {
                    if (!value) {
                        return 'Konfirmasi password wajib diisi.';
                    }
                    if (value !== document.getElementById('password').value) {
                        return 'Konfirmasi password tidak cocok.';
                    }

                    return '';
                },
            };

            function sanitizePhoneInput(input) {
                const caret = input.selectionStart;
                const original = input.value;
                const cleaned = original.replace(/[^\d+\s\-().]/g, '');

                if (cleaned === original) {
                    return;
                }

                const safeCaret = caret === null ? original.length : caret;
                const removedBeforeCaret = safeCaret - original.slice(0, safeCaret).replace(/[^\d+\s\-().]/g, '').length;
                const nextCaret = Math.max(0, safeCaret - removedBeforeCaret);

                input.value = cleaned;
                input.setSelectionRange(nextCaret, nextCaret);
            }

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

            function showStep(step) {
                currentStep = step;

                panels.forEach(function (panel) {
                    panel.hidden = Number(panel.dataset.stepPanel) !== step;
                });

                indicators.forEach(function (indicator) {
                    const number = Number(indicator.dataset.stepIndicator);

                    indicator.classList.toggle('is-active', number === step);
                    indicator.classList.toggle('is-done', number < step);

                    if (number === step) {
                        indicator.setAttribute('aria-current', 'step');
                    } else {
                        indicator.removeAttribute('aria-current');
                    }
                });
            }

            function validatePanel(step) {
                const panel = panels.find(function (item) {
                    return Number(item.dataset.stepPanel) === step;
                });

                if (!panel) {
                    return true;
                }

                let firstInvalid = null;

                panel.querySelectorAll('[data-validate]').forEach(function (input) {
                    touched.add(input.dataset.validate);

                    if (!validate(input.dataset.validate, true) && !firstInvalid) {
                        firstInvalid = input;
                    }
                });

                if (firstInvalid) {
                    firstInvalid.focus();
                }

                return !firstInvalid;
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
                } else if (input.value) {
                    validate(name, false);
                }

                input.addEventListener('input', function () {
                    if (name === 'phone') {
                        sanitizePhoneInput(input);
                    }

                    validate(name, touched.has(name));

                    if (name === 'password' && document.getElementById('password_confirmation').value) {
                        touched.add('password_confirmation');
                        validate('password_confirmation', true);
                    }
                });

                input.addEventListener('blur', function () {
                    touched.add(name);
                    validate(name, true);
                });
            });

            form.querySelectorAll('[data-next]').forEach(function (button) {
                button.addEventListener('click', function () {
                    if (validatePanel(currentStep) && currentStep < 3) {
                        showStep(currentStep + 1);
                    }
                });
            });

            form.querySelectorAll('[data-prev]').forEach(function (button) {
                button.addEventListener('click', function () {
                    if (currentStep > 1) {
                        showStep(currentStep - 1);
                    }
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

            form.addEventListener('keydown', function (event) {
                if (event.key !== 'Enter' || event.target.tagName === 'TEXTAREA'
                    || event.target.tagName === 'BUTTON') {
                    return;
                }

                event.preventDefault();

                if (currentStep < 3) {
                    if (validatePanel(currentStep)) {
                        showStep(currentStep + 1);
                    }

                    return;
                }

                form.requestSubmit(form.querySelector('[data-submit]'));
            });

            form.addEventListener('submit', function (event) {
                if (currentStep !== 3) {
                    event.preventDefault();

                    return;
                }

                const order = ['name', 'address', 'email', 'phone', 'password', 'password_confirmation'];
                const results = order.map(function (name) {
                    touched.add(name);

                    return validate(name, true);
                });

                if (results.includes(false)) {
                    event.preventDefault();

                    const firstInvalid = order.find(function (name) {
                        return fieldsByName[name] && fieldsByName[name].dataset.state === 'invalid';
                    });
                    const step = ['name', 'address'].includes(firstInvalid)
                        ? 1
                        : (['email', 'phone'].includes(firstInvalid) ? 2 : 3);

                    showStep(step);

                    const input = firstInvalid ? fieldsByName[firstInvalid].querySelector('[data-validate]') : null;

                    if (input) {
                        input.focus();
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

            showStep(currentStep);
        })();
    </script>
</x-guest-layout>
