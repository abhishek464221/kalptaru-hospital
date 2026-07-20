<?php

namespace App\Traits;

use App\Models\SalaryStructure;
use App\Models\Payroll;

trait HasSalary
{
    public function salaryStructure()
    {
        return $this->morphOne(SalaryStructure::class, 'employee')->where('is_active', true);
    }

    public function salaryStructures()
    {
        return $this->morphMany(SalaryStructure::class, 'employee');
    }

    public function payrolls()
    {
        return $this->morphMany(Payroll::class, 'employee');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}