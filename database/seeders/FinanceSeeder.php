<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $finances = [
            // Pendapatan
            ['year' => 2026, 'type' => 'income', 'title' => 'Pendapatan Asli Desa (PADes)', 'budget_amount' => 150000000, 'realized_amount' => 120000000],
            ['year' => 2026, 'type' => 'income', 'title' => 'Dana Desa (DD)', 'budget_amount' => 900000000, 'realized_amount' => 900000000],
            ['year' => 2026, 'type' => 'income', 'title' => 'Alokasi Dana Desa (ADD)', 'budget_amount' => 400000000, 'realized_amount' => 400000000],
            ['year' => 2026, 'type' => 'income', 'title' => 'Bantuan Keuangan Provinsi', 'budget_amount' => 50000000, 'realized_amount' => 30000000],

            // Belanja
            ['year' => 2026, 'type' => 'expense', 'title' => 'Bidang Penyelenggaraan Pemerintahan', 'budget_amount' => 400000000, 'realized_amount' => 380000000],
            ['year' => 2026, 'type' => 'expense', 'title' => 'Bidang Pembangunan Desa', 'budget_amount' => 700000000, 'realized_amount' => 450000000],
            ['year' => 2026, 'type' => 'expense', 'title' => 'Bidang Pembinaan Kemasyarakatan', 'budget_amount' => 150000000, 'realized_amount' => 120000000],
            ['year' => 2026, 'type' => 'expense', 'title' => 'Bidang Pemberdayaan Masyarakat', 'budget_amount' => 200000000, 'realized_amount' => 175000000],

            // Pembiayaan
            ['year' => 2026, 'type' => 'financing', 'title' => 'Sisa Lebih Perhitungan Anggaran (SiLPA)', 'budget_amount' => 325000000, 'realized_amount' => 325000000],
        ];

        foreach ($finances as $finance) {
            \App\Models\Finance::create($finance);
        }
    }
}
