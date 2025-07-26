<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    public function run()
    {
        $materials = [
            [
                'title' => 'Pengenalan Jenis Sampah',
                'slug' => 'pengenalan-jenis-sampah',
                'description' => 'Mengenal berbagai jenis sampah dan karakteristiknya.',
                'content' => 'Isi konten lengkap tentang jenis-jenis sampah...',
                'category_id' => 1,
            ],
            [
                'title' => 'Cara Memilah Sampah',
                'slug' => 'cara-memilah-sampah',
                'description' => 'Panduan praktis untuk memilah sampah di rumah.',
                'content' => 'Isi konten lengkap tentang cara memilah sampah...',
                'category_id' => 2,
            ],
            // Tambahkan beberapa materi lagi
        ];

        foreach ($materials as $material) {
            Material::create($material);
        }
    }
}