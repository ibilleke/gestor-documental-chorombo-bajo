<?php

namespace Database\Factories;

use App\Models\Rol;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rol>
 */
class RolFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => 'Rol '.fake()->unique()->numerify('####'),
            'descripcion' => fake()->sentence(),
            'delicado' => false,
        ];
    }

    public function delicado(): static
    {
        return $this->state(fn (array $attributes) => [
            'delicado' => true,
        ]);
    }
}
