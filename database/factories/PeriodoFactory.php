<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => fake()->unique()->year() . '-' . fake()->randomElement(['I', 'II']),
            'fecha_inicio' => now()->startOfYear(),
            'fecha_fin' => now()->endOfYear(),
            'activo' => false,
        ];
    }
}
