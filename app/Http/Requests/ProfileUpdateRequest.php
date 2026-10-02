<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
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
            'phone.max'      => 'Nomor HP maksimal 25 karakter.',
            'photo.image'    => 'File foto harus berupa gambar.',
            'photo.mimes'    => 'Foto harus berformat JPEG, PNG, JPG, GIF, atau WEBP.',
            'photo.max'      => 'Ukuran foto maksimal 2 MB.',
        ];
    }
}
