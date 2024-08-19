<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekspedisis extends Model
{
    use HasFactory;

    protected $table = 'ekspedisis';

    protected $fillable = [
        'nama_ekspedisi',
        'jenis_pengiriman',
        'harga_ekspedisi',
        'estimasi_pengiriman',
    ];
}
