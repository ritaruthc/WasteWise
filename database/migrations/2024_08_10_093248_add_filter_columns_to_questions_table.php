<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilterColumnsToQuestionsTable extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->boolean('trending')->default(false);
            $table->integer('popularity')->default(0);
            $table->enum('status', ['selesai', 'belum_selesai', 'belum_terjawab'])->default('belum_terjawab');
            $table->integer('view_count')->default(0);
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('trending');
            $table->dropColumn('popularity');
            $table->dropColumn('status');
            $table->dropColumn('view_count');
        });
    }
}