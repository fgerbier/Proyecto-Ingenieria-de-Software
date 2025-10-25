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
        $table->string('background_color')->nullable();
        $table->string('table_header_color')->nullable();
    });
}

public function down()
{
    Schema::table('user_preferences', function (Blueprint $table) {
        $table->dropColumn('background_color');
        $table->dropColumn('table_header_color');
    });
}

};
