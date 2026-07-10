<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of all departments.
     */
    public function index()
    {
        $departments = Department::all();
        return view('frontend.departments.index', compact('departments'));
    }

    /**
     * Display the specified department details.
     */
    public function show($slug)
    {
        $department = Department::where('name', 'LIKE', str_replace('-', ' ', $slug))
            ->firstOrFail();
        return view('frontend.departments.show', compact('department'));
    }
}