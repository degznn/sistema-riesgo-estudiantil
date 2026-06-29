<?php

namespace App\Policies;

use App\Models\User;

class TutorPolicy
{
    public function manage(User $user): bool
    {
        return $user->hasRole('administrador', 'bienestar');
    }
}
