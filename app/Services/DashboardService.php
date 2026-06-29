<?php

namespace App\Services;

use App\Models\Entrevista;
use App\Models\Tutor;
use App\Repositories\EstudianteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DashboardService
{
    public function __construct(private EstudianteRepository $estudiantes)
    {
    }

    public function data(Request $request): array
    {
        $query = $this->estudiantes->queryForUser($request->user());

        if ($request->filled('tutor_id')) {
            $query->where('tutor_id', $request->tutor_id);
        }

        foreach (['carrera', 'semestre', 'grupo'] as $campo) {
            if ($request->filled($campo)) {
                $query->where($campo, $request->$campo);
            }
        }

        $estudiantes = $query->orderBy('carrera')->orderBy('semestre')->orderBy('grupo')->get();
        $resumen = ['Rojo' => 0, 'Ambar' => 0, 'Verde' => 0, 'Sin entrevista' => 0];

        foreach ($estudiantes as $estudiante) {
            $nivel = optional($estudiante->ultimaEntrevista)->nivel_riesgo ?? 'Sin entrevista';
            $resumen[$nivel] = ($resumen[$nivel] ?? 0) + 1;
        }

        $kpis = [
            'total_estudiantes' => $estudiantes->count(),
            'total_tutores' => Tutor::where('activo', true)->count(),
            'entrevistas_realizadas' => $this->entrevistasParaUsuario($request)->count(),
            'riesgo_alto' => $resumen['Rojo'],
            'riesgo_medio' => $resumen['Ambar'],
            'riesgo_bajo' => $resumen['Verde'],
        ];

        $riesgoPorCarrera = $this->riesgoPorCarrera($estudiantes);
        $entrevistasPorPeriodo = $this->entrevistasPorPeriodo($request);

        return compact('estudiantes', 'resumen', 'kpis', 'riesgoPorCarrera', 'entrevistasPorPeriodo');
    }

    private function riesgoPorCarrera(Collection $estudiantes): array
    {
        $carreras = $estudiantes->pluck('carrera')->filter()->unique()->sort()->values();

        return [
            'labels' => $carreras,
            'rojo' => $carreras->map(fn ($carrera) => $this->contarRiesgo($estudiantes, $carrera, 'Rojo'))->values(),
            'ambar' => $carreras->map(fn ($carrera) => $this->contarRiesgo($estudiantes, $carrera, 'Ambar'))->values(),
            'verde' => $carreras->map(fn ($carrera) => $this->contarRiesgo($estudiantes, $carrera, 'Verde'))->values(),
        ];
    }

    private function contarRiesgo(Collection $estudiantes, string $carrera, string $nivel): int
    {
        return $estudiantes
            ->filter(fn ($estudiante) => $estudiante->carrera === $carrera)
            ->filter(fn ($estudiante) => optional($estudiante->ultimaEntrevista)->nivel_riesgo === $nivel)
            ->count();
    }

    private function entrevistasPorPeriodo(Request $request): array
    {
        $entrevistas = $this->entrevistasParaUsuario($request)
            ->with('periodo')
            ->get()
            ->groupBy(fn ($entrevista) => optional($entrevista->periodo)->nombre ?? 'Sin periodo')
            ->map->count()
            ->sortKeys();

        return [
            'labels' => $entrevistas->keys()->values(),
            'totales' => $entrevistas->values(),
        ];
    }

    private function entrevistasParaUsuario(Request $request)
    {
        $query = Entrevista::query();

        if ($request->user()?->role === 'tutor') {
            $query->where('tutor_id', optional($request->user()->tutor)->id);
        }

        return $query;
    }
}
