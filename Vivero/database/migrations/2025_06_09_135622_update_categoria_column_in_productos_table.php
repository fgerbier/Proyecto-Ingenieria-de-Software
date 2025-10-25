<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id')->nullable()->after('id');
        });

        // Copiar valores desde `categoria` a `categoria_id`
        DB::statement('UPDATE productos SET categoria_id = categoria');

        // Agregar la clave foránea
        Schema::table('productos', function (Blueprint $table) {
            $table->foreign('categoria_id')->references('id')->on('categorias')->nullOnDelete();
        });

        // Eliminar la columna antigua
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('categoria');
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->integer('categoria')->nullable();
        });

        DB::statement('UPDATE productos SET categoria = categoria_id');

        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->dropColumn('categoria_id');
        });
    }
};
