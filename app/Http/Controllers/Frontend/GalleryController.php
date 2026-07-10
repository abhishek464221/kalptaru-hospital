<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('order', 'asc')
                            ->orderBy('created_at', 'desc')
                            ->get();

        $grouped = $galleries->groupBy(function($item) {
            return $item->album_name ?? 'General';
        });

        return view('frontend.pages.gallery', compact('grouped', 'galleries'));
    }
}