<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_barang',
        'id_user',
        'id_transaksi',
        'rating',
        'review',
    ];

    // Relasi ke model Barang (Produk)
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function barangTransaksi()
    {
        return $this->belongsTo(BarangTransaksi::class, 'id_transaksi', 'id_transaksi');
    }

}
