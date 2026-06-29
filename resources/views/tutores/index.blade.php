@extends('layouts.app')

@section('title', 'Tutores')

@section('content')
<h1 class="h3 mb-3">Tutores</h1>

<div class="card mb-3">
    <div class="card-body">
        <h2 class="h5">Registrar tutor</h2>
        <form action="{{ route('tutores.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-4"><label class="form-label">Nombre</label><input name="name" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Correo Tecsup</label><input type="email" name="email" class="form-control" placeholder="tutor@tecsup.edu.pe" required></div>
            <div class="col-md-2"><label class="form-label">Codigo</label><input name="codigo" class="form-control" required></div>
            <div class="col-md-2"><label class="form-label">Contrasena</label><input type="password" name="password" class="form-control" required></div>
            <div class="col-md-4"><label class="form-label">Telefono</label><input name="telefono" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">Especialidad</label><input name="especialidad" class="form-control"></div>
            <div class="col-md-2 d-flex align-items-end"><button class="btn btn-primary w-100">Guardar</button></div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Nombre</th><th>Email</th><th>Codigo</th><th>Telefono</th><th>Especialidad</th><th>Activo</th><th>Acciones</th></tr></thead>
            <tbody>
                @forelse ($tutores as $tutor)
                    <tr>
                        <td colspan="7">
                            <form action="{{ route('tutores.update', $tutor) }}" method="POST" class="row g-2 align-items-center">
                                @csrf
                                @method('PUT')
                                <div class="col-md-2"><input name="name" class="form-control" value="{{ $tutor->user->name }}"></div>
                                <div class="col-md-3"><input name="email" class="form-control" value="{{ $tutor->user->email }}"></div>
                                <div class="col-md-1"><input name="codigo" class="form-control" value="{{ $tutor->codigo }}"></div>
                                <div class="col-md-2"><input name="telefono" class="form-control" value="{{ $tutor->telefono }}"></div>
                                <div class="col-md-2"><input name="especialidad" class="form-control" value="{{ $tutor->especialidad }}"></div>
                                <div class="col-md-1"><input type="checkbox" name="activo" value="1" @checked($tutor->activo)> Activo</div>
                                <div class="col-md-1"><button class="btn btn-sm btn-outline-primary">Guardar</button></div>
                            </form>
                            <form action="{{ route('tutores.destroy', $tutor) }}" method="POST" class="mt-2" onsubmit="return confirm('Eliminar tutor?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7">No hay tutores registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
