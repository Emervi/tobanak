<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Cabang;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // User::factory()->count(10)->create();
        
        $this->call(CabangSeeder::class);

        $this->call(UserSeeder::class);

        $this->call(BarangSeeder::class);

        // $this->call(TransaksiSeeder::class);

        $this->call(EkspedisiSeeder::class);
    }
}
