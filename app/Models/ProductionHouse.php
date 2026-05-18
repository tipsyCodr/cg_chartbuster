<?php

namespace App\Models;

use App\Models\ArtistCategory;

class ProductionHouse extends Artist
{
    protected $table = 'artists';

    /**
     * The "booted" method of the model.
     * Uses a static cache so the category lookup fires only once per request,
     * preventing an N+1 DB hit every time the global scope is applied.
     */
    protected static function booted()
    {
        static::addGlobalScope('production_house', function ($builder) {
            static $categoryId = null;
            if ($categoryId === null) {
                $category = ArtistCategory::where('slug', 'production-house')->first();
                $categoryId = $category ? (string) $category->id : '-1';
            }
            $builder->whereJsonContains('category', $categoryId);
        });
    }

    /**
     * Eager load relationship counts easily
     */
    public function scopeWithCounts($query)
    {
        return $query->withCount(['producedMovies', 'producedSongs', 'producedTvShows']);
    }

    public function producedMovies()
    {
        return $this->hasMany(Movie::class, 'production_house_id');
    }

    public function producedSongs()
    {
        return $this->hasMany(Song::class, 'production_house_id');
    }

    public function producedTvShows()
    {
        return $this->hasMany(TvShow::class, 'production_house_id');
    }
}
