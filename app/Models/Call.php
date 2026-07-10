<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'receiver_id',
        'caller_name',
        'receiver_name',
        'call_datetime',
        'duration_seconds',
        'call_type',
        'direction',
        'notes',
        'follow_up_required',
        'follow_up_date',
    ];

    protected $casts = [
        'call_datetime' => 'datetime',
        'follow_up_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}