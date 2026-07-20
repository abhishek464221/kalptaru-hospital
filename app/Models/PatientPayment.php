<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_bill_id', 'payment_gateway_id', 'transaction_id',
        'amount', 'currency', 'payment_method', 'status',
        'response', 'paid_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'response' => 'array'
    ];

    public function bill()
    {
        return $this->belongsTo(PatientBill::class);
    }

    public function gateway()
    {
        return $this->belongsTo(PaymentGateway::class);
    }
}