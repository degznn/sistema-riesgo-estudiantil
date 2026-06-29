<?php

namespace App\Policies;

use App\Models\Estudiante;
use App\Models\User;

class EstudiantePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('administrador', 'bienestar', 'tutor');
    }

    public function view(User $user, Estudiante $estudiante): bool
    {
        if ($user->hasRole('administrador', 'bienestar')) {
            return true;
        }

        return $user->role === 'tutor' && $estudiante->tutor_id === optional($user->tutor)->id;
    }

    public function import(User $user): bool
    {
        return $user->hasRole('administrador', 'bienestar');
    }
}
