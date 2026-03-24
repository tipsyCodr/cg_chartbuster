<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'user_id',
        'slug',
        'title_hi',
        'title_en',
        'title_chh',
        'excerpt_hi',
        'excerpt_en',
        'excerpt_chh',
        'content_hi',
        'content_en',
        'content_chh',
        'category',
        'tags',
        'featured_image',
        'meta_title',
        'meta_description',
        'status',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
    ];

    public function getSlugField(): string
    {
        return 'title_hi';
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    public function localizedTitle(string $lang = 'hi'): string
    {
        if ($lang === 'en' && !empty($this->title_en)) {
            return $this->title_en;
        }
        if ($lang === 'chh' && !empty($this->title_chh)) {
            return $this->title_chh;
        }
        return $this->title_hi;
    }

    public function localizedExcerpt(string $lang = 'hi'): ?string
    {
        if ($lang === 'en' && !empty($this->excerpt_en)) {
            return $this->excerpt_en;
        }
        if ($lang === 'chh' && !empty($this->excerpt_chh)) {
            return $this->excerpt_chh;
        }
        return $this->excerpt_hi;
    }

    public function localizedContent(string $lang = 'hi'): string
    {
        if ($lang === 'en' && !empty($this->content_en)) {
            return $this->content_en;
        }
        if ($lang === 'chh' && !empty($this->content_chh)) {
            return $this->content_chh;
        }
        return $this->content_hi;
    }
}
