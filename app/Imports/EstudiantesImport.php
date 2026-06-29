<?php

namespace App\Imports;

use App\Models\Estudiante;
use App\Repositories\EstudianteRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EstudiantesImport implements ToCollection, WithHeadingRow
{
    private int $importados = 0;
    private array $errores = [];
    private array $codigosEnArchivo = [];

    public function __construct(
        private int $periodoId,
        private EstudianteRepository $estudiantes
    ) {
    }

    public function collection(Collection $rows): void
    {
        $columnas = ['codigo', 'apellidos', 'nombres', 'carrera', 'semestre', 'grupo'];
        $filaNumero = 1;

        foreach ($rows as $row) {
            $filaNumero++;
            $data = $row->toArray();

            if (count(array_filter($data, fn ($valor) => trim((string) $valor) !== '')) === 0) {
                continue;
            }

            foreach ($columnas as $columna) {
                if (!array_key_exists($columna, $data)) {
                    $this->errores[] = "Fila {$filaNumero}: falta la columna {$columna}.";
                    continue 2;
                }
            }

            $codigo = trim((string) $data['codigo']);
            $grupo = strtoupper(trim((string) $data['grupo']));

            if ($codigo === '' || trim((string) $data['apellidos']) === '' || trim((string) $data['nombres']) === '' || trim((string) $data['carrera']) === '') {
                $this->errores[] = "Fila {$filaNumero}: codigo, apellidos, nombres y carrera son obligatorios.";
                continue;
            }

            if (!is_numeric($data['semestre'])) {
                $this->errores[] = "Fila {$filaNumero}: semestre debe ser numerico.";
                continue;
            }

            if (!preg_match('/^[A-Z]{2}$/', $grupo)) {
                $this->errores[] = "Fila {$filaNumero}: grupo debe tener dos letras, por ejemplo AB o CD.";
                continue;
            }

            if (in_array($codigo, $this->codigosEnArchivo, true)) {
                $this->errores[] = "Fila {$filaNumero}: codigo duplicado dentro del CSV ({$codigo}).";
                continue;
            }

            if ($this->estudiantes->existsInPeriodo($codigo, $this->periodoId)) {
                $this->errores[] = "Fila {$filaNumero}: codigo ya existe en este periodo ({$codigo}).";
                continue;
            }

            $this->codigosEnArchivo[] = $codigo;

            Estudiante::create([
                'codigo' => $codigo,
                'apellidos' => trim((string) $data['apellidos']),
                'nombres' => trim((string) $data['nombres']),
                'carrera' => trim((string) $data['carrera']),
                'semestre' => (int) $data['semestre'],
                'grupo' => $grupo,
                'periodo_id' => $this->periodoId,
            ]);

            $this->importados++;
        }

        Log::info('Importacion CSV de estudiantes finalizada', [
            'periodo_id' => $this->periodoId,
            'importados' => $this->importados,
            'errores' => count($this->errores),
        ]);
    }

    public function importados(): int
    {
        return $this->importados;
    }

    public function errores(): array
    {
        return $this->errores;
    }
}
