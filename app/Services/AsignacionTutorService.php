<?php

namespace App\Services;

use App\Models\Estudiante;
use Illuminate\Support\Facades\Log;

class AsignacionTutorService
{
    public function asignarPorGrupo(array $data): int
    {
        $actualizados = Estudiante::where('carrera', $data['carrera'])
            ->where('semestre', $data['semestre'])
            ->where('grupo', $data['grupo'])
            ->update(['tutor_id' => $data['tutor_id']]);

        Log::info('Asignacion de tutorias ejecutada', [
            'tutor_id' => $data['tutor_id'],
            'carrera' => $data['carrera'],
            'semestre' => $data['semestre'],
            'grupo' => $data['grupo'],
            'actualizados' => $actualizados,
        ]);

        return $actualizados;
    }
}
