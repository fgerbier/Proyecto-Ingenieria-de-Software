<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orden_produccions', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->date('fecha_inicio');
            $table->date('fecha_fin_estimada')->nullable();
            $table->string('estado')->default('pendiente'); // 'pendiente', 'en_proceso', 'completada'
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orden_produccions');
    }
};
