<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'prioridad',
        'fecha_limite',
        'completada',
    ];

    protected $casts = [
        'fecha_limite' => 'date',
        'completada' => 'boolean',
    ];
}