<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if (is_string($this->email)) {
            $this->merge([
                'email' => strtolower(trim($this->email)),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:255'],
            'email'   => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'current_password' => [
                'nullable',
                Rule::requiredIf(fn () => $this->input('email') !== $this->user()->email),
                'current_password',
            ],
            'phone'   => ['nullable', 'string', 'max:25'],
            'address' => ['nullable', 'string', 'max:500'],
            'photo'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah digunakan oleh akun lain.',
            'current_password.required' => 'Konfirmasi password wajib diisi untuk mengubah email.',
            'current_password.current_password' => 'Password yang Anda masukkan salah.',
            'phone.max'      => 'Nomor HP maksimal 25 karakter.',
            'photo.image'    => 'File foto harus berupa gambar.',
            'photo.mimes'    => 'Foto harus berformat JPEG, PNG, JPG, GIF, atau WEBP.',
            'photo.max'      => 'Ukuran foto maksimal 2 MB.',
        ];
    }
}
