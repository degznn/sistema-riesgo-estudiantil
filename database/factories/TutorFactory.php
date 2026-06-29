<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TutorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'codigo' => 'TUT-' . fake()->unique()->numberBetween(100, 999),
            'telefono' => fake()->numerify('9########'),
            'especialidad' => fake()->randomElement(['Bienestar', 'Academico', 'Psicopedagogia']),
            'activo' => true,
        ];
    }
}
