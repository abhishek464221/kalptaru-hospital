<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'employee_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'job_title',
        'joining_date',
        'exit_date',
        'basic_salary',
        'is_active',
        'image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'joining_date' => 'date',
        'exit_date' => 'date',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the employee's image URL.
     * Returns stored image or default placeholder.
     */
    public function getImageAttribute()
    {
        if (!empty($this->attributes['image']) && Storage::disk('public')->exists($this->attributes['image'])) {
            return asset('storage/' . $this->attributes['image']);
        }
        return asset('frontend/images/team/employee.png');
    }
}