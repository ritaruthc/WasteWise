<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangePhotoColumnTypeInMaterialCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the photo column exists before trying to drop it
        if (Schema::hasColumn('material_categories', 'photo')) {
            Schema::table('material_categories', function (Blueprint $table) {
                $table->dropColumn('photo');
            });
        }
        
        // Use raw SQL to create the LONGBLOB column
        DB::statement('ALTER TABLE `material_categories` ADD `photo` LONGBLOB NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('material_categories', function (Blueprint $table) {
            // Drop the LONGBLOB column
            $table->dropColumn('photo');
        });
        
        Schema::table('material_categories', function (Blueprint $table) {
            // Add it back as LONGTEXT
            $table->longText('photo')->nullable();
        });
    }
}
