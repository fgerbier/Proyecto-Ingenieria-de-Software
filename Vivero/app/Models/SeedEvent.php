<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedEvent extends Model
{
    use HasFactory;

    // Forzar nombre de tabla correcto
    protected $table = 'simple_calendar_events';

    protected $casts = [
        'fecha_siembra' => 'date',
        'fecha_trasplante' => 'date',
    ];

    protected $fillable = [
        'planta',
        'cantidad',
        'fecha_siembra',
        'fecha_trasplante',
    ];
}
