<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agendas = [
            [
                'title' => 'Musyawarah Perencanaan Pembangunan Desa (Musrenbangdes)',
                'description' => 'Pertemuan tahunan seluruh perangkat desa, tokoh masyarakat, dan perwakilan warga untuk membahas dan menetapkan RKPD (Rencana Kerja Pemerintah Desa) tahun depan.',
                'event_date' => '2026-04-25 08:00:00',
                'location' => 'Balai Desa Utama',
            ],
            [
                'title' => 'Pasar Murah & Bazar UMKM Desa',
                'description' => 'Bazar penyediaan sembako murah bersubsidi untuk warga desa sekaligus pameran produk-produk unggulan hasil karya UMKM lokal.',
                'event_date' => '2026-05-02 07:00:00',
                'location' => 'Lapangan Olahraga Desa',
            ],
            [
                'title' => 'Penyuluhan Kesehatan Lansia & Posbindu',
                'description' => 'Pemeriksaan kesehatan gratis (tensi, gula darah, kolesterol) dan penyuluhan gizi bagi warga lanjut usia oleh tim dokter dari Puskesmas kecamatan.',
                'event_date' => '2026-05-10 09:00:00',
                'location' => 'Polindes Mekar Sari',
            ],
        ];

        foreach ($agendas as $agenda) {
            \App\Models\Agenda::create($agenda);
        }
    }
}
