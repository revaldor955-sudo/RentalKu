<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Lupa password? Tidak masalah. Masukkan email akun Anda dan kami akan mengirim tautan untuk membuat password baru.
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm" novalidate>
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <p id="email-client-error" class="mt-2 text-sm text-red-600" style="display: none" aria-live="polite"></p>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                Kirim tautan reset password
            </x-primary-button>
        </div>
    </form>

    <script>
        (function () {
            const form = document.getElementById('forgotPasswordForm');
            const email = document.getElementById('email');
            const error = document.getElementById('email-client-error');

            if (!form || !email || !error) {
                return;
            }

            function validateEmail() {
                const value = email.value.trim();
                let message = '';

                if (!value) {
                    message = 'Email wajib diisi.';
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(value)) {
                    message = 'Format email tidak valid.';
                }

                error.textContent = message;
                error.style.display = message ? 'block' : 'none';
                email.style.borderColor = message ? '#dc2626' : '';
                email.setAttribute('aria-invalid', message ? 'true' : 'false');

                return !message;
            }

            email.addEventListener('blur', validateEmail);
            email.addEventListener('input', function () {
                if (error.textContent) {
                    validateEmail();
                }
            });
            form.addEventListener('submit', function (event) {
                if (!validateEmail()) {
                    event.preventDefault();
                }
            });
        })();
    </script>
</x-guest-layout>
