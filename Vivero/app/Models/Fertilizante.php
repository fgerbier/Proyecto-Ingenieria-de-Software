<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fertilizante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'composicion',
        'descripcion',
        'peso',
        'unidad_medida',
        'presentacion',
        'aplicacion',
        'precio',
        'stock',
        'fecha_vencimiento',
        'imagen',
        'activo',
    ];

    public function fertilizaciones()
{
    return $this->hasMany(Fertilization::class);
}

}
