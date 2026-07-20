<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::with('department')
            ->search(
                $request->search,
                [
                    'employee_id',
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'job_title',
                    'gender',
                    'address'
                ]
            )
            ->latest()
            ->paginate(10);

        return view('admin.employee.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.employee.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id'   => 'required|exists:departments,id',
            'employee_id'     => 'required|string|max:255|unique:employees',
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email'           => 'required|email|unique:employees',
            'phone'           => 'nullable|string|max:20',
            'date_of_birth'   => 'nullable|date',
            'gender'          => 'nullable|in:male,female,other',
            'address'         => 'nullable|string',
            'job_title'       => 'required|string|max:255',
            'joining_date'    => 'required|date',
            'exit_date'       => 'nullable|date|after:joining_date',
            'basic_salary'    => 'nullable|numeric|min:0',
            'is_active'       => 'sometimes|boolean',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('employees', 'public');
            $data['image'] = $path;
        }

        Employee::create($data);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        return view('admin.employee.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'department_id'   => 'required|exists:departments,id',
            'employee_id'     => 'required|string|max:255|unique:employees,employee_id,' . $employee->id,
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email'           => 'required|email|unique:employees,email,' . $employee->id,
            'phone'           => 'nullable|string|max:20',
            'date_of_birth'   => 'nullable|date',
            'gender'          => 'nullable|in:male,female,other',
            'address'         => 'nullable|string',
            'job_title'       => 'required|string|max:255',
            'joining_date'    => 'required|date',
            'exit_date'       => 'nullable|date|after:joining_date',
            'basic_salary'    => 'nullable|numeric|min:0',
            'is_active'       => 'sometimes|boolean',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($employee->image && Storage::disk('public')->exists($employee->image)) {
                Storage::disk('public')->delete($employee->image);
            }
            $path = $request->file('image')->store('employees', 'public');
            $data['image'] = $path;
        }

        $employee->update($data);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->image && Storage::disk('public')->exists($employee->image)) {
            Storage::disk('public')->delete($employee->image);
        }
        $employee->delete();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}