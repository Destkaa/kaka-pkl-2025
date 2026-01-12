<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            /**
             * Menggunakan 'sometimes' adalah kunci utamanya.
             * Validasi hanya akan berjalan JIKA field 'name' atau 'email' ada di dalam form.
             * Jika sedang update password, field ini tidak dikirim, maka akan dilewati.
             */
            'name' => [
                'sometimes', 
                'required', 
                'string', 
                'max:255'
            ],

            'email' => [
                'sometimes',
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            'phone' => [
                'nullable', 
                'string', 
                'max:20', 
                'regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/'
            ],

            'address' => [
                'nullable', 
                'string', 
                'max:500'
            ],

            'avatar' => [
                'nullable', 
                'image', 
                'mimes:jpeg,jpg,png,webp', 
                'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'email.required'    => 'Alamat email wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar gunakan email lain.',
            'phone.regex'       => 'Format nomor telepon tidak valid (Gunakan format 08xx atau +628xx).',
            'avatar.max'        => 'Ukuran foto maksimal 2MB.',
            'avatar.dimensions' => 'Dimensi foto minimal 100x100px dan maksimal 2000x2000px.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'    => 'nama lengkap',
            'email'   => 'alamat email',
            'phone'   => 'nomor telepon',
            'address' => 'alamat domisili',
            'avatar'  => 'foto profil',
        ];
    }
}