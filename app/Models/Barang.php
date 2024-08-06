<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cabang',
        'foto_barang',
        'nama_barang',
        'kategori_barang',
        'deskripsi_barang',
        'stok_barang',
        'bahan',
        'harga',
        'diskon',
        'potongan',
        'distribusi'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_barang', 'id_barang');
    }
}
