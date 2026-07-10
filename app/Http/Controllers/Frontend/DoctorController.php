<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::where('is_active', true)->get();
        $specializations = $doctors->groupBy('specialization');
        
        // DEBUG: Check if data exists
        // dd($specializations); // Uncomment to test
        
        return view('frontend.pages.doctor', compact('doctors', 'specializations'));
    }

    public function show($id)
    {
        $doctor = Doctor::where('is_active', true)->findOrFail($id);
        return view('frontend.pages.doctor_details', compact('doctor'));
    }
}