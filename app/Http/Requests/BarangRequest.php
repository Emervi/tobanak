<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangRequest extends FormRequest
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
            'nama_barang' => ['required', 'unique:barangs', 'string'],
            'kategori_barang' => ['required'],
            'deskripsi_barang' => ['required'],
            'stok_barang' => ['required', 'integer'],
            'bahan' => ['required'],
            'foto_barang' => ['image', 'mimes:jpeg,png,jpg'],
            'diskon' => ['numeric', 'nullable'],
            'potongan' => ['numeric', 'nullable'],
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
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.unique' => 'Nama barang sudah terdaftar',
            'nama_barang.alpha' => 'Nama barang tidak boleh mengandung angka',
            'kategori_barang.required' => 'Kategori wajib diisi',
            'deskripsi_barang.required' => 'Deskripsi barang wajib diisi',
            'stok_barang.required' => 'Stok barang wajib diisi',
            'stok_barang.integer' => 'Stok barang wajib bernilai bilangan bulat',
            'bahan.required' => 'Bahan wajib diisi',
            'diskon.numeric' => 'Masukan diskon yang valid',
            'potongan.numeric' => 'Masukan potongan yang valid',
            'foto_barang.image' => 'File yang dimasukan harus berupa image',
            'foto_barang.mimes' => 'File yang dimasukan harus berformat berikut : jpeg, png, jpg',
        ];
    }
}
