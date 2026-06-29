<?php

namespace Database\Factories;

use App\Models\Entrevista;
use App\Models\Estudiante;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntrevistaFactory extends Factory
{
    public function definition(): array
    {
        $puntajes = [
            'rendimiento_academico' => fake()->numberBetween(1, 3),
            'bienestar_emocional' => fake()->numberBetween(1, 3),
            'trabajo_equipo' => fake()->numberBetween(1, 3),
            'comunicacion_efectiva' => fake()->numberBetween(1, 3),
            'trabajo_economia' => fake()->numberBetween(1, 3),
            'estres' => fake()->numberBetween(1, 3),
        ];

        $total = array_sum($puntajes);

        return [
            ...$puntajes,
            'estudiante_id' => Estudiante::factory(),
            'puntaje_total' => $total,
            'nivel_riesgo' => Entrevista::nivelPorPuntaje($total),
            'observaciones' => fake()->sentence(),
        ];
    }
}
