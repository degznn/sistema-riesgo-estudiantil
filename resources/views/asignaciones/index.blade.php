@extends('layouts.app')

@section('title', 'Asignacion de tutorias')

@section('content')
<h1 class="h3 mb-3">Asignacion de tutorias</h1>

<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('asignaciones.store') }}" method="POST" class="row g-3 align-items-end">
            @csrf
            <div class="col-md-3"><label class="form-label">Tutor</label><select name="tutor_id" class="form-select" required><option value="">Seleccione</option>@foreach ($tutores as $tutor)<option value="{{ $tutor->id }}">{{ $tutor->user->name }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">Carrera</label><select name="carrera" class="form-select" required><option value="">Seleccione</option>@foreach ($carreras as $carrera)<option value="{{ $carrera }}">{{ $carrera }}</option>@endforeach</select></div>
            <div class="col-md-2"><label class="form-label">Ciclo</label><select name="semestre" class="form-select" required><option value="">Seleccione</option>@foreach ($semestres as $semestre)<option value="{{ $semestre }}">{{ $semestre }}</option>@endforeach</select></div>
            <div class="col-md-2"><label class="form-label">Grupo</label><select name="grupo" class="form-select" required><option value="">Seleccione</option>@foreach ($grupos as $grupo)<option value="{{ $grupo }}">{{ $grupo }}</option>@endforeach</select></div>
            <div class="col-md-2"><button class="btn btn-primary w-100">Asignar</button></div>
        </form>
    </div>
</div>

<div class="card"><div class="card-body table-responsive">
    <table class="table table-sm align-middle">
        <thead><tr><th>Codigo</th><th>Estudiante</th><th>Carrera</th><th>Ciclo</th><th>Grupo</th><th>Tutor</th></tr></thead>
        <tbody>
            @forelse ($estudiantes as $estudiante)
                <tr><td>{{ $estudiante->codigo }}</td><td>{{ $estudiante->apellidos }}, {{ $estudiante->nombres }}</td><td>{{ $estudiante->carrera }}</td><td>{{ $estudiante->semestre }}</td><td>{{ $estudiante->grupo }}</td><td>{{ optional(optional($estudiante->tutor)->user)->name ?? 'Sin tutor' }}</td></tr>
            @empty
                <tr><td colspan="6">No hay estudiantes cargados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div></div>
@endsection
