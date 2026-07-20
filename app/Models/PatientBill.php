<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'appointment_id', 'bill_number', 'bill_date', 'due_date',
        'consultation_fee', 'room_charges', 'medicine_charges', 'lab_charges',
        'operation_charges', 'other_charges', 'total_amount', 'discount',
        'tax', 'net_amount', 'payment_status', 'payment_method',
        'transaction_id', 'payment_response', 'notes'
    ];

    protected $casts = [
        'bill_date' => 'date',
        'due_date' => 'date',
        'total_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function items()
    {
        return $this->hasMany(BillItem::class);
    }

    public function payments()
    {
        return $this->hasMany(PatientPayment::class);
    }

    // Generate Bill Number
    public static function generateBillNumber()
    {
        $prefix = 'INV';
        $year = date('Y');
        $month = date('m');
        $last = self::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count();
        $number = str_pad($last + 1, 4, '0', STR_PAD_LEFT);
        return $prefix . $year . $month . $number;
    }
}