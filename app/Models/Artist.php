<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_artist');
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

}
