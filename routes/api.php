<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiAuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiAuthController::class, 'token']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/estudiantes', [ApiController::class, 'estudiantes']);
    Route::get('/tutores', [ApiController::class, 'tutores']);
    Route::get('/entrevistas', [ApiController::class, 'entrevistas']);
    Route::post('/entrevistas', [ApiController::class, 'guardarEntrevista']);
    Route::get('/dashboard', [ApiController::class, 'dashboard']);
});
