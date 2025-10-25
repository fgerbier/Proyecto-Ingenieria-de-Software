<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangePrecioUnitarioToIntegerInCartItemsTable extends Migration
{
    public function up()
    {
        // Primero convertimos los valores actuales a enteros multiplicando si es necesario
        DB::table('cart_items')->get()->each(function ($item) {
            $entero = intval(round($item->precio_unitario));
            DB::table('cart_items')->where('id', $item->id)->update(['precio_unitario' => $entero]);
        });

        // Luego cambiamos el tipo de columna
        Schema::table('cart_items', function (Blueprint $table) {
            $table->unsignedInteger('precio_unitario')->change();
        });
    }

    public function down()
    {
        // En caso de rollback, vuelve a decimal
        Schema::table('cart_items', function (Blueprint $table) {
            $table->decimal('precio_unitario', 10, 2)->change();
        });
    }
}

