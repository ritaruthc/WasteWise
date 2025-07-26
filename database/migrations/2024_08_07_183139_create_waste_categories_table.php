<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWasteCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waste_categories', function (Blueprint $table) {
            $table->id();
            $table->string('class_name');
            $table->string('category');
            $table->text('info');
            $table->text('handling_info');
            $table->text('environmental_impact');
            $table->text('recycling_potential');
            $table->text('decomposition_time');
            $table->text('reduction_tips');
            $table->text('other_examples');
            $table->text('regulations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waste_categories');
    }
}
