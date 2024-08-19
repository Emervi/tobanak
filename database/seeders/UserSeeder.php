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
            'status' => 'Admin',
            'id_cabang' => 1,
        ]);

        User::factory()->create([
            'username' => 'pelanggan1',
            'name' => 'User Transmart',
            'email' => 'userTransmart@user.com',
            'status' => 'Pelanggan',
            'id_cabang' => 1,
            'alamat' => 'Jl. Olahraga',
            'no_telp' => '0821-2140-5050',
        ]);

        User::factory()->create([
            'username' => 'kasir1',
            'name' => 'Kasir Transmart',
            'email' => 'kasirTransmart@kasir.com',
            'status' => 'Kasir',
            'id_cabang' => 1,
        ]);



        User::factory()->create([
            'username' => 'admin2',
            'name' => 'Admin Griya',
            'email' => 'adminGriya@admin.com',
            'status' => 'Admin',
            'id_cabang' => 2,
        ]);

        User::factory()->create([
            'username' => 'user2',
            'name' => 'User Griya',
            'email' => 'userGriya@user.com',
            'status' => 'Pelanggan',
            'id_cabang' => 2,
            'alamat' => 'Jl. Permata Bumi',
            'no_telp' => '0831-5029-2031',
        ]);

        User::factory()->create([
            'username' => 'kasir2',
            'name' => 'Kasir Griya',
            'email' => 'kasirGriya@kasir.com',
            'status' => 'Kasir',
            'id_cabang' => 2,
        ]);
    }
}
