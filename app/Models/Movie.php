<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'release_date',
        'genre',
        'duration',
        'director',
        'poster_image',
        'trailer_url'
    ];
    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'movie_artist');
    }

    public function albums()
    {
        return $this->belongsToMany(Album::class, 'movie_album');
    }
}
