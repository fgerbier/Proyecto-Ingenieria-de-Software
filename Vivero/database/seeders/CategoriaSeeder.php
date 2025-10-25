<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            'Suculenta',
            'Interior',
            'Exterior',
            'Medicinal',
            'Árbol',
            'Decorativa'
        ];

        foreach ($categorias as $nombre) {
            Categoria::firstOrCreate([
                'nombre' => $nombre,
            ]);
        }

        $this->command->info('Categorías creadas exitosamente.');
    }
}
