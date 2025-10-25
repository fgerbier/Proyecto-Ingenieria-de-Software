<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenProduccion extends Model
{
    use HasFactory;

    protected $table = 'orden_produccions';

    protected $fillable = [
        'codigo',
        'producto_id',
        'cantidad',
        'fecha_inicio',
        'fecha_fin_estimada',
        'estado',
        'observaciones',
        'user_id',
    ];

    const ESTADOS = ['pendiente', 'en proceso', 'completada'];

    // Relación con producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function trabajador()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
