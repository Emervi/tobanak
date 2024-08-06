<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $bahan = ['Tebal', 'Street', 'Sedang', 'Tipis'];

        $kategori = ['Aksesoris', 'Kaos', 'Celana', 'Topi'];

        return [
            'nama_barang' => $this->faker->word(),
            'stok_barang' => $this->faker->numberBetween(1, 25),
            'deskripsi_barang' => $this->faker->sentence(),
            'foto_barang' => 'noPhoto.jpg',
            'kategori_barang' => $this->faker->randomElement($kategori),
            'bahan' => $this->faker->randomElement($bahan),
            'harga' => $this->faker->numberBetween(200000, 260000),
            'diskon' => $this->faker->numberBetween(1, 90),
            'potongan' => $this->faker->numberBetween(1000, 75000)
        ];
    }
}
