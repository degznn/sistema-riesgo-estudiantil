<?php

namespace Database\Factories;

use App\Models\Periodo;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstudianteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'codigo' => (string) fake()->unique()->numberBetween(2024001, 2024999),
            'apellidos' => fake()->lastName() . ' ' . fake()->lastName(),
            'nombres' => fake()->firstName() . ' ' . fake()->firstName(),
            'carrera' => fake()->randomElement(['Diseno y Desarrollo de Software', 'Big Data y Ciencia de Datos', 'Administracion de Redes y Comunicaciones']),
            'semestre' => fake()->numberBetween(1, 6),
            'grupo' => fake()->randomElement(['AB', 'CD', 'EF']),
            'periodo_id' => Periodo::factory(),
            'tutor_id' => Tutor::factory(),
        ];
    }
}
