<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finanza extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'monto',
        'fecha',
        'categoria',
        'descripcion',
        'created_by',
    ];

    // Relación con el usuario que registró la transacción
    public function usuario()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
