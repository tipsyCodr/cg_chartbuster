<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'movie_artist');
    }

    public function albums()
    {
        return $this->belongsToMany(Album::class, 'movie_album');
    }
}
