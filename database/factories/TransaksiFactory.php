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
            'tanggal' => $this->faker->date('Y-m-d'),
            'id_user' => rand(1,3),
            'id_barang' => rand(6,9),
            'kuantitas' => rand(0,11),
            'total_harga' => rand(100000, 1000000),
            'uang_pembayaran' => rand(300000, 800000),
            'kembalian' => rand(1, 100000),
        ];
    }
}
