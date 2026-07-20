<?php

namespace App\Models;
use App\Traits\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'category',
        'supplier',
        'batch_number',
        'purchase_price',
        'selling_price',
        'stock_quantity',
        'reorder_level',
        'manufacture_date',
        'expiry_date',
        'description',
        'is_active',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'reorder_level' => 'integer',
        'manufacture_date' => 'date',
        'expiry_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Check if medicine is expired
    public function isExpired()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    // Check if stock is low
    public function isLowStock()
    {
        return $this->stock_quantity <= $this->reorder_level;
    }

    // Get status label
    public function getStatusLabelAttribute()
    {
        if (!$this->is_active) {
            return '<span class="badge badge-danger">Inactive</span>';
        }
        if ($this->isExpired()) {
            return '<span class="badge badge-danger">Expired</span>';
        }
        if ($this->isLowStock()) {
            return '<span class="badge badge-warning">Low Stock</span>';
        }
        return '<span class="badge badge-success">Active</span>';
    }

    // Get stock status
    public function getStockStatusAttribute()
    {
        if ($this->stock_quantity <= 0) {
            return 'Out of Stock';
        } elseif ($this->isLowStock()) {
            return 'Low Stock (' . $this->stock_quantity . ')';
        }
        return 'In Stock (' . $this->stock_quantity . ')';
    }

    // Accessor for full name (just name)
    public function getFullNameAttribute()
    {
        return $this->name;
    }
}