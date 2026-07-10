<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of gallery items.
     */
    public function index()
    {
        $galleries = Gallery::orderBy('order', 'asc')->orderBy('created_at', 'desc')->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new gallery item.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created gallery item.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'file' => 'required|file|max:5120', // Max 5MB
            'file_type' => 'required|in:image,video',
            'album_name' => 'nullable|string|max:100',
            'is_featured' => 'sometimes|boolean',
            'order' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        // Validate file type based on selection
        if ($request->file_type === 'image') {
            $request->validate([
                'file' => 'image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            ]);
        } else {
            $request->validate([
                'file' => 'mimes:mp4,avi,mov,wmv,flv,webm|max:10240', // 10MB for video
            ]);
        }

        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . Str::random(10) . '.' . $extension;
            $path = $file->storeAs('gallery', $fileName, 'public');
            $data['file_path'] = $path;
        }

        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

        Gallery::create($data);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Gallery item added successfully.');
    }

    /**
     * Show the form for editing the specified gallery item.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified gallery item.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'file' => 'nullable|file|max:5120',
            'file_type' => 'required|in:image,video',
            'album_name' => 'nullable|string|max:100',
            'is_featured' => 'sometimes|boolean',
            'order' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        // Validate file type based on selection
        if ($request->hasFile('file')) {
            if ($request->file_type === 'image') {
                $request->validate([
                    'file' => 'image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
                ]);
            } else {
                $request->validate([
                    'file' => 'mimes:mp4,avi,mov,wmv,flv,webm|max:10240',
                ]);
            }
        }

        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($gallery->file_path) {
                Storage::disk('public')->delete($gallery->file_path);
            }
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . Str::random(10) . '.' . $extension;
            $path = $file->storeAs('gallery', $fileName, 'public');
            $data['file_path'] = $path;
        }

        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Gallery item updated successfully.');
    }

    /**
     * Remove the specified gallery item.
     */
    public function destroy(Gallery $gallery)
    {
        // Delete file from storage
        if ($gallery->file_path) {
            Storage::disk('public')->delete($gallery->file_path);
        }
        $gallery->delete();
        return redirect()->route('admin.galleries.index')
            ->with('success', 'Gallery item deleted successfully.');
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Gallery $gallery)
    {
        $gallery->update(['is_featured' => !$gallery->is_featured]);
        return redirect()->route('admin.galleries.index')
            ->with('success', 'Gallery item featured status updated.');
    }
}