<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateAvatarColumnInUsersTable extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE `users` MODIFY `avatar` LONGBLOB');
    }

    public function down()
    {
        // If you want to revert to the previous type, modify accordingly.
        DB::statement('ALTER TABLE `users` MODIFY `avatar` BLOB');
    }
}

