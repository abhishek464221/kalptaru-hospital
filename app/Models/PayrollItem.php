<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_id', 'label', 'type', 'amount', 'source', 'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2'
    ];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}