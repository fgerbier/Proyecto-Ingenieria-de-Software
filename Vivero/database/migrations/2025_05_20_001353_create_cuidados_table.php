<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cuidados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->string('frecuencia_riego');
            $table->string('cantidad_agua');
            $table->string('tipo_luz');
            $table->string('temperatura_ideal')->nullable();
            $table->string('tipo_sustrato')->nullable();
            $table->string('frecuencia_abono')->nullable();
            $table->string('plagas_comunes')->nullable();
            $table->text('cuidados_adicionales')->nullable();
            $table->string('imagen_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuidados');
    }
};
