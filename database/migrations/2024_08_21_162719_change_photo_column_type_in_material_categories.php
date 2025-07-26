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
        // Use raw SQL to alter the column type to LONGBLOB
        DB::statement('ALTER TABLE `material_categories` MODIFY `photo` LONGBLOB');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert the column type back to TEXT or any previous type
        DB::statement('ALTER TABLE `material_categories` MODIFY `photo` LONGTEXT');
    }
}
