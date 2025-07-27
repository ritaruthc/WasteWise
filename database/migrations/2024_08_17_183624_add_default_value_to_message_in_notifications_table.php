<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToMessageInNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // First drop the existing TEXT column
            $table->dropColumn('message');
        });
        
        Schema::table('notifications', function (Blueprint $table) {
            // Add it back as VARCHAR with default value
            $table->string('message', 500)->default('Ada notifikasi.')->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Drop the VARCHAR column
            $table->dropColumn('message');
        });
        
        Schema::table('notifications', function (Blueprint $table) {
            // Add it back as TEXT without default value
            $table->text('message')->after('title');
        });
    }
}
