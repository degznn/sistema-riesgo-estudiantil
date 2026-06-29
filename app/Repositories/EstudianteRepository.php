<?php

namespace App\Repositories;

use App\Models\Estudiante;

class EstudianteRepository
{
    public function queryForUser($user)
    {
        $query = Estudiante::with(['periodo', 'tutor.user', 'ultimaEntrevista']);

        if ($user?->role === 'tutor') {
            $query->where('tutor_id', optional($user->tutor)->id);
        }

        return $query;
    }

    public function orderedForUser($user)
    {
        return $this->queryForUser($user)
            ->orderBy('carrera')
            ->orderBy('semestre')
            ->orderBy('grupo')
            ->orderBy('apellidos')
            ->get();
    }

    public function existsInPeriodo(string $codigo, int $periodoId): bool
    {
        return Estudiante::where('codigo', $codigo)
            ->where('periodo_id', $periodoId)
            ->exists();
    }
}
