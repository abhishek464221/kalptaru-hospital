<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalaryStructure;
use App\Models\Employee;
use Illuminate\Http\Request;

class SalaryStructureController extends Controller
{
    /**
     * Display a listing of salary structures.
     */
    public function index()
    {
        $salaryStructures = SalaryStructure::with('employee')->get();
        return view('admin.salary-structure.index', compact('salaryStructures'));
    }

    /**
     * Show the form for creating a new salary structure.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('admin.salary-structure.create', compact('employees'));
    }

    /**
     * Store a newly created salary structure.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'basic' => 'nullable|numeric|min:0',
            'house_rent_allowance' => 'nullable|numeric|min:0',
            'conveyance_allowance' => 'nullable|numeric|min:0',
            'medical_allowance' => 'nullable|numeric|min:0',
            'other_allowances' => 'nullable|numeric|min:0',
            'provident_fund' => 'nullable|numeric|min:0',
            'tax_deduction' => 'nullable|numeric|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after:effective_from',
        ]);

        SalaryStructure::create($request->all());

        return redirect()->route('admin.salary-structures.index')
            ->with('success', 'Salary structure created successfully.');
    }

    /**
     * Show the form for editing the specified salary structure.
     */
    public function edit(SalaryStructure $salaryStructure)
    {
        $employees = Employee::all();
        return view('admin.salary-structure.edit', compact('salaryStructure', 'employees'));
    }

    /**
     * Update the specified salary structure.
     */
    public function update(Request $request, SalaryStructure $salaryStructure)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'basic' => 'nullable|numeric|min:0',
            'house_rent_allowance' => 'nullable|numeric|min:0',
            'conveyance_allowance' => 'nullable|numeric|min:0',
            'medical_allowance' => 'nullable|numeric|min:0',
            'other_allowances' => 'nullable|numeric|min:0',
            'provident_fund' => 'nullable|numeric|min:0',
            'tax_deduction' => 'nullable|numeric|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after:effective_from',
        ]);

        $salaryStructure->update($request->all());

        return redirect()->route('admin.salary-structures.index')
            ->with('success', 'Salary structure updated successfully.');
    }

    /**
     * Remove the specified salary structure.
     */
    public function destroy(SalaryStructure $salaryStructure)
    {
        $salaryStructure->delete();
        return redirect()->route('admin.salary-structures.index')
            ->with('success', 'Salary structure deleted successfully.');
    }
}