<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
   public function index(Request $request)
    {
        $blogs = Blog::with('author')
            ->search(
                $request->search,
                [
                    'title',
                    'slug',
                    'content',
                    'status',
                    'category'
                ]
            )
            ->latest()
            ->paginate(10);

        return view('admin.blog.index', compact('blogs'));
    }
    
    public function create()
    {
        $users = User::all();
        return view('admin.blog.create', compact('users'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($request->filled('tags')) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        } else {
            $data['tags'] = [];
        }
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('blogs', 'public');
            $data['featured_image'] = $path;
        }

        if ($request->status == 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        Blog::create($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog created successfully.');
    }


    public function edit(Blog $blog)
    {
        $users = User::all();
        $tagsString = $blog->tags ? implode(', ', $blog->tags) : '';
        return view('admin.blog.edit', compact('blog', 'users', 'tagsString'));
    }


    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($request->filled('tags')) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        } else {
            $data['tags'] = [];
        }

        if ($request->hasFile('featured_image')) {

            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $path = $request->file('featured_image')->store('blogs', 'public');
            $data['featured_image'] = $path;
        }

        if ($request->status == 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }
}