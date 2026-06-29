<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntrevistaRequest extends FormRequest
{
    public function authorize(): bool
    {
        $estudiante = $this->route('estudiante');

        return $estudiante && ($this->user()?->can('create', [\App\Models\Entrevista::class, $estudiante]) ?? false);
    }

    public function rules(): array
    {
        return [
            'rendimiento_academico' => 'required|in:1,2,3',
            'bienestar_emocional' => 'required|in:1,2,3',
            'trabajo_equipo' => 'required|in:1,2,3',
            'comunicacion_efectiva' => 'required|in:1,2,3',
            'trabajo_economia' => 'required|in:1,2,3',
            'estres' => 'required|in:1,2,3',
            'observaciones' => 'nullable|string|max:2000',
        ];
    }
}
