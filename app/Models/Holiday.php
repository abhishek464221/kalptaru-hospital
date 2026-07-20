<?php

namespace App\Models;
use App\Traits\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'holiday_date',
        'description',
        'is_weekly_off',
    ];

    protected $casts = [
        'holiday_date' => 'date',
        'is_weekly_off' => 'boolean',
    ];
}