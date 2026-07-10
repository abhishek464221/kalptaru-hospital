<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'module',
        'description',
        'ip_address',
        'user_agent',
        'old_data',
        'new_data',
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for user name
    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : 'System';
    }

    // Get action badge color
    public function getActionColorAttribute()
    {
        $colors = [
            'login' => 'badge-info',
            'logout' => 'badge-secondary',
            'create' => 'badge-success',
            'update' => 'badge-warning',
            'delete' => 'badge-danger',
            'view' => 'badge-primary',
        ];
        return $colors[$this->action] ?? 'badge-secondary';
    }

    // Scope for filtering by module
    public function scopeModule($query, $module)
    {
        if ($module) {
            return $query->where('module', $module);
        }
        return $query;
    }

    // Scope for filtering by action
    public function scopeAction($query, $action)
    {
        if ($action) {
            return $query->where('action', $action);
        }
        return $query;
    }

    // Scope for date range
    public function scopeDateRange($query, $from, $to)
    {
        if ($from && $to) {
            return $query->whereBetween('created_at', [$from, $to]);
        }
        return $query;
    }
}