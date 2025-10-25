<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->text('direccion')->nullable();
            $table->string('empresa')->nullable();
            $table->string('tipo_proveedor')->nullable();
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('proveedores');
    }
};