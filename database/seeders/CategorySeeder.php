<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Kegiatan', 'slug' => 'kegiatan'],
            ['name' => 'Pemberdayaan', 'slug' => 'pemberdayaan'],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan'],
            ['name' => 'Pembangunan', 'slug' => 'pembangunan'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
