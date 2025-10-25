<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFertilizationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('fertilizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained()->onDelete('cascade');
            $table->foreignId('fertilizante_id')->constrained()->onDelete('cascade');
            $table->date('fecha_aplicacion');
            $table->string('dosis_aplicada')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fertilizations');
    }
}
