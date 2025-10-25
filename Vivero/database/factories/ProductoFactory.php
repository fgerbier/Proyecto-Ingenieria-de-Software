<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    public function definition(): array
    {
        $dificultades = ['Fácil', 'Intermedio', 'Experto'];
        $ubicaciones = ['Interior', 'Exterior', 'Sol directo', 'Sombra'];
        $frecuencias = ['1 vez por semana', '2 veces por semana', 'Cada 15 días'];

        return [
            'nombre' => $this->generateProductName(),
            'slug' => $this->faker->unique()->slug(),
            'nombre_cientifico' => $this->faker->optional(70)->words(3, true),
            'descripcion' => $this->faker->paragraph(3),
            'precio' => $this->faker->numberBetween(1000, 99990),
            'cantidad' => $this->faker->numberBetween(0, 100),
            'imagen' => 'storage/images/default-logo.png',
            'codigo_barras' => $this->faker->unique()->ean13(),
            'cuidados' => $this->generateCareInstructions(),
            'nivel_dificultad' => $this->faker->randomElement($dificultades),
            'frecuencia_riego' => $this->faker->randomElement($frecuencias),
            'ubicacion_ideal' => $this->faker->randomElement($ubicaciones),
            'beneficios' => $this->generateBenefits(),
            'toxica' => $this->faker->boolean(20),
            'origen' => $this->faker->country(),
            'tamano' => $this->faker->numberBetween(5, 200),
            'activo' => $this->faker->boolean(90),
            'categoria_id' => Categoria::inRandomOrder()->first()?->id
        ];
    }

    private function generateProductName(): string
    {
        $types = [
            'Planta', 'Árbol', 'Arbusto', 'Cactus', 'Suculenta', 'Flor',
            'Helecho', 'Bonsái', 'Palma', 'Orquídea', 'Hierba', 'Enredadera',
            'Musgo', 'Bulbo', 'Bambú', 'Ciprés', 'Pino', 'Cedro', 'Rosal',
            'Lavanda', 'Aloe', 'Hiedra', 'Begonia', 'Geranio', 'Clavel',
            'Tulipán', 'Margarita', 'Lirio', 'Girasol', 'Jazmín', 'Azalea'
        ];
        $colors = [
            'Verde', 'Roja', 'Amarilla', 'Multicolor', 'Blanca', 'Azul',
            'Morada', 'Naranja', 'Rosada', 'Negra', 'Plateada', 'Dorada',
            'Carmesí', 'Turquesa', 'Esmeralda', 'Celeste', 'Coral', 'Beige',
            'Gris', 'Marrón', 'Champán', 'Lavanda', 'Fucsia', 'Violeta'
        ];
        $features = [
            'Colgante', 'Decorativa', 'Perenne', 'Exótica', 'Rara', 'Fragante',
            'Medicinal', 'Comestible', 'Resistente', 'Compacta', 'De interior',
            'De exterior', 'Trepadora', 'Aromática', 'De sombra', 'De sol',
            'De bajo mantenimiento', 'De rápido crecimiento', 'De hojas grandes',
            'De hojas pequeñas', 'De flores grandes', 'De flores pequeñas',
            'De raíces profundas', 'De raíces aéreas', 'De tallo grueso',
            'De tallo delgado', 'De follaje denso', 'De follaje ligero',
            'De crecimiento lento', 'De crecimiento rápido'
        ];

        return $this->faker->unique()->randomElement($types) . ' ' .
               $this->faker->randomElement($colors) . ' ' .
               $this->faker->randomElement($features);
    }

    private function generateCareInstructions(): string
    {
        $instructions = [
            'Requiere luz indirecta. Regar cuando el sustrato esté seco al tacto.',
            'Necesita abundante luz solar directa. Regar moderadamente.',
            'Mantener en sombra parcial. Humedad constante pero sin encharcar.',
            'Tolerante a la sequía. Regar escasamente cada 2-3 semanas.',
            'Prefiere ambientes húmedos. Pulverizar hojas regularmente.'
        ];

        return $this->faker->randomElement($instructions);
    }

    private function generateBenefits(): string
    {
        $benefits = [
            'Purifica el aire y mejora la calidad del ambiente.',
            'Ideal para decoración de interiores con estilo moderno.',
            'Ayuda a reducir el estrés y mejorar la concentración.',
            'Produce flores aromáticas que ambientan cualquier espacio.',
            'Perfecta para principiantes por su fácil cuidado.'
        ];

        return $this->faker->randomElement($benefits);
    }
}
