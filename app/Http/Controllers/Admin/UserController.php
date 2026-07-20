<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index(Request $request)
{
    $users = User::with('role')
        ->search($request->search, ['name', 'email'])
        ->latest()
        ->paginate(10);

    return view('admin.user.index', compact('users'));
}

    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time().'_'.$image->getClientOriginalName();

            $image->move(public_path('uploads/users'), $imageName);
        }

        User::create([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $imageName,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'role_id' => $request->role_id,
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {

            if ($user->image && File::exists(public_path('uploads/users/'.$user->image))) {
                File::delete(public_path('uploads/users/'.$user->image));
            }

            $image = $request->file('image');

            $imageName = time().'_'.$image->getClientOriginalName();

            $image->move(public_path('uploads/users'), $imageName);

            $data['image'] = $imageName;
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() == $user->id) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        if ($user->image && File::exists(public_path('uploads/users/'.$user->image))) {
            File::delete(public_path('uploads/users/'.$user->image));
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}