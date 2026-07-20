<?php

namespace App\Models;
use App\Traits\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'employee_id',
        'leave_type',
        'start_date',
        'end_date',
        'reason',
        'status',
        'approved_by',
        'rejection_reason',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relationship with employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Relationship with user who approved
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Accessor for employee full name
    public function getEmployeeNameAttribute()
    {
        return $this->employee ? $this->employee->full_name : 'N/A';
    }

    // Accessor for approver name
    public function getApproverNameAttribute()
    {
        return $this->approver ? $this->approver->name : 'N/A';
    }
}