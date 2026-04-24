<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $galleries = Gallery::latest('date_taken')->paginate(6);

        if ($request->ajax()) {
            return view('landing.partials.gallery-items', compact('galleries'))->render();
        }

        return view('landing.galeri', compact('galleries'));
    }
}
