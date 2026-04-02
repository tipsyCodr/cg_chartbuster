<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSlug;

class ArticleCategory extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function getSlugField(): string
    {
        return 'name';
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }
}
