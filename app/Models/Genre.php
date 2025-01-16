<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    protected $fillable = [
        'for',
        'name'
    ];
    public function movies()
    {
        return $this->hasMany(Movie::class);
    }

    public function tvShows()
    {
        return $this->hasMany(TvShow::class);
    }

    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }
}
