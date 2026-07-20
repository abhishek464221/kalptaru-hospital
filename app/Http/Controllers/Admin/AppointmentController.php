<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->search(
                $request->search,
                [
                    'doctor_id',
                    'patient_id',
                    'appointment_date',
                    'appointment_time',
                    'reason',
                    'status',
                    'notes'
                ]
            )
            ->latest()
            ->paginate(10);

        return view('admin.appointment.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('admin.appointment.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'reason' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,checked_in,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        Appointment::create($request->all());

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('admin.appointment.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'reason' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,checked_in,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($request->all());

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }
}