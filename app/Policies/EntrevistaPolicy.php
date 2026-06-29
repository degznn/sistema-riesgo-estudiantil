<?php

namespace App\Policies;

use App\Models\Entrevista;
use App\Models\Estudiante;
use App\Models\User;

class EntrevistaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('administrador', 'bienestar', 'tutor');
    }

    public function create(User $user, Estudiante $estudiante): bool
    {
        if ($user->hasRole('administrador', 'bienestar')) {
            return true;
        }

        return $user->role === 'tutor' && $estudiante->tutor_id === optional($user->tutor)->id;
    }
}
