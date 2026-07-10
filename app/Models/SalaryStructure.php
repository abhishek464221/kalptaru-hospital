<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'basic',
        'house_rent_allowance',
        'conveyance_allowance',
        'medical_allowance',
        'other_allowances',
        'provident_fund',
        'tax_deduction',
        'other_deductions',
        'gross_salary',
        'net_salary',
        'effective_from',
        'effective_to',
    ];

    protected $casts = [
        'effective_from' => 'date',
        'effective_to' => 'date',
    ];

    // Relationship with employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Accessor for employee full name
    public function getEmployeeNameAttribute()
    {
        return $this->employee ? $this->employee->full_name : 'N/A';
    }

    // Auto-calculate gross and net salary before saving
    protected static function booted()
    {
        static::saving(function ($salary) {
            // Calculate Gross Salary
            $salary->gross_salary = $salary->basic + $salary->house_rent_allowance + $salary->conveyance_allowance + $salary->medical_allowance + $salary->other_allowances;

            // Calculate Net Salary
            $total_deductions = $salary->provident_fund + $salary->tax_deduction + $salary->other_deductions;
            $salary->net_salary = $salary->gross_salary - $total_deductions;
        });
    }
}