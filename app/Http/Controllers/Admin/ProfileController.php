<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('admin.edit-profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            if ($user->image && $user->image != 'default.png' && File::exists(public_path('uploads/users/' . $user->image))) {
                File::delete(public_path('uploads/users/' . $user->image));
            }

            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/users'), $filename);
            $user->image = $filename;
        }

        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }

    public function changePassword()
    {
        return view('admin.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string|min:6',
            'new_password'     => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('admin.profile')->with('success', 'Password changed successfully.');
    }
}