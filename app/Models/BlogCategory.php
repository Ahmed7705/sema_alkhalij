<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'slug',
    ];

    public function getNameAttribute()
    {
        return $this->name_ar;
    }

    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'category_id');
    }
}
