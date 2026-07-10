<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'appointment_id',
        'invoice_number',
        'amount',
        'discount',
        'tax',
        'net_amount',
        'payment_date',
        'payment_method',
        'status',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'net_amount' => 'decimal:2',
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    // Accessor for patient full name
    public function getPatientNameAttribute()
    {
        return $this->patient ? $this->patient->full_name : 'N/A';
    }

    // Generate invoice number
    public static function generateInvoiceNumber()
    {
        $latest = self::latest()->first();
        $number = $latest ? intval(substr($latest->invoice_number, 3)) + 1 : 1;
        return 'INV-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}