<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentCategory;

class DownloadController extends Controller
{
    /**
     * Tampilkan halaman pusat unduhan dengan filter kategori dan pencarian.
     */
    public function index(Request $request)
    {
        // Ambil semua kategori untuk sidebar filter
        $categories = DocumentCategory::orderBy('name', 'asc')->get();

        // Siapkan query document dengan Eager Loading
        $query = Document::with('category');

        // Filter berdasarkan kategori jika ada
        if ($request->has('category') && $request->category != '') {
            $query->where('document_category_id', $request->category);
        }

        // Pencarian berdasarkan judul dokumen
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Ambil data dengan pagination
        $documents = $query->latest()->paginate(4);

        if ($request->ajax()) {
            return view('landing.partials.download-items', compact('documents'))->render();
        }

        return view('landing.downloads', compact('categories', 'documents'));
    }
}
