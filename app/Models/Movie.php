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
        'trailer_url',
        'region',
        'cbfc',
        'cg_chartbusters_ratings',
        'imdb_ratings',
        'cinematographer',
        'dop',
        'screen_play',
        'writer_story_concept',
        'male_lead',
        'female_lead',
        'support_artists',
        'production_banner',
        'producer',
        'songs',
        'singer_male',
        'singer_female',
        'lyrics',
        'composition',
        'mix_master',
        'music',
        'recordists',
        'audio_studio',
        'editor',
        'video_studio',
        'poster_logo',
        'vfx',
        'make_up',
        'drone',
        'others',
        'content_description',
        'hyperlinks_links',
        'poster_image_portrait',
        'poster_image_landscape',
        'show_on_banner'

    ];
    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'movie_artist');
    }

    public function albums()
    {
        return $this->belongsToMany(Album::class, 'movie_album');
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class, 'movie_id');
    }
}
