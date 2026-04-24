<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Profile::create([
            'village_name' => 'Sukorejo',
            'head_of_village_name' => 'H. Ahmad Santoso, S.Sos',
            'head_of_village_msg' => 'Selamat datang di website resmi Desa Sukorejo. Kami hadirkan portal ini sebagai sarana informasi dan pelayanan publik yang lebih modern dan transparan bagi seluruh warga. Melalui platform ini, kami berharap transparansi dan akuntabilitas pemerintahan desa semakin meningkat.',
            'head_of_village_img' => 'https://via.placeholder.com/300x400/1b4332/FFFFFF?text=Kepala+Desa',
            'population' => 8542,
            'area_size' => '12.5 km²',
            'hamlet_count' => 8,
            'vision' => 'Terwujudnya Desa Sukorejo yang Maju, Sejahtera, Transparan, dan Berbudaya melalui Pemberdayaan Masyarakat dan Tata Kelola yang Baik.',
            'mission' => "1. Meningkatkan tata kelola pemerintahan desa yang profesional, transparan, dan akuntabel.\n2. Mengembangkan potensi ekonomi desa melalui pemberdayaan UMKM, pertanian, dan pariwisata.\n3. Meningkatkan kualitas infrastruktur dasar dan fasilitas umum.\n4. Melestarikan nilai-nilai adat, budaya, dan semangat gotong royong.",
            'history' => 'Desa kami telah berdiri sejak masa kemerdekaan, berawal dari sebuah perkampungan kecil yang mayoritas penduduknya berprofesi sebagai petani. Nama desa ini diambil dari kata lokal yang berarti "Harapan Makmur".',
            'org_chart_image' => 'https://via.placeholder.com/1000x500/f8f9fa/1b4332?text=Bagan+Organisasi+Desa+Sukorejo',
        ]);
    }
}
