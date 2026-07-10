<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'head_of_department',
    ];

    public function getIconAttribute()
    {
        $icons = [
            'cardiology' => 'fa-heartbeat',
            'neurology' => 'fa-brain',
            'orthopedics' => 'fa-bone',
            'cancer' => 'fa-hospital-o',
            'ophthalmology' => 'fa-eye',
            'respiratory' => 'fa-lungs',
            'general' => 'fa-stethoscope',
        ];
        $key = strtolower($this->name);
        return $icons[$key] ?? 'fa-stethoscope';
    }
}