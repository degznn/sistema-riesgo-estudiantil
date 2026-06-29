@extends('layouts.app')

@section('title', 'Estudiantes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h3 mb-0">Estudiantes</h1>
        <p class="text-muted mb-0">Carga masiva por CSV y listado por carrera, ciclo y grupo.</p>
    </div>
</div>

@if (auth()->user()->hasRole('administrador', 'bienestar'))
    <div class="card mb-3">
        <div class="card-body">
            <h2 class="h5">Importar CSV</h2>
            <form action="{{ route('estudiantes.importar') }}" method="POST" enctype="multipart/form-data" class="row g-3 align-items-end">
                @csrf
                <div class="col-md-4">
                    <label class="form-label">Periodo academico</label>
                    <select name="periodo_id" class="form-select" required>
                        <option value="">Seleccione un periodo</option>
                        @foreach ($periodos as $periodo)
                            <option value="{{ $periodo->id }}">{{ $periodo->nombre }} {{ $periodo->activo ? '(Activo)' : '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Archivo CSV</label>
                    <input type="file" name="archivo_csv" class="form-control" accept=".csv" required>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100">Importar</button>
                </div>
            </form>
            <div class="form-text mt-2">Columnas: codigo, apellidos, nombres, carrera, semestre, grupo. Grupo: AB, CD, EF.</div>
        </div>
    </div>
@endif

@if (session('import_errors') && count(session('import_errors')) > 0)
    <div class="alert alert-warning">
        <strong>Filas omitidas:</strong>
        <ul class="mb-0">
            @foreach (session('import_errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Apellidos</th>
                        <th>Nombres</th>
                        <th>Carrera</th>
                        <th>Ciclo</th>
                        <th>Grupo</th>
                        <th>Tutor</th>
                        <th>Periodo</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($estudiantes->groupBy('carrera') as $carrera => $porCarrera)
                        <tr class="table-primary"><td colspan="9"><strong>{{ $carrera }}</strong></td></tr>
                        @foreach ($porCarrera->groupBy(fn ($item) => $item->semestre . '-' . $item->grupo) as $porGrupo)
                            @php $primero = $porGrupo->first(); @endphp
                            <tr class="table-light"><td colspan="9">Ciclo {{ $primero->semestre }} - Grupo {{ $primero->grupo }}</td></tr>
                            @foreach ($porGrupo as $estudiante)
                                <tr>
                                    <td>{{ $estudiante->codigo }}</td>
                                    <td>{{ $estudiante->apellidos }}</td>
                                    <td>{{ $estudiante->nombres }}</td>
                                    <td>{{ $estudiante->carrera }}</td>
                                    <td>{{ $estudiante->semestre }}</td>
                                    <td>{{ $estudiante->grupo }}</td>
                                    <td>{{ optional(optional($estudiante->tutor)->user)->name ?? 'Sin tutor' }}</td>
                                    <td>{{ optional($estudiante->periodo)->nombre ?? '-' }}</td>
                                    <td><a class="btn btn-sm btn-outline-primary" href="{{ route('entrevistas.create', $estudiante) }}">Entrevistar</a></td>
                                </tr>
                            @endforeach
                        @endforeach
                    @empty
                        <tr><td colspan="9">No hay estudiantes cargados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
