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
        Schema::create('simple_calendar_events', function (Blueprint $table) {
            $table->id();
            $table->string('planta');
            $table->date('fecha_siembra');
            $table->integer('cantidad')->default(1);
            $table->date('fecha_trasplante')->nullable(); // opcional
            $table->unsignedBigInteger('plantin_id')->nullable(); // ← agregado aquí
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simple_calendar_events');
    }
};
