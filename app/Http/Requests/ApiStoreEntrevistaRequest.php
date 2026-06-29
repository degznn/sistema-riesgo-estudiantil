<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiStoreEntrevistaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'estudiante_id' => 'required|exists:estudiantes,id',
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
