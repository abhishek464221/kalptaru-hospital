<?php

namespace App\Models;
use App\Traits\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'recipient_email',
        'recipient_name',
        'subject',
        'body',
        'attachments',
        'status',
        'sent_at',
        'error_message',
    ];

    protected $casts = [
        'attachments' => 'array',
        'sent_at' => 'datetime',
    ];

    // Get status badge
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'sent' => 'badge-success',
            'failed' => 'badge-danger',
            'queued' => 'badge-warning',
        ];
        $class = $colors[$this->status] ?? 'badge-secondary';
        return '<span class="badge ' . $class . '">' . ucfirst($this->status) . '</span>';
    }

    // Scope for sent emails
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    // Scope for failed emails
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    // Scope for queued emails
    public function scopeQueued($query)
    {
        return $query->where('status', 'queued');
    }
}