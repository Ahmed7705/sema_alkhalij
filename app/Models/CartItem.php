<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'service_id',
        'quantity',
        'price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getItemTitleAttribute()
    {
        if ($this->product_id && $this->product) {
            return $this->product->title;
        }
        if ($this->service_id && $this->service) {
            return $this->service->title;
        }
        return 'عنصر مجاني';
    }

    public function getItemImageAttribute()
    {
        if ($this->product_id && $this->product) {
            return $this->product->image ?? 'hero-doctor.png';
        }
        if ($this->service_id && $this->service) {
            return 'hero-doctor.png';
        }
        return 'hero-doctor.png';
    }

    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}
