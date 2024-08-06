<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CabangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_cabang' => $this->faker->word(),
            'lokasi_cabang' => $this->faker->sentence(),
            'kota_cabang' => $this->faker->word(),
            'email_cabang' => $this->faker->safeEmail(),
        ];
    }
}
