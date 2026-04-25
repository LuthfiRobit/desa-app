<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('year') && $request->year != '') {
            $query->whereYear('date_taken', $request->year);
        }

        $galleries = $query->latest('date_taken')->paginate(12);
        
        $years = Gallery::selectRaw('YEAR(date_taken) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();

        if ($request->ajax()) {
            return view('administrator.galeri.grid', compact('galleries'))->render();
        }

        return view('administrator.galeri.index', compact('galleries', 'years'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'date_taken' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $imagePath = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'title' => $request->title,
            'image_path' => $imagePath,
            'date_taken' => Carbon::parse($request->date_taken),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil diunggah'
        ]);
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'date_taken' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $imagePath = $gallery->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update([
            'title' => $request->title,
            'image_path' => $imagePath,
            'date_taken' => Carbon::parse($request->date_taken),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }
        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil dihapus'
        ]);
    }
}
