<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'attendance_date',
        'check_in',
        'check_out',
        'status',
        'remarks',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'check_in' => 'datetime:H:i',
        'check_out' => 'datetime:H:i',
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
}