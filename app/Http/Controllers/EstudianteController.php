<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportEstudiantesRequest;
use App\Models\Periodo;
use App\Repositories\EstudianteRepository;
use App\Services\EstudianteImportService;
use Illuminate\Support\Facades\Log;

class EstudianteController extends Controller
{
    public function __construct(
        private EstudianteRepository $estudiantes,
        private EstudianteImportService $importService
    ) {
    }

    public function index()
    {
        $periodos = Periodo::orderByDesc('activo')
            ->orderByDesc('id')
            ->get();

        $estudiantes = $this->estudiantes->orderedForUser(auth()->user());

        return view('estudiantes.index', compact('estudiantes', 'periodos'));
    }

    public function importar(ImportEstudiantesRequest $request)
    {
        try {
            $resultado = $this->importService->importar($request->file('archivo_csv'), (int) $request->periodo_id);
        } catch (\Throwable $exception) {
            Log::error('Error importando estudiantes', ['message' => $exception->getMessage()]);

            return back()->with('error', 'No se pudo procesar el CSV. Revise el formato del archivo.');
        }

        $mensaje = 'Importacion completada. Estudiantes cargados: ' . $resultado['importados'];

        return back()
            ->with('success', $mensaje)
            ->with('import_errors', $resultado['errores']);
    }
}
