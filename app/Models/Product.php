<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'short_description',
        'description',
        'price',
        'discount_price',
        'stock',
        'sku',
        'image',
        'is_featured',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getEffectivePriceAttribute()
    {
        return $this->discount_price > 0 ? $this->discount_price : $this->price;
    }
}
