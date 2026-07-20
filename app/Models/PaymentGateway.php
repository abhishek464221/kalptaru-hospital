<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 'mode', 'key', 'secret', 'qr_code',
        'upi_id', 'account_holder', 'account_number',
        'ifsc_code', 'bank_name', 'settings', 'is_active', 'display_order'
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean'
    ];

    // Encrypt/Decrypt sensitive data
    public function setKeyAttribute($value)
    {
        if ($value) {
            $this->attributes['key'] = Crypt::encryptString($value);
        }
    }

    public function getKeyAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public function setSecretAttribute($value)
    {
        if ($value) {
            $this->attributes['secret'] = Crypt::encryptString($value);
        }
    }

    public function getSecretAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public static function getActiveQR()
    {
        return self::whereIn('type', ['qr', 'gateway', 'bank'])
                ->where('is_active', true)
                ->orderBy('display_order')
                ->first();
    }

    public function payments()
    {
        return $this->hasMany(PatientPayment::class);
    }
}