<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $leaves = Leave::with(['employee', 'approver'])
            ->search(
                $request->search,
                [
                    'leave_type',
                    'start_date',
                    'end_date',
                    'status',
                    'reason',
                    'rejection_reason'
                ]
            )
            ->latest()
            ->paginate(10);

        return view('admin.leave.index', compact('leaves'));
    }

    public function create()
    {
        $employees = Employee::all();
        $users = User::all(); 
        return view('admin.leave.create', compact('employees', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|in:casual,sick,earned,maternity,paternity,other',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
            'approved_by' => 'nullable|exists:users,id',
            'rejection_reason' => 'nullable|string',
        ]);

        Leave::create($request->all());

        return redirect()->route('admin.leaves.index')
            ->with('success', 'Leave request created successfully.');
    }

    public function edit(Leave $leave)
    {
        $employees = Employee::all();
        $users = User::all();
        return view('admin.leave.edit', compact('leave', 'employees', 'users'));
    }

    public function update(Request $request, Leave $leave)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|in:casual,sick,earned,maternity,paternity,other',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
            'approved_by' => 'nullable|exists:users,id',
            'rejection_reason' => 'nullable|string',
        ]);

        $leave->update($request->all());

        return redirect()->route('admin.leaves.index')
            ->with('success', 'Leave request updated successfully.');
    }

    public function destroy(Leave $leave)
    {
        $leave->delete();
        return redirect()->route('admin.leaves.index')
            ->with('success', 'Leave request deleted successfully.');
    }
}