<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Convertimos los valores actuales de decimal a entero
        DB::table('productos')->get()->each(function ($producto) {
            $entero = intval(round($producto->precio));
            DB::table('productos')->where('id', $producto->id)->update(['precio' => $entero]);
        });

        // Cambiamos el tipo de dato a entero sin signo
        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedInteger('precio')->change();
        });
    }

    public function down()
    {
        // Revertimos a decimal (por si se hace rollback)
        Schema::table('productos', function (Blueprint $table) {
            $table->decimal('precio', 10, 2)->change();
        });
    }
};
