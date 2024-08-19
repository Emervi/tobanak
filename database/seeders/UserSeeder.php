<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'username' => 'admin1',
            'name' => 'Admin Transmart',
            'email' => 'adminTransmart@admin.com',
            'status' => 'admin',
            'id_cabang' => 1,
        ]);

        User::factory()->create([
            'username' => 'user1',
            'name' => 'User Transmart',
            'email' => 'userTransmart@user.com',
            'status' => 'user',
            'id_cabang' => 1,
            'alamat' => 'Jl. Olahraga'
        ]);



        User::factory()->create([
            'username' => 'admin2',
            'name' => 'Admin Griya',
            'email' => 'adminGriya@admin.com',
            'status' => 'admin',
            'id_cabang' => 2,
        ]);

        User::factory()->create([
            'username' => 'user2',
            'name' => 'User Griya',
            'email' => 'userGriya@user.com',
            'status' => 'user',
            'id_cabang' => 2,
            'alamat' => 'Jl. Permata Bumi'
        ]);
    }
}
