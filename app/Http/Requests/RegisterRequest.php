<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => ['required', 'unique:users,username', 'min:6'],
            'name' => ['required', 'string', 'max:35'],
            'email' => ['required', 'unique:users,email', 'email'],
            'no_telp' => ['required'],
            'password' => ['required', 'min:8'],
            'password2' => ['required', 'same:password'],
            'alamat' => ['required'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'username.min' => 'Username harus memiliki minimal 6 karakter.',
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama wajib berupa huruf.',
            'name.max' => 'Nama tidak boleh lebih dari 35 huruf.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password2.required' => 'Konfirmasi password wajib diisi.',
            'password2.same' => 'Password dan konfirmasi password tidak cocok.',
            'alamat.required' => 'Alamat wajib diisi.',
        ];
    }
}
