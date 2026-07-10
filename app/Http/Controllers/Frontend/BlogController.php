<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of published blogs.
     */
    public function index()
    {
        // Sirf published blogs, latest first, paginate (10 per page)
        $blogs = Blog::published()
                     ->orderBy('published_at', 'desc')
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);

        // Sidebar data: categories, recent posts, tags, archives
        $categories = Blog::published()
                          ->whereNotNull('category')
                          ->select('category')
                          ->distinct()
                          ->pluck('category');

        $recentPosts = Blog::published()
                           ->orderBy('published_at', 'desc')
                           ->limit(4)
                           ->get();

        // Tags: collect all tags from published blogs
        $allTags = Blog::published()
                       ->whereNotNull('tags')
                       ->pluck('tags')
                       ->flatten()
                       ->unique()
                       ->sort()
                       ->values();

        // Archives: group by year-month
        $archives = Blog::published()
                        ->selectRaw('YEAR(published_at) as year, MONTH(published_at) as month, COUNT(*) as count')
                        ->groupBy('year', 'month')
                        ->orderBy('year', 'desc')
                        ->orderBy('month', 'desc')
                        ->get();

        return view('frontend.pages.blog', compact('blogs', 'categories', 'recentPosts', 'allTags', 'archives'));
    }

    /**
     * Display the specified blog.
     */
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();

        // Previous and Next posts
        $prevBlog = Blog::where('status', 'published')
                        ->where('id', '<', $blog->id)
                        ->orderBy('id', 'desc')
                        ->first();

        $nextBlog = Blog::where('status', 'published')
                        ->where('id', '>', $blog->id)
                        ->orderBy('id', 'asc')
                        ->first();

        // Sidebar data...
        $categories = Blog::published()->whereNotNull('category')->select('category')->distinct()->pluck('category');
        $recentPosts = Blog::published()->where('id', '!=', $blog->id)->orderBy('published_at', 'desc')->limit(4)->get();
        $allTags = Blog::published()->whereNotNull('tags')->pluck('tags')->flatten()->unique()->sort()->values();
        $archives = Blog::published()
                        ->selectRaw('YEAR(published_at) as year, MONTH(published_at) as month, COUNT(*) as count')
                        ->groupBy('year', 'month')
                        ->orderBy('year', 'desc')
                        ->orderBy('month', 'desc')
                        ->get();

        return view('frontend.pages.blog_details', compact(
            'blog', 'categories', 'recentPosts', 'allTags', 'archives', 'prevBlog', 'nextBlog'
        ));
    }
}