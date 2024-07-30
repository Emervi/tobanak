<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'foto_barang',
        'nama_barang',
        'kategori_barang',
        'deskripsi_barang',
        'stok_barang',
        'bahan',
        'harga',
        'diskon',
        'potongan',
    ];
}
