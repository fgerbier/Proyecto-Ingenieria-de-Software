<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fertilizantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo');
            $table->text('composicion')->nullable();
            $table->text('descripcion')->nullable();
            $table->decimal('peso', 8, 2);
            $table->string('unidad_medida');
            $table->string('presentacion');
            $table->text('aplicacion')->nullable();
            $table->integer('precio');
            $table->integer('stock');
            $table->date('fecha_vencimiento')->nullable();
            $table->string('imagen')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('fertilizantes');
    }
};
