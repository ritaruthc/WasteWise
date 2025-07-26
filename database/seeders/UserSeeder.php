<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Example User',
            'email' => '1@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('1'),
            'avatar' => null, // You can replace this with a binary data if you have an avatar to upload
            'bio' => 'This is an example bio.',
            'google_id' => null,
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'points' => 0,
            'is_admin' => 0,
            'material_id' => null, // You can set a valid material ID if needed
        ]);
    }
}
