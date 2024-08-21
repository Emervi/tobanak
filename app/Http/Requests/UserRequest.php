<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'id_cabang' => ['required'],
            'username' => ['required', 'unique:users,username', 'min:6'],
            'name' => ['required', 'string', 'max:35'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required', 'min:8'],
            'password2' => ['required', 'same:password'],
            'status' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'id_cabang.required' => 'Cabang wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'username.min' => 'Username harus memiliki minimal 6 karakter.',
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama wajib berupa huruf.',
            'name.max' => 'Nama tidak boleh lebih dari 35 huruf.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password2.required' => 'Konfirmasi password wajib diisi.',
            'password2.same' => 'Password dan konfirmasi password tidak cocok.',
            'status.required' => 'Status wajib diisi.',
        ];
    }
}
