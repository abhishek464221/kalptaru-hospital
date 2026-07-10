<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Blog;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        // Latest posts for sidebar (optional)
        $latestPosts = Blog::published()
                           ->orderBy('published_at', 'desc')
                           ->limit(3)
                           ->get();

        return view('frontend.pages.contact', compact('latestPosts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'message' => 'nullable|string',
        ]);

        Contact::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'message' => $request->message,
            'status' => 'new',
        ]);

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}