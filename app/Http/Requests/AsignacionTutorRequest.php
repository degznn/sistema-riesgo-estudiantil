<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsignacionTutorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('asignar tutorias') ?? false;
    }

    public function rules(): array
    {
        return [
            'tutor_id' => 'required|exists:tutores,id',
            'carrera' => 'required|string',
            'semestre' => 'required|integer',
            'grupo' => 'required|string',
        ];
    }
}
