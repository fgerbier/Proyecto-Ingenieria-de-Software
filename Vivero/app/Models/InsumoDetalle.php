<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsumoDetalle extends Model
{
    protected $fillable = ['insumo_id', 'nombre', 'cantidad', 'costo_unitario'];

    public function insumo()
    {
        return $this->belongsTo(Insumo::class);
    }
}
