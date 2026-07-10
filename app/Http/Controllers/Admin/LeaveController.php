<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of leaves.
     */
    public function index()
    {
        $leaves = Leave::with(['employee', 'approver'])->get();
        return view('admin.leave.index', compact('leaves'));
    }

    /**
     * Show the form for creating a new leave.
     */
    public function create()
    {
        $employees = Employee::all();
        $users = User::all(); // for approver dropdown
        return view('admin.leave.create', compact('employees', 'users'));
    }

    /**
     * Store a newly created leave.
     */
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

    /**
     * Show the form for editing the specified leave.
     */
    public function edit(Leave $leave)
    {
        $employees = Employee::all();
        $users = User::all();
        return view('admin.leave.edit', compact('leave', 'employees', 'users'));
    }

    /**
     * Update the specified leave.
     */
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

    /**
     * Remove the specified leave.
     */
    public function destroy(Leave $leave)
    {
        $leave->delete();
        return redirect()->route('admin.leaves.index')
            ->with('success', 'Leave request deleted successfully.');
    }
}