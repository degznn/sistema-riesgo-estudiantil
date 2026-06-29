<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entrevista extends Model
{
    use HasFactory;

    protected $fillable = [
        'estudiante_id',
        'tutor_id',
        'periodo_id',
        'rendimiento_academico',
        'bienestar_emocional',
        'trabajo_equipo',
        'comunicacion_efectiva',
        'trabajo_economia',
        'estres',
        'puntaje_total',
        'nivel_riesgo',
        'observaciones',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    public static function nivelPorPuntaje(int $puntaje): string
    {
        if ($puntaje >= 14) {
            return 'Rojo';
        }

        if ($puntaje >= 8) {
            return 'Ambar';
        }

        return 'Verde';
    }
}
