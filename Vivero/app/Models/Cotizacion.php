<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Producto;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones';

    protected $fillable = [
        'user_id',
        'estado',
        'comentario'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'cotizacion_productos')
            ->withPivot('cantidad')
            ->withTimestamps();
    }
    public function indexAdmin()
    {
        $cotizaciones = Cotizacion::with('user', 'productos')->get();
        return view('dashboard.cotizaciones.index', compact('cotizaciones'));
    }
}
