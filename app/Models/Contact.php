<?php

namespace App\Models;
use App\Traits\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'message',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Get status badge
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'new' => 'badge-primary',
            'read' => 'badge-info',
            'replied' => 'badge-success',
        ];
        return '<span class="badge ' . ($colors[$this->status] ?? 'badge-secondary') . '">' . ucfirst($this->status) . '</span>';
    }

    // Scope for new messages
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }
}