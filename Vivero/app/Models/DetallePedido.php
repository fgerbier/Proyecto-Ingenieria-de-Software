<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetallePedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id', 'producto_id', 'cantidad', 'precio_unitario',
        'subtotal', 'nombre_producto_snapshot', 'codigo_barras_snapshot',
        'imagen_snapshot'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    
}
