<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = \App\Models\User::first()->id;
        $categories = \App\Models\Category::all();

        $articles = [
            [
                'title' => 'Kegiatan Gotong Royong Bersih Desa',
                'slug' => 'kegiatan-gotong-royong-bersih-desa',
                'category_id' => $categories->where('slug', 'kegiatan')->first()->id,
                'content' => 'Warga desa kompak melaksanakan gotong royong membersihkan lingkungan dalam rangka menyambut Hari Kemerdekaan RI. Kegiatan ini diikuti oleh seluruh elemen masyarakat mulai dari tingkat RT hingga RW.',
                'image_path' => 'https://via.placeholder.com/800x600/52b788/FFFFFF?text=Gotong+Royong',
                'is_published' => true,
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Pelatihan UMKM Digital Marketing',
                'slug' => 'pelatihan-umkm-digital-marketing',
                'category_id' => $categories->where('slug', 'pemberdayaan')->first()->id,
                'content' => 'Desa menyelenggarakan pelatihan digital marketing untuk pelaku UMKM agar produk lokal semakin dikenal luas. Pelatihan ini menghadirkan narasumber ahli di bidang pemasaran digital.',
                'image_path' => 'https://via.placeholder.com/800x600/2d8659/FFFFFF?text=Pelatihan+UMKM',
                'is_published' => true,
                'published_at' => now()->subDays(6),
            ],
            [
                'title' => 'Pelaksanaan Posyandu Balita Rutin',
                'slug' => 'pelaksanaan-posyandu-balita-rutin',
                'category_id' => $categories->where('slug', 'kesehatan')->first()->id,
                'content' => 'Posyandu balita dilaksanakan rutin setiap tanggal 15 untuk memantau kesehatan dan tumbuh kembang anak. Selain penimbangan berat badan, dilakukan juga pemberian imunisasi dan vitamin.',
                'image_path' => 'https://via.placeholder.com/800x600/74c69d/FFFFFF?text=Posyandu+Balita',
                'is_published' => true,
                'published_at' => now()->subDays(9),
            ],
        ];

        foreach ($articles as $article) {
            $article['user_id'] = $adminId;
            \App\Models\Article::create($article);
        }
    }
}
