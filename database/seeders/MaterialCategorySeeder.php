<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaterialCategory;

class MaterialCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Pengenalan Sampah',
                'slug' => 'pengenalan-sampah',
                'description' => 'Kategori ini mencakup artikel yang memperkenalkan berbagai jenis sampah dan karakteristiknya.',
                'photo' => 'public/images/kategori/pengenalan-sampah.png',
            ],
            [
                'name' => 'Pengelolaan Sampah',
                'slug' => 'pengelolaan-sampah',
                'description' => 'Panduan praktis dan tips untuk mengelola sampah secara efektif di lingkungan Anda.',
                'photo' => 'public/images/kategori/pengelolaan-sampah.png',
            ],
            [
                'name' => 'Daur Ulang',
                'slug' => 'daur-ulang',
                'description' => 'Artikel yang membahas cara-cara dan manfaat dari mendaur ulang sampah.',
                'photo' => 'public/images/kategori/daur-ulang.png',
            ],
            [
                'name' => 'Lingkungan',
                'slug' => 'lingkungan',
                'description' => 'Kategori ini mencakup artikel tentang dampak sampah terhadap lingkungan dan cara menjaga kelestariannya.',
                'photo' => 'public/images/kategori/lingkungan.png',
            ],
        ];

        foreach ($categories as $category) {
            MaterialCategory::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => $category['description'] ?? null, // Menggunakan default null jika tidak ada
                'photo' => $category['photo'] ?? null, // Menggunakan default null jika tidak ada
            ]);
        }
    }
}
