<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provedores>
 */
class ProvedoresFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'nombre' => $this->faker->company(),
        'correo' => $this->faker->unique()->safeEmail(),
        'telefono' => $this->faker->phoneNumber(),
    ];
    }
}
