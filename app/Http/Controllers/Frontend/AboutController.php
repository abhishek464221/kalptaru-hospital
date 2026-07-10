<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Blog;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $aboutDoctors = Doctor::with('department')->limit(6)->get();

        $aboutDepartments = Department::limit(6)->get();

        $latestPosts = Blog::published()
                           ->orderBy('published_at', 'desc')
                           ->limit(3)
                           ->get();

        return view('frontend.pages.about', compact(
            'aboutDoctors', 'aboutDepartments', 'latestPosts'
        ));
    }
}