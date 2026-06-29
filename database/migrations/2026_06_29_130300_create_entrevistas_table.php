<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entrevistas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->cascadeOnDelete();
            $table->foreignId('tutor_id')->nullable()->constrained('tutores')->nullOnDelete();
            $table->foreignId('periodo_id')->nullable()->constrained('periodos')->nullOnDelete();
            $table->unsignedTinyInteger('rendimiento_academico');
            $table->unsignedTinyInteger('bienestar_emocional');
            $table->unsignedTinyInteger('trabajo_equipo');
            $table->unsignedTinyInteger('comunicacion_efectiva');
            $table->unsignedTinyInteger('trabajo_economia');
            $table->unsignedTinyInteger('estres');
            $table->unsignedTinyInteger('puntaje_total');
            $table->string('nivel_riesgo');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entrevistas');
    }
};
