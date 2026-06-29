@extends('layouts.app')

@section('title', 'Periodos')

@section('content')
<h1 class="h3 mb-3">Periodos academicos</h1>

<div class="card mb-3">
    <div class="card-body">
        <h2 class="h5">Nuevo periodo</h2>
        <form action="{{ route('periodos.store') }}" method="POST" class="row g-3 align-items-end">
            @csrf
            <div class="col-md-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" placeholder="2026-I" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Fecha inicio</label>
                <input type="date" name="fecha_inicio" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Fecha fin</label>
                <input type="date" name="fecha_fin" class="form-control">
            </div>
            <div class="col-md-2 form-check">
                <input type="checkbox" name="activo" class="form-check-input" id="activo">
                <label class="form-check-label" for="activo">Activo</label>
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary w-100">Guardar</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($periodos as $periodo)
                        <tr>
                            <td colspan="5">
                                <form action="{{ route('periodos.update', $periodo) }}" method="POST" class="row g-2 align-items-center">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-md-3"><input name="nombre" class="form-control" value="{{ $periodo->nombre }}"></div>
                                    <div class="col-md-2"><input type="date" name="fecha_inicio" class="form-control" value="{{ $periodo->fecha_inicio }}"></div>
                                    <div class="col-md-2"><input type="date" name="fecha_fin" class="form-control" value="{{ $periodo->fecha_fin }}"></div>
                                    <div class="col-md-2"><input type="checkbox" name="activo" value="1" @checked($periodo->activo)> Activo</div>
                                    <div class="col-md-3 d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-primary">Actualizar</button>
                                        <form action="{{ route('periodos.destroy', $periodo) }}" method="POST"></form>
                                    </div>
                                </form>
                                <form action="{{ route('periodos.destroy', $periodo) }}" method="POST" class="mt-2" onsubmit="return confirm('Eliminar periodo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No hay periodos registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
