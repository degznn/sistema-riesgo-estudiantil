<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsignacionTutorRequest;
use App\Models\Estudiante;
use App\Models\Tutor;
use App\Services\AsignacionTutorService;

class AsignacionController extends Controller
{
    public function __construct(private AsignacionTutorService $asignacionService)
    {
    }

    public function index()
    {
        return view('asignaciones.index', [
            'tutores' => Tutor::with('user')->where('activo', true)->get(),
            'carreras' => Estudiante::select('carrera')->distinct()->orderBy('carrera')->pluck('carrera'),
            'semestres' => Estudiante::select('semestre')->distinct()->orderBy('semestre')->pluck('semestre'),
            'grupos' => Estudiante::select('grupo')->distinct()->orderBy('grupo')->pluck('grupo'),
            'estudiantes' => Estudiante::with('tutor.user')->orderBy('carrera')->orderBy('semestre')->orderBy('grupo')->get(),
        ]);
    }

    public function store(AsignacionTutorRequest $request)
    {
        $actualizados = $this->asignacionService->asignarPorGrupo($request->validated());

        return back()->with('success', 'Estudiantes asignados: ' . $actualizados);
    }
}
