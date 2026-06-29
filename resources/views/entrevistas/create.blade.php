@extends('layouts.app')

@section('title', 'Nueva entrevista')

@section('content')
<h1 class="h3 mb-3">Nueva entrevista</h1>

<div class="card mb-3">
    <div class="card-body">
        <h2 class="h5">{{ $estudiante->apellidos }}, {{ $estudiante->nombres }}</h2>
        <p class="text-muted mb-0">{{ $estudiante->carrera }} | Ciclo {{ $estudiante->semestre }} | Grupo {{ $estudiante->grupo }}</p>
    </div>
</div>

<form action="{{ route('entrevistas.store', $estudiante) }}" method="POST" class="card">
    @csrf
    <div class="card-body">
        @php
            $indicadores = [
                'rendimiento_academico' => 'Rendimiento academico',
                'bienestar_emocional' => 'Bienestar emocional',
                'trabajo_equipo' => 'Trabajo en equipo',
                'comunicacion_efectiva' => 'Comunicacion efectiva',
                'trabajo_economia' => 'Trabajo / economia',
                'estres' => 'Estres',
            ];
        @endphp

        <div class="row g-3">
            @foreach ($indicadores as $campo => $label)
                <div class="col-md-6">
                    <label class="form-label">{{ $label }}</label>
                    <select name="{{ $campo }}" class="form-select indicador" required>
                        <option value="">Seleccione</option>
                        <option value="3">Alto</option>
                        <option value="2">Medio</option>
                        <option value="1">Bajo</option>
                    </select>
                </div>
            @endforeach
            <div class="col-12">
                <label class="form-label">Observaciones</label>
                <textarea name="observaciones" class="form-control" rows="4"></textarea>
            </div>
        </div>

        <div class="alert alert-secondary mt-3">
            Puntaje total: <strong id="puntaje">0</strong> | Riesgo: <strong id="riesgo">Sin calcular</strong>
        </div>

        <button class="btn btn-primary">Guardar entrevista</button>
        <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
    const selects = document.querySelectorAll('.indicador');
    const puntaje = document.getElementById('puntaje');
    const riesgo = document.getElementById('riesgo');

    function calcular() {
        let total = 0;
        selects.forEach(select => total += Number(select.value || 0));
        puntaje.textContent = total;
        riesgo.textContent = total >= 14 ? 'Rojo' : (total >= 8 ? 'Ambar' : (total > 0 ? 'Verde' : 'Sin calcular'));
    }

    selects.forEach(select => select.addEventListener('change', calcular));
</script>
@endpush
