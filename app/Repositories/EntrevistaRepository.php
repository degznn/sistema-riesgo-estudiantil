<?php

namespace App\Repositories;

use App\Models\Entrevista;

class EntrevistaRepository
{
    public function latestForUser($user)
    {
        $query = Entrevista::with(['estudiante', 'tutor.user', 'periodo'])->latest();

        if ($user?->role === 'tutor') {
            $query->where('tutor_id', optional($user->tutor)->id);
        }

        return $query->get();
    }
}
