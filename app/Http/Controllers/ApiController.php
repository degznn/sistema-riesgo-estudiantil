<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiStoreEntrevistaRequest;
use App\Models\Entrevista;
use App\Models\Estudiante;
use App\Models\Tutor;
use App\Services\EntrevistaService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct(private EntrevistaService $entrevistaService)
    {
    }

    public function estudiantes(Request $request)
    {
        $query = Estudiante::with(['periodo', 'tutor.user', 'ultimaEntrevista']);

        if ($request->filled('carrera')) {
            $query->where('carrera', $request->carrera);
        }

        if ($request->filled('semestre')) {
            $query->where('semestre', $request->semestre);
        }

        if ($request->filled('grupo')) {
            $query->where('grupo', $request->grupo);
        }

        return response()->json($query->orderBy('apellidos')->get());
    }

    public function tutores()
    {
        return response()->json(Tutor::with('user')->orderByDesc('id')->get());
    }

    public function entrevistas()
    {
        return response()->json(Entrevista::with(['estudiante', 'tutor.user', 'periodo'])->latest()->get());
    }

    public function guardarEntrevista(ApiStoreEntrevistaRequest $request)
    {
        $data = $request->validated();
        $estudiante = Estudiante::findOrFail($data['estudiante_id']);
        $entrevista = $this->entrevistaService->registrar($estudiante, $data);

        return response()->json($entrevista->load(['estudiante', 'tutor.user', 'periodo']), 201);
    }

    public function dashboard()
    {
        $resumen = [
            'Rojo' => Entrevista::where('nivel_riesgo', 'Rojo')->count(),
            'Ambar' => Entrevista::where('nivel_riesgo', 'Ambar')->count(),
            'Verde' => Entrevista::where('nivel_riesgo', 'Verde')->count(),
            'Total estudiantes' => Estudiante::count(),
        ];

        return response()->json($resumen);
    }
}
