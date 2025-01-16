<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'bio',
        'category',
        'birth_date',
        'photo',
        'city',

    ];
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_artist');
    }
    public function tvshows()
    {
        return $this->belongsToMany(TvShow::class, 'artist_tvshow');
    }
    public function songs()
    {
        return $this->belongsToMany(Song::class, 'artist_song');
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
