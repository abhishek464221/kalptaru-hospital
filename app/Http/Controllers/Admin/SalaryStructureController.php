<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalaryStructure;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryStructureController extends Controller
{
    /**
     * Display a listing of salary structures.
     */
    public function index(Request $request)
    {
        $structures = SalaryStructure::with(['employee'])
            ->when($request->search, function($q) use ($request) {
                $q->whereHas('employee', function($q2) use ($request) {
                    $q2->where('first_name', 'LIKE', "%{$request->search}%")
                       ->orWhere('last_name', 'LIKE', "%{$request->search}%");
                });
            })
            ->when($request->type, function($q) use ($request) {
                $q->where('employee_type', $request->type);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.salary-structure.index', compact('structures'));
    }

    /**
     * Show the form for creating a new salary structure.
     */
    public function create()
    {
        // Get all employee types with their records
        $doctors = Doctor::select('id', 'first_name', 'last_name', 'specialization')->get();
        $employees = Employee::select('id', 'first_name', 'last_name')->get();
        // If you have Users, you can add them too

        $employeeTypes = [
            'doctor' => $doctors,
            'employee' => $employees,
        ];

        return view('admin.salary-structure.create', compact('employeeTypes'));
    }

    /**
     * Store a newly created salary structure.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_type' => 'required|in:doctor,employee',
            'employee_id' => 'required|integer',
            'base_salary' => 'required|numeric|min:0',
            'payment_frequency' => 'required|in:monthly,weekly,hourly',
            'allowances' => 'nullable|array',
            'allowances.*' => 'numeric|min:0',
            'deductions' => 'nullable|array',
            'deductions.*' => 'numeric|min:0',
            'variable_components' => 'nullable|array',
            'variable_components.*' => 'numeric|min:0',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after:effective_from',
            'is_active' => 'sometimes|boolean',
        ]);

        // Convert employee_type to full class name for polymorphic
        $typeMap = [
            'doctor' => Doctor::class,
            'employee' => Employee::class,
        ];

        $data = $request->all();
        $data['employee_type'] = $typeMap[$request->employee_type];
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // Clean empty JSON fields
        $data['allowances'] = $request->allowances ?: [];
        $data['deductions'] = $request->deductions ?: [];
        $data['variable_components'] = $request->variable_components ?: [];

        SalaryStructure::create($data);

        return redirect()->route('admin.salary-structures.index')
            ->with('success', 'Salary Structure created successfully.');
    }

    /**
     * Display the specified salary structure.
     */
    public function show(SalaryStructure $salaryStructure)
    {
        $salaryStructure->load('employee');
        return view('admin.salary-structure.show', compact('salaryStructure'));
    }

    /**
     * Show the form for editing the specified salary structure.
     */
    public function edit(SalaryStructure $salaryStructure)
    {
        $doctors = Doctor::select('id', 'first_name', 'last_name', 'specialization')->get();
        $employees = Employee::select('id', 'first_name', 'last_name')->get();

        $employeeTypes = [
            'doctor' => $doctors,
            'employee' => $employees,
        ];

        // Determine current employee type for dropdown selection
        $currentType = class_basename($salaryStructure->employee_type);
        $currentTypeLower = strtolower($currentType);

        return view('admin.salary-structure.edit', compact('salaryStructure', 'employeeTypes', 'currentTypeLower'));
    }

    /**
     * Update the specified salary structure.
     */
    public function update(Request $request, SalaryStructure $salaryStructure)
    {
        $request->validate([
            'employee_type' => 'required|in:doctor,employee',
            'employee_id' => 'required|integer',
            'base_salary' => 'required|numeric|min:0',
            'payment_frequency' => 'required|in:monthly,weekly,hourly',
            'allowances' => 'nullable|array',
            'allowances.*' => 'numeric|min:0',
            'deductions' => 'nullable|array',
            'deductions.*' => 'numeric|min:0',
            'variable_components' => 'nullable|array',
            'variable_components.*' => 'numeric|min:0',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after:effective_from',
            'is_active' => 'sometimes|boolean',
        ]);

        $typeMap = [
            'doctor' => Doctor::class,
            'employee' => Employee::class,
        ];

        $data = $request->all();
        $data['employee_type'] = $typeMap[$request->employee_type];
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['allowances'] = $request->allowances ?: [];
        $data['deductions'] = $request->deductions ?: [];
        $data['variable_components'] = $request->variable_components ?: [];

        $salaryStructure->update($data);

        return redirect()->route('admin.salary-structures.index')
            ->with('success', 'Salary Structure updated successfully.');
    }

    /**
     * Remove the specified salary structure.
     */
    public function destroy(SalaryStructure $salaryStructure)
    {
        // Check if any payroll exists for this structure
        if ($salaryStructure->payrolls()->count() > 0) {
            return redirect()->route('admin.salary-structures.index')
                ->with('error', 'Cannot delete: This structure has associated payrolls.');
        }

        $salaryStructure->delete();
        return redirect()->route('admin.salary-structures.index')
            ->with('success', 'Salary Structure deleted successfully.');
    }

    /**
     * AJAX: Get employees by type for dropdown
     */
    public function getEmployees(Request $request)
    {
        $type = $request->type;
        $selected = $request->selected ?? null;

        if ($type == 'doctor') {
            $employees = Doctor::select('id', 'first_name', 'last_name')
                ->orderBy('first_name')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->full_name,
                    ];
                });
        } else if ($type == 'employee') {
            $employees = Employee::select('id', 'first_name', 'last_name')
                ->orderBy('first_name')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->full_name,
                    ];
                });
        } else {
            return response()->json([]);
        }

        return response()->json($employees);
    }
}