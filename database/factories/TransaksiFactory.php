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
            'id_user' => 1,
            'id_barang' => 1,
            'kuantitas' => rand(1,7),
            'total_harga' => rand(100000, 1000000),
            'uang_pembayaran' => rand(300000, 800000),
            'kembalian' => rand(1, 100000),
        ];
    }
}
