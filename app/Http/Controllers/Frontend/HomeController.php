<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestPosts = Blog::published()
                           ->orderBy('published_at', 'desc')
                           ->orderBy('created_at', 'desc')
                           ->limit(4)
                           ->get();

        $galleries = Gallery::where('is_featured', true)->limit(6)->get();
        $doctors = Doctor::with('department')->limit(4)->get();
        $departments = Department::limit(6)->get();

        return view('frontend.pages.index', compact(
            'latestPosts', 'galleries', 'doctors', 'departments'
        ));
    }
}