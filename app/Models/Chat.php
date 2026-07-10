<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'status',
        'is_read',
        'read_at',
        'attachment',        
        'attachment_type',   
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'attachment' => 'array',      
        'attachment_type' => 'array',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function markAsDelivered()
    {
        if ($this->status === 'sent') {
            $this->update(['status' => 'delivered']);
        }
    }

    public function markAsSeen()
    {
        if ($this->status !== 'seen') {
            $this->update([
                'status' => 'seen',
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    public static function unreadCount($userId)
    {
        return self::where('receiver_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    public static function conversation($user1, $user2)
    {
        return self::where(function ($query) use ($user1, $user2) {
            $query->where('sender_id', $user1)->where('receiver_id', $user2);
        })->orWhere(function ($query) use ($user1, $user2) {
            $query->where('sender_id', $user2)->where('receiver_id', $user1);
        })->orderBy('created_at', 'asc')->get();
    }
}