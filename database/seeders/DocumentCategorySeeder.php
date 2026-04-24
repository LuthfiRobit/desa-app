<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Administrasi Penduduk'],
            ['name' => 'Peraturan Desa'],
            ['name' => 'Laporan Keuangan'],
            ['name' => 'Form Layanan'],
        ];

        foreach ($categories as $category) {
            \App\Models\DocumentCategory::create($category);
        }
    }
}
