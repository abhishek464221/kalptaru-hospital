<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

   public function index(Request $request)
    {
        $departments = Department::search(
                $request->search,
                [
                    'name',
                    'code',
                    'description',
                    'head_of_department'
                ]
            )
            ->latest()
            ->paginate(10);

        return view('admin.department.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.department.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:departments,code',
            'description' => 'nullable|string',
            'head_of_department' => 'nullable|string|max:255',
        ]);

        Department::create($request->all());

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        return view('admin.department.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'head_of_department' => 'nullable|string|max:255',
        ]);

        $department->update($request->all());

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}