<?php

namespace App\Models;
use App\Traits\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use Searchable;
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'image',
        'password',
        'is_active',
        'last_seen',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'last_seen' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function updateLastSeen()
    {
        $this->last_seen = now();
        $this->save();
    }

    public function getLastSeenAttribute($value)
    {
        return $value
            ? \Carbon\Carbon::parse($value)
            : null;
    }
}