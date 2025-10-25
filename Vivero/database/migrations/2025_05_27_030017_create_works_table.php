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
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('ubicacion', ['produccion', 'venta']);
            $table->string('responsable');
            $table->date('fecha');
            $table->enum('estado', ['pendiente', 'en progreso', 'completada'])->default('pendiente');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
