<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WasteCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            MaterialCategorySeeder::class,
            MaterialSeeder::class,
            AdminUserSeeder::class,
            WasteCategoriesSeeder::class,
            UserSeeder::class,
        ]);
    }
}