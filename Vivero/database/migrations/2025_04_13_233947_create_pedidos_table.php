<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
    
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
    
            $table->dateTime('fecha_pedido')->default(DB::raw('CURRENT_TIMESTAMP'));
    
            $table->enum('metodo_entrega', ['retiro', 'domicilio'])->default('retiro');
            $table->text('direccion_entrega')->nullable();

            //Estados pedidos!!
            $table->enum('estado_pedido', [
                'pendiente',
                'en_preparacion',
                'en_camino',
                'enviado',
                'entregado',
                'listo_para_retiro'
            ])->default('pendiente');
                
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('impuesto', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
    
            $table->enum('forma_pago', ['efectivo', 'tarjeta', 'transferencia'])->nullable();
            $table->enum('estado_pago', ['pendiente', 'pagado', 'reembolsado', 'parcial'])->default('pendiente');
            $table->decimal('monto_pagado', 10, 2)->nullable();
    
            $table->enum('tipo_documento', ['boleta', 'factura'])->default('boleta');
            $table->boolean('documento_generado')->default(false);

    
            $table->text('observaciones')->nullable();
            $table->string('boleta_final_path')->nullable();
    
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
