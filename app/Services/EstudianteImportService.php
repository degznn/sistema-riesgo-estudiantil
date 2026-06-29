<?php

namespace App\Services;

use App\Imports\EstudiantesImport;
use App\Repositories\EstudianteRepository;
use Maatwebsite\Excel\Facades\Excel;

class EstudianteImportService
{
    public function __construct(private EstudianteRepository $estudiantes)
    {
    }

    public function importar($archivo, int $periodoId): array
    {
        $import = new EstudiantesImport($periodoId, $this->estudiantes);

        Excel::import($import, $archivo);

        return [
            'importados' => $import->importados(),
            'errores' => $import->errores(),
        ];
    }
}
