<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAvatarColumnInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the existing avatar column and recreate it as BLOB
            $table->dropColumn('avatar');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->binary('avatar')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the binary avatar column
            $table->dropColumn('avatar');
        });
        
        Schema::table('users', function (Blueprint $table) {
            // Recreate avatar column as VARCHAR(255)
            $table->string('avatar', 255)->nullable()->after('password');
        });
    }
}
