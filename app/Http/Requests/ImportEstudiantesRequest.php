<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportEstudiantesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('importar estudiantes') ?? false;
    }

    public function rules(): array
    {
        return [
            'archivo_csv' => 'required|file|mimes:csv,txt',
            'periodo_id' => 'required|exists:periodos,id',
        ];
    }
}
