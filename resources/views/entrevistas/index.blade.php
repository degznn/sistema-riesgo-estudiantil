@extends('layouts.app')

@section('title', 'Entrevistas')

@section('content')
<h1 class="h3 mb-3">Entrevistas registradas</h1>

<div class="card"><div class="card-body table-responsive">
    <table class="table align-middle">
        <thead><tr><th>Fecha</th><th>Estudiante</th><th>Tutor</th><th>Puntaje</th><th>Riesgo</th><th>Observaciones</th></tr></thead>
        <tbody>
            @forelse ($entrevistas as $entrevista)
                <tr>
                    <td>{{ $entrevista->created_at->format('d/m/Y') }}</td>
                    <td>{{ $entrevista->estudiante->apellidos }}, {{ $entrevista->estudiante->nombres }}</td>
                    <td>{{ optional(optional($entrevista->tutor)->user)->name ?? '-' }}</td>
                    <td>{{ $entrevista->puntaje_total }}</td>
                    <td><span class="badge badge-risk-{{ $entrevista->nivel_riesgo }}">{{ $entrevista->nivel_riesgo }}</span></td>
                    <td>{{ $entrevista->observaciones }}</td>
                </tr>
            @empty
                <tr><td colspan="6">No hay entrevistas registradas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div></div>
@endsection
