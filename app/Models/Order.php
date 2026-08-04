<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'customer_name',
        'order_number',
        'subtotal',
        'tax',
        'total_price',
        'status',
        'payment_status',
        'payment_method',
        'city',
        'shipping_address',
        'phone',
        'notes',
        'zatca_qr',
        'zatca_hash',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
            if (empty($model->order_number)) {
                $year = date('Y');
                $latestOrder = static::where('order_number', 'LIKE', "ORD-{$year}-%")->orderBy('id', 'desc')->first();
                $seq = $latestOrder ? ((int) substr($latestOrder->order_number, -5)) + 1 : 10001;
                $model->order_number = "ORD-{$year}-{$seq}";
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
