<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Izinkan user untuk melakukan request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi.
     */
    public function rules(): array
    {
        return [
            /**
             * 'required_without:avatar' artinya:
             * Field ini wajib diisi HANYA JIKA 'avatar' tidak ada dalam request.
             * Jadi saat klik "Simpan Foto", Laravel tidak akan mencari 'name'.
             */
            'name' => [
                'nullable', 
                'string', 
                'max:255', 
                'required_without:avatar'
            ],

            'email' => [
                'nullable',
                'string',
                'lowercase',
                'email',
                'max:255',
                'required_without:avatar',
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

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'name.required_without'  => 'Nama wajib diisi jika tidak sedang mengupdate foto.',
            'email.required_without' => 'Email wajib diisi jika tidak sedang mengupdate foto.',
            'phone.regex'            => 'Format nomor telepon tidak valid.',
            'avatar.max'             => 'Ukuran foto maksimal 2MB.',
            'avatar.dimensions'      => 'Dimensi foto tidak sesuai.',
        ];
    }

    /**
     * Nama atribut untuk pesan error.
     */
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