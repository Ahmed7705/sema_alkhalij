<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'batch_number',
        'expiry_date',
        'quantity',
        'reserved_quantity',
        'buy_price',
        'sell_price',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'quantity' => 'integer',
        'reserved_quantity' => 'integer',
        'buy_price' => 'decimal:2',
        'sell_price' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function getAvailableQuantityAttribute(): int
    {
        return max(0, $this->quantity - $this->reserved_quantity);
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expiry_date->isPast();
    }

    public function getIsExpiringSoonAttribute(): bool
    {
        return !$this->is_expired && $this->expiry_date->diffInDays(now()) <= 60;
    }
}
