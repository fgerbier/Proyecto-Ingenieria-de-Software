<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_seed_events_table.php
public function up()
{
    Schema::create('seed_events', function (Blueprint $table) {
        $table->id();
        $table->string('planta');
        $table->date('fecha_siembra');
        $table->date('fecha_trasplante')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seed_events');
    }
};
