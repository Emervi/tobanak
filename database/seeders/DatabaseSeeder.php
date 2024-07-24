<?php

namespace Database\Seeders;

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

        // Membuat satu admin dan satu user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'status' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@user.com',
            'status' => 'user',
        ]);

        $this->call(BarangSeeder::class);
    }
}
