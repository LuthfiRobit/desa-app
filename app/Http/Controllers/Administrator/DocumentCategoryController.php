<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentCategory;
use Illuminate\Support\Facades\Validator;

class DocumentCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = DocumentCategory::withCount('documents');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('administrator.dokumen.kategori.table', compact('categories'))->render();
        }

        return view('administrator.dokumen.kategori.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:document_categories,name',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah ada.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        DocumentCategory::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori dokumen berhasil ditambahkan'
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = DocumentCategory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:document_categories,name,' . $id,
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah ada.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $category->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori dokumen berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $category = DocumentCategory::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori dokumen berhasil dihapus'
        ]);
    }
}
