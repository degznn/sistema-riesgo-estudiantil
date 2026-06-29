@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-5 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="h4 mb-1">Sistema de Monitoreo</h1>
                <p class="text-muted mb-4">Ingrese con su correo institucional Tecsup.</p>

                <form action="/login" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Correo institucional</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="usuario@tecsup.edu.pe" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contrasena</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-primary w-100">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
