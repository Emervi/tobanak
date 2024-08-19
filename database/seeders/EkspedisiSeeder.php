<?php

namespace Database\Seeders;

use App\Models\Ekspedisis;
use Illuminate\Database\Seeder;

class EkspedisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ekspedisis::create([
            'nama_ekspedisi' => 'JNE',
            'jenis_pengiriman' => 'Reguler',
            'harga_ekspedisi' => 15000,
            'estimasi_pengiriman' => 3
        ]);

        Ekspedisis::create([
            'nama_ekspedisi' => 'JNT',
            'jenis_pengiriman' => 'Hemat',
            'harga_ekspedisi' => 10000,
            'estimasi_pengiriman' => 4
        ]);

        Ekspedisis::create([
            'nama_ekspedisi' => 'NinjaExpress',
            'jenis_pengiriman' => 'Express',
            'harga_ekspedisi' => 25000,
            'estimasi_pengiriman' => 2
        ]);

        Ekspedisis::create([
            'nama_ekspedisi' => 'GoSend',
            'jenis_pengiriman' => 'Same Day',
            'harga_ekspedisi' => 50000,
            'estimasi_pengiriman' => 1
        ]);

        Ekspedisis::create([
            'nama_ekspedisi' => 'Antaraja',
            'jenis_pengiriman' => 'Kargo',
            'harga_ekspedisi' => 8000,
            'estimasi_pengiriman' => 5
        ]);
    }
}
