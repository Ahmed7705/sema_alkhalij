<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'author_id',
        'title_ar',
        'title_en',
        'slug',
        'excerpt_ar',
        'excerpt_en',
        'content_ar',
        'content_en',
        'featured_image',
        'meta_title_ar',
        'meta_description_ar',
        'tags',
        'is_published',
        'published_at',
        'views_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'tags' => 'array',
    ];

    public function getTitleAttribute()
    {
        return $this->title_ar;
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt_ar;
    }

    public function getContentAttribute()
    {
        return $this->content_ar;
    }

    public function getImageAttribute()
    {
        return $this->featured_image;
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
