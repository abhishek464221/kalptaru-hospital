<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $attendances = Attendance::with("employee")
            ->search(
                $request->search,
                [
                    'employee_id',
                    'attendance_date',
                    'check_in',
                    'check_out',
                    'status',
                    'remarks'
                ]
            )
            ->latest()
            ->paginate(10);

        return view('admin.attendance.index', compact('attendances'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('admin.attendance.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'attendance_date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'status' => 'required|in:present,absent,leave,half_day,holiday',
            'remarks' => 'nullable|string',
        ]);

        Attendance::create($request->all());

        return redirect()->route('admin.attendances.index')
            ->with('success', 'Attendance marked successfully.');
    }

    public function edit(Attendance $attendance)
    {
        $employees = Employee::all();
        return view('admin.attendance.edit', compact('attendance', 'employees'));
    }


    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'attendance_date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'status' => 'required|in:present,absent,leave,half_day,holiday',
            'remarks' => 'nullable|string',
        ]);

        $attendance->update($request->all());

        return redirect()->route('admin.attendances.index')
            ->with('success', 'Attendance updated successfully.');
    }
    
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('admin.attendances.index')
            ->with('success', 'Attendance deleted successfully.');
    }
}