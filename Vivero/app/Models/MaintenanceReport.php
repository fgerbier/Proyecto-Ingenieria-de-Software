<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceReport extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'cost',
        'image',
        'last_updated_at',
    ];

    protected $dates = [
        'last_updated_at',
    ];
}
