<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_barang',
        'kuantitas',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
