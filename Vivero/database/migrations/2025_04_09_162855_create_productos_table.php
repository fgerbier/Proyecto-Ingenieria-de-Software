<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();


            $table->string('slug')->unique();
            $table->string('nombre')->unique();
            $table->string('nombre_cientifico')->nullable();
            $table->text('descripcion')->nullable();
            $table->integer('precio');
            $table->integer('cantidad')->default(0);
            $table->integer('categoria')->nullable();
            $table->string('imagen')->nullable();
            $table->string('codigo_barras')->unique();
            $table->integer('stock')->default(0);
            // Información adicional
            $table->text('cuidados')->nullable();
            $table->string('nivel_dificultad')->nullable(); // fácil, intermedio, experto
            $table->string('frecuencia_riego')->nullable(); // ej. 1 vez por semana
            $table->string('ubicacion_ideal')->nullable();  // interior, exterior, sol, sombra
            $table->text('beneficios')->nullable();
            $table->boolean('toxica')->default(false); // para mascotas
            $table->string('origen')->nullable();
            $table->integer('tamano')->nullable(); // altura o tamaño de la maceta
            $table->boolean('activo')->default(true); // para publicación o no

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
