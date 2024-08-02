<?php

namespace Database\Seeders;

use App\Models\Barang;
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
        // Membuat satu admin dan satu user
        // User::factory()->create([
        //     'username' => 'admin',
        //     'name' => 'Admin User',
        //     'email' => 'admin@admin.com',
        //     'status' => 'admin',
        // ]);

        // User::factory()->create([
        //     'username' => 'user',
        //     'name' => 'Regular User',
        //     'email' => 'user@user.com',
        //     'status' => 'user',
        // ]);

        $this->call(BarangSeeder::class);

        // $this->call(TransaksiSeeder::class);
    }
}
