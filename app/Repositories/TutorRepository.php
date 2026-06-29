<?php

namespace App\Repositories;

use App\Models\Tutor;

class TutorRepository
{
    public function activos()
    {
        return Tutor::with('user')->where('activo', true)->orderBy('id')->get();
    }

    public function todos()
    {
        return Tutor::with('user')->orderByDesc('id')->get();
    }
}
