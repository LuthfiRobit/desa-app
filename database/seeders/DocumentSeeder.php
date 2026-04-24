<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = \App\Models\DocumentCategory::all();

        $documents = [
            [
                'document_category_id' => $categories->where('name', 'Administrasi Penduduk')->first()->id,
                'title' => 'Formulir Permohonan Pembuatan KTP Baru',
                'description' => 'Formulir resmi untuk pengajuan KTP baru bagi warga yang baru masuk usia 17 tahun atau pindah datang.',
                'file_path' => 'documents/ktp-baru.pdf',
                'file_extension' => 'pdf',
                'file_size' => 245,
            ],
            [
                'document_category_id' => $categories->where('name', 'Form Layanan')->first()->id,
                'title' => 'Format Surat Pengantar RT/RW',
                'description' => 'Draft surat pengantar yang harus dibawa ke kantor desa untuk berbagai keperluan administrasi.',
                'file_path' => 'documents/pengantar-rt-rw.docx',
                'file_extension' => 'docx',
                'file_size' => 120,
            ],
            [
                'document_category_id' => $categories->where('name', 'Form Layanan')->first()->id,
                'title' => 'Formulir Pendaftaran Bantuan Sosial (Bansos)',
                'description' => 'Formulir untuk pengajuan pendataan keluarga penerima manfaat bantuan sosial.',
                'file_path' => 'documents/form-bansos.pdf',
                'file_extension' => 'pdf',
                'file_size' => 350,
            ],
            [
                'document_category_id' => $categories->where('name', 'Peraturan Desa')->first()->id,
                'title' => 'Peraturan Desa (Perdes) No. 04 Tahun 2025 tentang APBDes',
                'description' => 'Dokumen resmi peraturan desa mengenai Anggaran Pendapatan dan Belanja Desa tahun 2025.',
                'file_path' => 'documents/perdes-apbdes-2025.pdf',
                'file_extension' => 'pdf',
                'file_size' => 1200,
            ],
            [
                'document_category_id' => $categories->where('name', 'Laporan Keuangan')->first()->id,
                'title' => 'Template Laporan Keuangan RT',
                'description' => 'File Excel untuk memudahkan ketua RT dalam melaporkan iuran dan pengeluaran lingkungan.',
                'file_path' => 'documents/laporan-rt.xlsx',
                'file_extension' => 'xlsx',
                'file_size' => 80,
            ],
        ];

        foreach ($documents as $document) {
            \App\Models\Document::create($document);
        }
    }
}
