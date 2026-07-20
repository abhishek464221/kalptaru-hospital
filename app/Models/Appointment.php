<?php

namespace App\Models;
use App\Traits\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'reason',
        'status',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function getPatientNameAttribute()
    {
        return $this->patient ? $this->patient->full_name : 'N/A';
    }

    public function getDoctorNameAttribute()
    {
        return $this->doctor ? $this->doctor->full_name : 'N/A';
    }
}