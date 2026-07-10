<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return view('admin.doctor.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id'        => 'required|string|max:255|unique:doctors',
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'email'            => 'required|email|unique:doctors',
            'phone'            => 'nullable|string|max:20',
            'specialization'   => 'required|string|max:255',
            'consultation_fee' => 'nullable|numeric|min:0',
            'available_days'   => 'nullable|array',
            'available_days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'opening_time'     => 'nullable|date_format:H:i',
            'closing_time'     => 'nullable|date_format:H:i',
            'qualification'    => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'is_active'        => 'sometimes|boolean',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if (!isset($data['available_days'])) {
            $data['available_days'] = [];
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('doctors', 'public');
            $data['image'] = $path;
        }

        Doctor::create($data);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor created successfully.');
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.doctor.edit', compact('doctor'));
    }



    public function update(Request $request, Doctor $doctor)
    {
        try {
            $validated = $request->validate([
                'doctor_id'        => 'required|string|max:255|unique:doctors,doctor_id,' . $doctor->id,
                'first_name'       => 'required|string|max:255',
                'last_name'        => 'required|string|max:255',
                'email'            => 'required|email|unique:doctors,email,' . $doctor->id,
                'phone'            => 'nullable|string|max:20',
                'specialization'   => 'required|string|max:255',
                'consultation_fee' => 'nullable|numeric|min:0',
                'available_days'   => 'nullable|array',
                'opening_time' => 'nullable|date_format:H:i:s',
                'closing_time' => 'nullable|date_format:H:i:s',
                'qualification'    => 'nullable|string',
                'experience_years' => 'nullable|integer|min:0',
                'is_active'        => 'sometimes|boolean',
                'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $validated['available_days'] = $request->input('available_days', []);

            $validated['is_active'] = $request->has('is_active') ? 1 : 0;

            if ($request->hasFile('image')) {
                if ($doctor->image && Storage::disk('public')->exists($doctor->image)) {
                    Storage::disk('public')->delete($doctor->image);
                }

                $path = $request->file('image')->store('doctors', 'public');
                if (!$path) {
                    throw new \Exception('Image could not be stored.');
                }
                $validated['image'] = $path;
            }
            $updated = $doctor->update($validated);

            if (!$updated) {
                throw new \Exception('Doctor update failed.');
            }

            return redirect()->route('admin.doctors.index')
                ->with('success', 'Doctor updated successfully.');

        } catch (\Exception $e) {
            Log::error('Doctor Update Error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Update failed: ' . $e->getMessage()]);
        }
    }

    public function destroy(Doctor $doctor)
    {
        if ($doctor->image && Storage::disk('public')->exists($doctor->image)) {
            Storage::disk('public')->delete($doctor->image);
        }
        $doctor->delete();
        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor deleted successfully.');
    }
}