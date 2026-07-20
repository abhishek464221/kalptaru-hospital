<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'employee_type', 'base_salary', 'payment_frequency',
        'allowances', 'deductions', 'variable_components',
        'effective_from', 'effective_to', 'is_active'
    ];

    protected $casts = [
        'allowances' => 'array',
        'deductions' => 'array',
        'variable_components' => 'array',
        'effective_from' => 'date',
        'effective_to' => 'date',
        'is_active' => 'boolean'
    ];

    public function employee()
    {
        return $this->morphTo();
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function getTotalAllowancesAttribute()
    {
        return array_sum($this->allowances ?? []);
    }

    public function getTotalDeductionsAttribute()
    {
        return array_sum($this->deductions ?? []);
    }
}