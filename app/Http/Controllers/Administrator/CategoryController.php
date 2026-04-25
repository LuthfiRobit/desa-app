<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('articles');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('slug', 'like', '%' . $request->search . '%');
        }

        $categories = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('administrator.berita.kategori.table', compact('categories'))->render();
        }

        return view('administrator.berita.kategori.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first('name')
            ], 422);
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $id,
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first('name')
            ], 422);
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui',
            'data' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Cek jika kategori memiliki artikel
        if ($category->articles()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak dapat dihapus karena masih memiliki artikel'
            ], 422);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus'
        ]);
    }
}
