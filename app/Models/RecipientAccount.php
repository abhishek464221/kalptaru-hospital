<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class RecipientAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipientable_id', 'recipientable_type',
        'account_holder_name', 'bank_name', 'account_number',
        'ifsc_code', 'upi_id', 'qr_code', 'settings',
        'is_active', 'display_order'
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean'
    ];

    // Polymorphic relation
    public function recipientable()
    {
        return $this->morphTo();
    }

    // Get full account details for display
    public function getAccountDetailsAttribute()
    {
        $details = [];
        if ($this->account_holder_name) $details[] = "Holder: {$this->account_holder_name}";
        if ($this->bank_name) $details[] = "Bank: {$this->bank_name}";
        if ($this->account_number) $details[] = "A/c: {$this->account_number}";
        if ($this->ifsc_code) $details[] = "IFSC: {$this->ifsc_code}";
        if ($this->upi_id) $details[] = "UPI: {$this->upi_id}";
        return implode(', ', $details);
    }

    // QR Code URL
    public function getQrUrlAttribute()
    {
        return $this->qr_code ? Storage::url($this->qr_code) : null;
    }

    // Get active recipient for a specific model
    public static function getForRecipient($model)
    {
        return self::where('recipientable_id', $model->id)
                   ->where('recipientable_type', get_class($model))
                   ->where('is_active', true)
                   ->orderBy('display_order')
                   ->first();
    }
}