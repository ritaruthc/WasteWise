<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('material_categories', function (Blueprint $table) {
            $table->longText('photo')->nullable();
            $table->longText('tip')->nullable();
        });
    }

    public function down()
    {
        Schema::table('material_categories', function (Blueprint $table) {
            $table->dropColumn('photo');
            $table->dropColumn('tip');
        });
    }
};