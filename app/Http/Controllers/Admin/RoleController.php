<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::search(
                $request->search,
                [
                    'name',
                    'slug',
                    'description'
                ]
            )
            ->latest()
            ->paginate(10);

        return view('admin.role.roles-permissions', compact('roles'));
    }

    public function create()
    {
        return view('admin.role.add-role');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'slug' => 'required|string|max:255|unique:roles,slug',
            'description' => 'nullable|string',
        ]);

        Role::create($request->all());

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        return view('admin.role.edit-role', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'slug' => 'required|string|max:255|unique:roles,slug,' . $role->id,
            'description' => 'nullable|string',
        ]);

        $role->update($request->all());

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if (in_array($role->slug, ['admin', 'manager', 'accountant'])) {
            return redirect()->route('admin.roles.index')->with('error', 'System roles cannot be deleted.');
        }

        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}