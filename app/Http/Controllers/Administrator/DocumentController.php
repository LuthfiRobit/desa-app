<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $categories = DocumentCategory::orderBy('name', 'asc')->get();
        $query = Document::with('category');

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('document_category_id', $request->category);
        }

        $documents = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('administrator.dokumen.table', compact('documents'))->render();
        }

        return view('administrator.dokumen.index', compact('documents', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'document_category_id' => 'required|exists:document_categories,id',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ], [
            'title.required' => 'Judul dokumen wajib diisi.',
            'document_category_id.required' => 'Kategori wajib dipilih.',
            'file.required' => 'File dokumen wajib diunggah.',
            'file.mimes' => 'Format file harus PDF, DOC, DOCX, XLS, atau XLSX.',
            'file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $file = $request->file('file');
        $filePath = $file->store('documents', 'public');

        Document::create([
            'document_category_id' => $request->document_category_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_extension' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil diunggah'
        ]);
    }

    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'document_category_id' => 'required|exists:document_categories,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ], [
            'title.required' => 'Judul dokumen wajib diisi.',
            'document_category_id.required' => 'Kategori wajib dipilih.',
            'file.mimes' => 'Format file harus PDF, DOC, DOCX, XLS, atau XLSX.',
            'file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $filePath = $document->file_path;
        $fileExtension = $document->file_extension;
        $fileSize = $document->file_size;

        if ($request->hasFile('file')) {
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $file = $request->file('file');
            $filePath = $file->store('documents', 'public');
            $fileExtension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();
        }

        $document->update([
            'document_category_id' => $request->document_category_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_extension' => $fileExtension,
            'file_size' => $fileSize,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil dihapus'
        ]);
    }
}
