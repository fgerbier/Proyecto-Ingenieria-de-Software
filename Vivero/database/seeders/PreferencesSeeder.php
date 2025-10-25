<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserPreference;

class PreferencesSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPreferences = [
            'accent_color' => '#199473',              // verde moderno
            'background_color' => '#F4F6F8',           // gris claro
            'table_header_color' => '#154734',         // verde oscuro elegante
            'table_header_text_color' => '#FFFFFF',    // texto blanco
            'font' => 'roboto',
            'font_size' => 'text-base',
            'theme_mode' => 'light',
            'logo_image' => null,
            'profile_image' => null,
        ];

        // Aplica las preferencias a todos los usuarios existentes
        User::all()->each(function ($user) use ($defaultPreferences) {
            $user->preference()->updateOrCreate([], $defaultPreferences);
        });
    }
}
