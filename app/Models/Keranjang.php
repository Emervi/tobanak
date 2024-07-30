<?php

// app/Models/Keranjang.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjangs';

    protected $primaryKey = 'id_keranjang';

    protected $fillable = [
        'id_user',
        'id_barang',
        'kuantitas',
    ];

    // Definisikan hubungan dengan model Barang jika diperlukan
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
  
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
