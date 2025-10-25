<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $fillable = [
        'nombre',
        'cantidad',
        'costo',
        'descripcion',
    ];

    public function detalles()
{
    return $this->hasMany(InsumoDetalle::class);
}

public function productos()
{
    return $this->belongsToMany(Producto::class, 'producto_insumo')
                ->withPivot('cantidad')
                ->withTimestamps();
}

public function producciones()
{
    return $this->belongsToMany(Produccion::class, 'insumo_produccion')
                ->withPivot('cantidad_usada')
                ->withTimestamps();
}



}
