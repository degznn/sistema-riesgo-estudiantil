<?php

namespace App\Services;

use App\Models\Entrevista;
use App\Models\Estudiante;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class EntrevistaService
{
    private array $indicadores = [
        'rendimiento_academico',
        'bienestar_emocional',
        'trabajo_equipo',
        'comunicacion_efectiva',
        'trabajo_economia',
        'estres',
    ];

    public function registrar(Estudiante $estudiante, array $data): Entrevista
    {
        $puntaje = collect($this->indicadores)->sum(fn ($campo) => (int) $data[$campo]);

        $entrevista = Entrevista::create([
            ...Arr::only($data, $this->indicadores),
            'estudiante_id' => $estudiante->id,
            'tutor_id' => $estudiante->tutor_id,
            'periodo_id' => $estudiante->periodo_id,
            'puntaje_total' => $puntaje,
            'nivel_riesgo' => Entrevista::nivelPorPuntaje($puntaje),
            'observaciones' => $data['observaciones'] ?? null,
        ]);

        Log::info('Entrevista registrada', [
            'entrevista_id' => $entrevista->id,
            'estudiante_id' => $estudiante->id,
            'nivel_riesgo' => $entrevista->nivel_riesgo,
        ]);

        return $entrevista;
    }
}
