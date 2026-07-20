<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('patient_id', 'LIKE', "%{$search}%")
                  ->orWhere('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('gender', 'LIKE', "%{$search}%")
                  ->orWhere('address', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('type') && in_array($request->type, ['OPD', 'IPD', 'ICU'])) {
            $query->where('patient_type', $request->type);
        }

        $patients = $query->latest()->paginate(10);

        return view('admin.patient.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patient.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'        => 'required|string|max:255|unique:patients',
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'date_of_birth'     => 'nullable|date',
            'gender'            => 'nullable|in:male,female,other',
            'email'             => 'nullable|email|unique:patients',
            'phone'             => 'required|string|max:20',
            'address'           => 'nullable|string',
            'medical_history'   => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:20',
            'is_active'         => 'sometimes|boolean',
            'patient_type'      => 'nullable|in:OPD,IPD,ICU',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        Patient::create($data);

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient created successfully.');
    }

    public function edit(Patient $patient)
    {
        return view('admin.patient.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'patient_id'        => 'required|string|max:255|unique:patients,patient_id,' . $patient->id,
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'date_of_birth'     => 'nullable|date',
            'gender'            => 'nullable|in:male,female,other',
            'email'             => 'nullable|email|unique:patients,email,' . $patient->id,
            'phone'             => 'required|string|max:20',
            'address'           => 'nullable|string',
            'medical_history'   => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:20',
            'is_active'         => 'sometimes|boolean',
            'patient_type'      => 'nullable|in:OPD,IPD,ICU',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $patient->update($data);

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient deleted successfully.');
    }
}