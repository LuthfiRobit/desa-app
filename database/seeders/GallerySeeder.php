<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleries = [
            ['title' => 'Rapat Pleno RKPDES', 'image_path' => 'https://via.placeholder.com/800x600/1b4332/FFFFFF?text=Rapat+Pleno', 'date_taken' => '2026-04-10'],
            ['title' => 'Gotong Royong Lingkungan', 'image_path' => 'https://via.placeholder.com/800x600/2d8659/FFFFFF?text=Gotong+Royong', 'date_taken' => '2026-04-15'],
            ['title' => 'Pelatihan Bordir Ibu PKK', 'image_path' => 'https://via.placeholder.com/800x600/52b788/FFFFFF?text=Pelatihan+PKK', 'date_taken' => '2026-04-18'],
            ['title' => 'Penyaluran BLT Dana Desa', 'image_path' => 'https://via.placeholder.com/800x600/74c69d/FFFFFF?text=Penyaluran+BLT', 'date_taken' => '2026-04-20'],
        ];

        foreach ($galleries as $gallery) {
            \App\Models\Gallery::create($gallery);
        }
    }
}
