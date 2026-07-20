<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_bill_id', 'item_name', 'description',
        'quantity', 'unit_price', 'total', 'category'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total' => 'decimal:2',
        'quantity' => 'integer'
    ];

    public function bill()
    {
        return $this->belongsTo(PatientBill::class);
    }
}