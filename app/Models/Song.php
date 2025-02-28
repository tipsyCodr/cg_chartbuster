<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'release_date',
        'genre',
        'duration',
        'director',
        'album',
        'poster_image',
        'trailer_url',
        'region',
        'cg_chartbusters_ratings',
        'imdb_ratings',
        'support_artists',
        'producer',
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
        'vfx',
        'make_up',
        'drone',
        'others',
        'content_description',
        'hyperlinks_links',
        'poster_image_portrait',
        'poster_image_landscape'
    ];
    public function album()
    {
        return $this->belongsTo(Album::class);
    }
    public function artists()
    {
        return $this->belongsToMany(Artist::class,'artist_song','song_id')
        ->withPivot('artist_category_id','role')
        ->withTimestamps();
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
