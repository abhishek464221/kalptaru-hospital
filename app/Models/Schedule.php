<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'doctor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_working_day',
        'notes',
    ];

    protected $casts = [
        'is_working_day' => 'boolean',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    // Relationship with employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Relationship with doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Accessor for employee name
    public function getEmployeeNameAttribute()
    {
        return $this->employee ? $this->employee->full_name : null;
    }

    // Accessor for doctor name
    public function getDoctorNameAttribute()
    {
        return $this->doctor ? $this->doctor->full_name : null;
    }

    // Accessor for schedule assignee (employee or doctor)
    public function getAssigneeAttribute()
    {
        if ($this->employee_id) {
            return 'Employee: ' . $this->employee_name;
        } elseif ($this->doctor_id) {
            return 'Doctor: ' . $this->doctor_name;
        }
        return 'N/A';
    }
}