<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Tutor;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService)
    {
    }

    public function index(Request $request)
    {
        $dashboard = $this->dashboardService->data($request);

        if ($request->user()->hasRole('tutor')) {
            return view('dashboard.tutor', [
                ...$dashboard,
            ]);
        }

        return view('dashboard.index', [
            ...$dashboard,
            'tutores' => Tutor::with('user')->where('activo', true)->get(),
            'carreras' => Estudiante::select('carrera')->distinct()->orderBy('carrera')->pluck('carrera'),
            'semestres' => Estudiante::select('semestre')->distinct()->orderBy('semestre')->pluck('semestre'),
            'grupos' => Estudiante::select('grupo')->distinct()->orderBy('grupo')->pluck('grupo'),
            'filtros' => $request->only(['tutor_id', 'carrera', 'semestre', 'grupo']),
        ]);
    }
}
