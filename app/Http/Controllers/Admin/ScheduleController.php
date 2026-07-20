<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Employee;
use App\Models\Doctor;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $schedules = Schedule::with(['employee', 'doctor'])
            ->search(
                $request->search,
                [
                    'day_of_week',
                    'start_time',
                    'end_time',
                    'notes'
                ]
            )
            ->latest()
            ->paginate(10);

        return view('admin.schedule.index', compact('schedules'));
    }
    public function create()
    {
        $employees = Employee::all();
        $doctors = Doctor::all();
        return view('admin.schedule.create', compact('employees', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'nullable|exists:employees,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_working_day' => 'sometimes|boolean',
            'notes' => 'nullable|string',
        ]);

        if (empty($request->employee_id) && empty($request->doctor_id)) {
            return back()->withErrors(['employee_id' => 'Please select either an Employee or a Doctor.'])
                ->withInput();
        }

        $data = $request->all();
        $data['is_working_day'] = $request->has('is_working_day') ? 1 : 0;

        Schedule::create($data);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule created successfully.');
    }

    public function edit(Schedule $schedule)
    {
        $employees = Employee::all();
        $doctors = Doctor::all();
        return view('admin.schedule.edit', compact('schedule', 'employees', 'doctors'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'employee_id' => 'nullable|exists:employees,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_working_day' => 'sometimes|boolean',
            'notes' => 'nullable|string',
        ]);

        if (empty($request->employee_id) && empty($request->doctor_id)) {
            return back()->withErrors(['employee_id' => 'Please select either an Employee or a Doctor.'])
                ->withInput();
        }

        $data = $request->all();
        $data['is_working_day'] = $request->has('is_working_day') ? 1 : 0;

        $schedule->update($data);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }
}