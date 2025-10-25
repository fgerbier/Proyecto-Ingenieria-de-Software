<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merma extends Model
{
    protected $fillable = ['producto_id', 'cantidad', 'motivo'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
     public function produccion()
{
    return $this->belongsTo(Produccion::class);
}
}

