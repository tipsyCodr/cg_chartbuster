<?php

namespace App\Models;

use App\Models\Movie;
use App\Models\TvShow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasSlug;

class Artist extends Model
{
    use HasFactory, HasSlug;
    protected $fillable = [
        'slug',
        'name',
        'bio',
        'cgcb_rating',
        'category',
        'birth_date',
        'photo',
        'city',
        'hyperlinks_links',
        'is_release_year_only'
    ];
    
    protected $casts = [
        'birth_date' => 'date',
    ];

    public function getSlugField(): string
    {
        return 'name';
    }

    public function scopeSingerMale($query)
    {
        return $query->where('category', '10')->select('id', 'name');
    }

    public function scopeSingerFemale($query)
    {
        return $query->where('category', '11')->select('id', 'name');
    }
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'artist_movie', 'artist_id', 'movie_id')
            ->using(ArtistMediaPivot::class)
            ->withPivot('artist_category_ids')
            ->withTimestamps();
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'artist_song', 'artist_id', 'song_id')
            ->using(ArtistMediaPivot::class)
            ->withPivot('artist_category_ids')
            ->withTimestamps();
    }

    public function tvshows()
    {
        return $this->belongsToMany(TvShow::class, 'artist_tvshow', 'artist_id', 'tvshow_id')
            ->using(ArtistMediaPivot::class)
            ->withPivot('artist_category_ids')
            ->withTimestamps();
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }
    public function category()
    {
        return $this->hasMany(ArtistCategory::class);
    }

}
