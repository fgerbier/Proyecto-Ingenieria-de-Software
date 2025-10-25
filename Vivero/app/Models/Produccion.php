<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    protected $table = 'producciones'; // <- esto es lo importante

    protected $fillable = ['producto_id', 'cantidad_producida'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function insumos()
    {
        return $this->belongsToMany(Insumo::class, 'insumo_produccion')
                    ->withPivot('cantidad_usada')
                    ->withTimestamps();
    }
   public function mermas()
{
    return $this->hasMany(Merma::class);
}

}
