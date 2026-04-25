<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        
        $query = Article::with(['category', 'user']);

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('status') && $request->status != '') {
            $status = $request->status == 'published' ? 1 : 0;
            $query->where('is_published', $status);
        }

        $articles = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('administrator.berita.table', compact('articles'))->render();
        }

        return view('administrator.berita.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('administrator.berita.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        $isPublished = $request->input('is_published') == '1';

        $article = Article::create([
            'user_id' => auth()->id() ?? 1, // Fallback if not logged in for now
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image_path' => $imagePath,
            'is_published' => $isPublished,
            'published_at' => $request->published_at ? Carbon::parse($request->published_at) : ($isPublished ? now() : null),
        ]);

        return redirect()->route('admin.berita.artikel.index')->with('success', 'Berita berhasil disimpan');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::orderBy('name', 'asc')->get();
        return view('administrator.berita.form', compact('article', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = $article->image_path;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        $isPublished = $request->input('is_published') == '1';

        $article->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image_path' => $imagePath,
            'is_published' => $isPublished,
            'published_at' => $request->published_at ? Carbon::parse($request->published_at) : ($isPublished ? ($article->published_at ?? now()) : null),
        ]);

        return redirect()->route('admin.berita.artikel.index')->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        
        if ($article->image_path) {
            Storage::disk('public')->delete($article->image_path);
        }
        
        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dihapus'
        ]);
    }
}
