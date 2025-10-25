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
        Schema::create('descuentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('codigo', 20)->unique()->nullable()->comment('Código promocional opcional');
            $table->text('descripcion')->nullable();
            $table->decimal('porcentaje', 5, 2)->nullable()->default(0)->comment('Descuento en porcentaje, 0 si no aplica');
            $table->decimal('monto_fijo', 10, 2)->nullable()->comment('Descuento fijo en lugar de porcentaje');
            $table->enum('tipo', ['porcentaje', 'monto_fijo', 'envio_gratis'])->default('porcentaje');
            $table->timestamp('valido_desde')->useCurrent();
            $table->timestamp('valido_hasta')->nullable();
            $table->boolean('activo')->default(true);
            $table->unsignedInteger('usos_maximos')->nullable()->comment('Límite de usos del descuento');
            $table->unsignedInteger('usos_actuales')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('activo');
            $table->index('valido_hasta');
        });

        Schema::create('descuento_producto', function (Blueprint $table) {
            $table->foreignId('descuento_id')->constrained('descuentos')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->primary(['descuento_id', 'producto_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descuento_producto');
        Schema::dropIfExists('descuentos');
    }
};
