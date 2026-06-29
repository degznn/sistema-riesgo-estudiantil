<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estudiante extends Model
{
    use HasFactory;

    // Campos permitidos para insertar datos desde el CSV.
    protected $fillable = [
        'codigo',
        'apellidos',
        'nombres',
        'carrera',
        'semestre',
        'grupo',
        'periodo_id',
    ];

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function entrevistas()
    {
        return $this->hasMany(Entrevista::class);
    }

    public function ultimaEntrevista()
    {
        return $this->hasOne(Entrevista::class)->latestOfMany();
    }
}
