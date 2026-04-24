<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Selamat Datang di Portal Digital Desa Sukorejo',
                'description' => 'Pusat informasi dan layanan digital resmi Desa Sukorejo, Kecamatan Kotaanyar, Kabupaten Probolinggo.',
                'image_path' => 'https://via.placeholder.com/1920x800/1b4332/FFFFFF?text=Slide+1',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Transparansi APBDes 2026',
                'description' => 'Wujudkan tata kelola desa yang transparan dan akuntabel melalui publikasi anggaran secara terbuka.',
                'image_path' => 'https://via.placeholder.com/1920x800/2d8659/FFFFFF?text=Slide+2',
                'is_active' => true,
                'order' => 2,
            ],
        ];

        foreach ($sliders as $slider) {
            \App\Models\Slider::create($slider);
        }
    }
}
