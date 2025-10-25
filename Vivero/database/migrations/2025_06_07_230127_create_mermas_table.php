<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
{
    Schema::create('mermas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
        $table->integer('cantidad');
        $table->text('motivo')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mermas');
    }
};
