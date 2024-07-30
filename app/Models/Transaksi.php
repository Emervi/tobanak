<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'id_barang',
        'id_user',
        'kuantitas',
        'total_harga',
        'uang_pembayaran',
        'kembalian',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
