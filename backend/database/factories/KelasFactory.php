<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    public function definition()
    {
        return [
            'nama_kelas' => $this->faker->randomElement(['X IPA 1', 'X IPA 2', 'XI IPS 1']),
        ];
    }
}
