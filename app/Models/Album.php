<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'release_date',
        'genre',
        'artist_id',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_album');
    }

}
