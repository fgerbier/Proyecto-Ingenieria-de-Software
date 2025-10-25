<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::create('insumo_detalles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('insumo_id')->constrained('insumos')->onDelete('cascade');
        $table->string('nombre')->nullable();
        $table->integer('cantidad');
        $table->integer('costo_unitario');
        $table->timestamps();
    });
}

};
