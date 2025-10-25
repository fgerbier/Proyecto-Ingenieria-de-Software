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
        $table->string('navbar_color')->nullable()->after('table_header_text_color');
    });
}

public function down()
{
    Schema::table('user_preferences', function (Blueprint $table) {
        $table->dropColumn('navbar_color');
    });
}

};
