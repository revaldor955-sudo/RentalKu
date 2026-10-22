<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Masukkan password baru untuk akun Anda.
    </div>

    <form method="POST" action="{{ route('password.store') }}" id="resetPasswordForm" novalidate>
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <p id="email-client-error" class="mt-2 text-sm text-red-600" style="display: none" aria-live="polite"></p>
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password baru" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter.</p>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p id="password-client-error" class="mt-2 text-sm text-red-600" style="display: none" aria-live="polite"></p>
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi password baru" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            <p id="password-confirmation-client-error" class="mt-2 text-sm text-red-600" style="display: none" aria-live="polite"></p>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                Simpan password baru
            </x-primary-button>
        </div>
    </form>

    <script>
        (function () {
            const form = document.getElementById('resetPasswordForm');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const confirmation = document.getElementById('password_confirmation');

            if (!form || !email || !password || !confirmation) {
                return;
            }

            const emailError = document.getElementById('email-client-error');
            const passwordError = document.getElementById('password-client-error');
            const confirmationError = document.getElementById('password-confirmation-client-error');

            function setError(input, output, message) {
                output.textContent = message;
                output.style.display = message ? 'block' : 'none';
                input.style.borderColor = message ? '#dc2626' : '';
                input.setAttribute('aria-invalid', message ? 'true' : 'false');

                return !message;
            }

            function validateEmail() {
                const value = email.value.trim();
                let message = '';

                if (!value) {
                    message = 'Email wajib diisi.';
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(value)) {
                    message = 'Format email tidak valid.';
                }

                return setError(email, emailError, message);
            }

            function validatePassword() {
                return setError(
                    password,
                    passwordError,
                    password.value.length < 8 ? 'Password minimal 8 karakter.' : ''
                );
            }

            function validateConfirmation() {
                let message = '';

                if (!confirmation.value) {
                    message = 'Konfirmasi password wajib diisi.';
                } else if (confirmation.value !== password.value) {
                    message = 'Konfirmasi password tidak cocok.';
                }

                return setError(confirmation, confirmationError, message);
            }

            email.addEventListener('blur', validateEmail);
            email.addEventListener('input', function () {
                if (emailError.textContent) {
                    validateEmail();
                }
            });

            password.addEventListener('blur', validatePassword);
            password.addEventListener('input', function () {
                if (passwordError.textContent) {
                    validatePassword();
                }
                if (confirmation.value) {
                    validateConfirmation();
                }
            });

            confirmation.addEventListener('blur', validateConfirmation);
            confirmation.addEventListener('input', function () {
                if (confirmationError.textContent) {
                    validateConfirmation();
                }
            });

            form.addEventListener('submit', function (event) {
                const valid = validateEmail() & validatePassword() & validateConfirmation();

                if (!valid) {
                    event.preventDefault();

                    const firstInvalid = form.querySelector('[aria-invalid="true"]');
                    if (firstInvalid) {
                        firstInvalid.focus();
                    }
                }
            });
        })();
    </script>
</x-guest-layout>
