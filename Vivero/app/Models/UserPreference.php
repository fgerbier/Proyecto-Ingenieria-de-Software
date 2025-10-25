<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'accent_color',
        'font',
        'font_size',
        'logo_image',
        'profile_image',
        'background_color',     
        'table_header_color',
        'navbar_color',
        'navbar_text_color',    
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
