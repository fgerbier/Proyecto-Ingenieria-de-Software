<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'slug',
        'nombre',
        'nombre_cientifico',
        'descripcion',
        'precio',
        'stock',
        'imagen',
        'cuidados',
        'nivel_dificultad',
        'frecuencia_riego',
        'ubicacion_ideal',
        'beneficios',
        'toxica',
        'origen',
        'tamano',
        'activo',
        'categoria_id',
        'codigo_barras'
    ];

    protected $casts = [
        'precio' => 'float',
        'activo' => 'boolean',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function descuentos()
    {
        return $this->belongsToMany(Descuento::class, 'descuento_producto')->withTimestamps();
    }

    
    public static function toma4ultimos()
    {
        return self::withoutGlobalScopes()
            ->latest()
            ->take(4)
            ->get();
    }
    public function fertilizaciones()
{
    return $this->hasMany(Fertilization::class);
}

public function insumos()
{
    return $this->belongsToMany(Insumo::class, 'producto_insumo')
                ->withPivot('cantidad')
                ->withTimestamps();
}
public function calcularPrecioCosto()
{
    return $this->insumos->sum(function ($insumo) {
        return $insumo->costo_unitario * $insumo->pivot->cantidad;
    });
}
public function tieneStockParaProducir($cantidadDeseada)
{
    foreach ($this->insumos as $insumo) {
        $cantidadNecesaria = $insumo->pivot->cantidad * $cantidadDeseada;
        if ($insumo->cantidad < $cantidadNecesaria) {
            return false;
        }
    }
    return true;
}

public function descontarInsumosParaProduccion($cantidad)
{
    foreach ($this->insumos as $insumo) {
        $cantidadDescontar = $insumo->pivot->cantidad * $cantidad;
        $insumo->cantidad -= $cantidadDescontar;
        $insumo->save();
    }
}

}
