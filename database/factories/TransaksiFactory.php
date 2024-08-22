<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tanggal' => now(),
            'id_user' => 2,
            'total_harga' => rand(100000, 1000000),
            'uang_pembayaran' => rand(300000, 800000),
            'kembalian' => rand(1, 100000),
            'id_cabang' => rand(1,2),
            'alamat' => 'Jl. olahraga',
            'metode_pembayaran' => 'COD',
            'id_ekspedisi' => rand(1, 5),
        ];
    }
}
