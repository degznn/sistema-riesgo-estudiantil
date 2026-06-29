<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PeriodoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('gestionar periodos') ?? false;
    }

    public function rules(): array
    {
        $periodoId = $this->route('periodo')?->id;

        return [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('periodos', 'nombre')->ignore($periodoId)],
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'activo' => 'nullable|boolean',
        ];
    }
}
