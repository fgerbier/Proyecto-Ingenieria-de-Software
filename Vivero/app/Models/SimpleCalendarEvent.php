<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimpleCalendarEvent extends Model
{
    protected $fillable = [
        'planta',
        'fecha_siembra',
        'cantidad',
        'fecha_trasplante',
        'plantin_id',
    ];
}
