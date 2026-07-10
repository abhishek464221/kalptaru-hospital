<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'specialization',
        'consultation_fee',
        'available_days',
        'opening_time',
        'closing_time',
        'qualification',
        'experience_years',
        'is_active',
        'image',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'available_days' => 'array',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getImageAttribute()
    {
        if (!empty($this->attributes['image']) && Storage::disk('public')->exists($this->attributes['image'])) {
            return asset('storage/' . $this->attributes['image']);
        }
        return asset('frontend/images/team/img.png');
    }
    
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id'); // agar foreign key alag hai toh specify karo
    }
}