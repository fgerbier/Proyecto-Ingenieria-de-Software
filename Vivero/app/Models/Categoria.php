<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = ['nombre'];
    protected $primaryKey = 'id';
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria');
    }
}
