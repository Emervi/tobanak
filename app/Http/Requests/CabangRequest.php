<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CabangRequest extends FormRequest
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
            'nama_cabang' => ['required', 'string'],
            'lokasi_cabang' => ['required'],
            'kota_cabang' => ['required'],
            'email_cabang' => ['required', 'email'],
        ];
    }

    public function messages()
    {
        return [
            'nama_cabang.required' => 'Nama cabang wajib diisi.',
            'nama_cabang.string' => 'Nama cabang wajib berupa string.',
            'lokasi_cabang.required' => 'lokasi cabang wajib diisi.',
            'kota_cabang.required' => 'Kota cabang wajib diisi.',
            'email_cabang.required' => 'Email cabang wajib diisi.',
            'email_cabang.email' => 'Email cabang wajib berupa email dan menggunakan @.',
        ];
    }
}
