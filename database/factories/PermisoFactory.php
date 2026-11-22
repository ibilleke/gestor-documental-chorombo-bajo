<?php

namespace Database\Factories;

use App\Models\Permiso;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Permiso>
 */
class PermisoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => 'modulo'.fake()->unique()->numerify('####').'.ver',
            'descripcion' => fake()->sentence(),
            'sensible' => false,
        ];
    }

    public function sensible(): static
    {
        return $this->state(fn (array $attributes) => [
            'sensible' => true,
        ]);
    }
}
