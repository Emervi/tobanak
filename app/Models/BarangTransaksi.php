<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangTransaksi extends Model
{
    use HasFactory;

    protected $table = 'barang_transaksis';

    protected $fillable = [
        'id_transaksi',
        'id_barang',
        'kuantitas',
        'total_harga_barang',
    ];
}
