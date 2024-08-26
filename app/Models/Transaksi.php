<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'tanggal',
        'id_user',
        'total_harga',
        'uang_pembayaran',
        'kembalian',
        'id_cabang',
        'alamat',
        'metode_pembayaran',
        'id_ekspedisi',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function barangTransaksi()
    {
        return $this->hasMany(BarangTransaksi::class, ' id_transaksi', 'id_transaksi');
    }
  
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
