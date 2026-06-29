<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntrevistaController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\TutorController;

Route::get('/', [AuthController::class, 'home'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/estudiantes', [EstudianteController::class, 'index'])
        ->name('estudiantes.index');

    Route::post('/estudiantes/importar', [EstudianteController::class, 'importar'])
        ->middleware('role:administrador,bienestar')
        ->name('estudiantes.importar');

    Route::middleware('role:administrador,bienestar')->group(function () {
        Route::get('/periodos', [PeriodoController::class, 'index'])->name('periodos.index');
        Route::post('/periodos', [PeriodoController::class, 'store'])->name('periodos.store');
        Route::put('/periodos/{periodo}', [PeriodoController::class, 'update'])->name('periodos.update');
        Route::delete('/periodos/{periodo}', [PeriodoController::class, 'destroy'])->name('periodos.destroy');

        Route::get('/tutores', [TutorController::class, 'index'])->name('tutores.index');
        Route::post('/tutores', [TutorController::class, 'store'])->name('tutores.store');
        Route::put('/tutores/{tutor}', [TutorController::class, 'update'])->name('tutores.update');
        Route::delete('/tutores/{tutor}', [TutorController::class, 'destroy'])->name('tutores.destroy');

        Route::get('/asignaciones', [AsignacionController::class, 'index'])->name('asignaciones.index');
        Route::post('/asignaciones', [AsignacionController::class, 'store'])->name('asignaciones.store');
    });

    Route::get('/entrevistas', [EntrevistaController::class, 'index'])->name('entrevistas.index');
    Route::get('/estudiantes/{estudiante}/entrevistas/crear', [EntrevistaController::class, 'create'])->name('entrevistas.create');
    Route::post('/estudiantes/{estudiante}/entrevistas', [EntrevistaController::class, 'store'])->name('entrevistas.store');
});
