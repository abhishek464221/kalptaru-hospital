<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Employee;
use App\Models\Doctor;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of schedules.
     */
    public function index()
    {
        $schedules = Schedule::with(['employee', 'doctor'])->get();
        return view('admin.schedule.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create()
    {
        $employees = Employee::all();
        $doctors = Doctor::all();
        return view('admin.schedule.create', compact('employees', 'doctors'));
    }

    /**
     * Store a newly created schedule.
     */
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

        // Ensure at least one of employee_id or doctor_id is provided
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

    /**
     * Show the form for editing the specified schedule.
     */
    public function edit(Schedule $schedule)
    {
        $employees = Employee::all();
        $doctors = Doctor::all();
        return view('admin.schedule.edit', compact('schedule', 'employees', 'doctors'));
    }

    /**
     * Update the specified schedule.
     */
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

        // Ensure at least one of employee_id or doctor_id is provided
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

    /**
     * Remove the specified schedule.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }
}