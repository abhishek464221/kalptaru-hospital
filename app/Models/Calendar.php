<?php

namespace App\Models;
use App\Traits\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'color',
        'location',
        'is_all_day',
        'user_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_all_day' => 'boolean',
    ];

    // Relationship with user (creator)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Accessor for creator name
    public function getCreatorNameAttribute()
    {
        return $this->user ? $this->user->name : 'Unknown';
    }

    // Accessor for event duration text
    public function getDurationTextAttribute()
    {
        if ($this->is_all_day) {
            return 'All Day';
        }
        $start = $this->start_time ? $this->start_time->format('h:i A') : '';
        $end = $this->end_time ? $this->end_time->format('h:i A') : '';
        return $start . ' - ' . $end;
    }

    // Accessor for date range text
    public function getDateRangeTextAttribute()
    {
        $start = $this->start_date->format('d M Y');
        if ($this->end_date && $this->end_date != $this->start_date) {
            return $start . ' - ' . $this->end_date->format('d M Y');
        }
        return $start;
    }

    // Get color badge
    public function getColorBadgeAttribute()
    {
        $colors = [
            '#FF0000' => 'danger',
            '#00FF00' => 'success',
            '#0000FF' => 'primary',
            '#FFFF00' => 'warning',
            '#FF00FF' => 'pink',
            '#00FFFF' => 'info',
            '#FFA500' => 'orange',
            '#800080' => 'purple',
            '#808080' => 'secondary',
            '#000000' => 'dark',
        ];
        
        $class = $colors[$this->color] ?? 'secondary';
        return '<span class="badge badge-' . $class . '" style="background-color: ' . ($this->color ?? '#6c757d') . '; color: #fff;">' . ($this->color ?? 'Default') . '</span>';
    }

    // Scope for upcoming events
    public function scopeUpcoming($query, $days = 30)
    {
        return $query->where('start_date', '>=', today())
            ->where('start_date', '<=', today()->addDays($days));
    }

    // Scope for past events
    public function scopePast($query)
    {
        return $query->where('end_date', '<', today());
    }

    // Scope for events on a specific date
    public function scopeOnDate($query, $date)
    {
        return $query->where('start_date', '<=', $date)
            ->where(function ($q) use ($date) {
                $q->where('end_date', '>=', $date)
                    ->orWhereNull('end_date');
            });
    }
}