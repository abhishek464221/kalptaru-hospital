<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'employee_type', 'salary_structure_id', 'month_year',
        'total_earnings', 'total_deductions', 'net_payable',
        'status', 'payment_date', 'payment_gateway_id', 'transaction_id', 'notes'
    ];

    protected $casts = [
        'total_earnings' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'net_payable' => 'decimal:2',
        'payment_date' => 'date'
    ];

    public function employee()
    {
        return $this->morphTo();
    }

    public function salaryStructure()
    {
        return $this->belongsTo(SalaryStructure::class);
    }

    public function items()
    {
        return $this->hasMany(PayrollItem::class);
    }

    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    public function getEmployeeNameAttribute()
    {
        return $this->employee ? $this->employee->full_name : 'N/A';
    }
}