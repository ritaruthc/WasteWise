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
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            // Migrasi data dari is_solved ke status
            DB::statement("UPDATE questions SET status = CASE WHEN is_solved = 1 THEN 'selesai' ELSE 'belum_selesai' END");
            
            $table->dropColumn('is_solved');
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->boolean('is_solved')->default(false);
            
            // Mengembalikan data dari status ke is_solved
            DB::statement("UPDATE questions SET is_solved = CASE WHEN status = 'selesai' THEN 1 ELSE 0 END");
        });
    }
};
