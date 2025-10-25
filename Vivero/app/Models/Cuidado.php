<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuidado extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'frecuencia_riego',
        'cantidad_agua',
        'tipo_luz',
        'temperatura_ideal',
        'tipo_sustrato',
        'frecuencia_abono',
        'plagas_comunes',
        'cuidados_adicionales',
        'imagen_url',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
