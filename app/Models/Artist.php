<?php

namespace App\Models;

use App\Models\Movie;
use App\Models\TvShow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    public function scopeSingerMale($query)
    {
        return $query->where('category', '11')->select('id', 'name');
    }

    public function scopeSingerFemale($query)
    {
        return $query->where('category', '10')->select('id', 'name');
    }
    public function movies()
    {
        return $this->belongsToMany(Movie::class)->withPivot('role');
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class)->withPivot('role');
    }

    public function tvshows()
    {
        return $this->belongsToMany(TvShow::class)->withPivot('role');
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
