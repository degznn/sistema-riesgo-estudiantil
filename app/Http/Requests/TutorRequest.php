<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TutorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('gestionar tutores') ?? false;
    }

    public function rules(): array
    {
        $tutor = $this->route('tutor');

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'ends_with:@tecsup.edu.pe',
                Rule::unique('users', 'email')->ignore($tutor?->user_id),
            ],
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tutores', 'codigo')->ignore($tutor?->id),
            ],
            'telefono' => 'nullable|string|max:50',
            'especialidad' => 'nullable|string|max:255',
            'password' => $this->isMethod('post') ? 'required|string|min:6' : 'nullable|string|min:6',
            'activo' => 'nullable|boolean',
        ];
    }
}
