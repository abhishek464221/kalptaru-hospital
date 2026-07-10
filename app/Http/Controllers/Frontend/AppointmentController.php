<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    private function generatePatientId()
    {
        $lastPatient = Patient::whereNotNull('patient_id')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastPatient && $lastPatient->patient_id) {
            $lastNumber = (int) Str::after($lastPatient->patient_id, 'PAT-');
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'PAT-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    private function generateDoctorId()
    {
        $lastDoctor = Doctor::whereNotNull('doctor_id')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastDoctor && $lastDoctor->doctor_id) {
            $lastNumber = (int) Str::after($lastDoctor->doctor_id, 'DOC-');
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'DOC-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        Log::info('Frontend appointment request', $request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'note' => 'nullable|string',
            'department' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed', $validator->errors()->toArray());
            
            // Check if AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Find or create patient
        $patient = Patient::where('email', $request->email)
            ->orWhere('phone', $request->phone)
            ->first();

        if (!$patient) {
            $nameParts = explode(' ', $request->name, 2);
            $firstName = $nameParts[0] ?? $request->name;
            $lastName = $nameParts[1] ?? '';

            $patientId = $this->generatePatientId();

            try {
                $patient = Patient::create([
                    'patient_id' => $patientId,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'is_active' => true,
                ]);
                Log::info('Patient created', ['patient_id' => $patient->id]);
            } catch (\Exception $e) {
                Log::error('Patient creation failed', ['error' => $e->getMessage()]);
                
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unable to create patient. Please try again.'
                    ], 500);
                }
                
                return redirect()->back()->with('error', 'Unable to create patient. Please try again.');
            }
        }

        // Get a doctor – if none exists, create a default one
        $doctor = Doctor::first();
        if (!$doctor) {
            Log::warning('No doctor found, creating a default one');
            try {
                $doctorId = $this->generateDoctorId();
                $doctor = Doctor::create([
                    'doctor_id' => $doctorId,
                    'first_name' => 'Default',
                    'last_name' => 'Doctor',
                    'email' => 'default@hospital.com',
                    'phone' => '0000000000',
                    'specialization' => 'General',
                    'is_active' => true,
                ]);
                Log::info('Default doctor created', ['doctor_id' => $doctor->id]);
            } catch (\Exception $e) {
                Log::error('Doctor creation failed', ['error' => $e->getMessage()]);
                
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unable to create doctor. Please contact admin.'
                    ], 500);
                }
                
                return redirect()->back()->with('error', 'Unable to create doctor. Please contact admin.');
            }
        }

        // Create appointment
        try {
            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'reason' => $request->note,
                'status' => 'pending',
                'notes' => 'Booked from website' . ($request->department ? ' | Department: ' . $request->department : ''),
            ]);
            Log::info('Appointment created', ['appointment_id' => $appointment->id]);
        } catch (\Exception $e) {
            Log::error('Appointment creation failed', ['error' => $e->getMessage()]);
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to book appointment. Please try again.'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Unable to book appointment. Please try again.');
        }

        // Check if AJAX request
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Your appointment has been booked successfully! We will contact you shortly.',
                'appointment_id' => $appointment->id
            ]);
        }

        return redirect('/')->with('success', 'Your appointment has been booked successfully! We will contact you shortly.');
    }
}