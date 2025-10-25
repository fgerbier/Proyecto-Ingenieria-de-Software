<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('user_preferences', function (Blueprint $table) {
        $table->string('logo_image')->nullable();
        $table->string('profile_image')->nullable();
        $table->dropColumn('background_image'); // eliminar el campo anterior si ya no se usará
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_preferences', function (Blueprint $table) {
            //
        });
    }
};
