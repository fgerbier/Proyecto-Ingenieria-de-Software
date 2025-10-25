<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fertilization extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'fertilizante_id',
        'fecha_aplicacion',
        'dosis_aplicada',
        'notas',
    ];

    public function fertilizante()
    {
        return $this->belongsTo(Fertilizante::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
