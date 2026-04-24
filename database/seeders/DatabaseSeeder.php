<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            DocumentCategorySeeder::class,
            ProfileSeeder::class,
            SliderSeeder::class,
            ArticleSeeder::class,
            AgendaSeeder::class,
            GallerySeeder::class,
            FinanceSeeder::class,
            DocumentSeeder::class,
        ]);
    }
}
