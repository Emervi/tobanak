<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cabang',
        'nama_cabang',
        'lokasi_cabang',
        'kota_cabang',
        'email_cabang',
    ];
}
