<?php

namespace Database\Seeders;

use App\Models\Cabang;
use Illuminate\Database\Seeder;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cabang::factory()->create([
            'nama_cabang' => 'Transmart',
            'lokasi_cabang' => 'Jl. Gatsu',
            'kota_cabang' => 'Bandung',
            'email_cabang' => 'TransGatsu@gmail.com'
        ]);

        Cabang::factory()->create([
            'nama_cabang' => 'Griya Antapani',
            'lokasi_cabang' => 'Jl. Antapani',
            'kota_cabang' => 'Bandung',
            'email_cabang' => 'griyaAntap@gmail.com'
        ]);
    }
}
