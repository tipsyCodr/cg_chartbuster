<?php

namespace App\Models;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function singer_male()
    {
        return $this->belongsTo(Artist::class, 'singer_male');
    }

    public function singer_female()
    {
        return $this->belongsTo(Artist::class, 'singer_female');
    }
    public function artists()
    {
        return $this->belongsToMany(Artist::class)
            ->withPivot('artist_category_id', 'role')
            ->withTimestamps();
    }
    public function albums()
    {
        return $this->belongsToMany(Album::class, 'movie_album');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'movie_id');
    }
    public function pivotCategory()
    {
        return $this->belongsTo(ArtistCategory::class, 'artist_category_id');
    }
}
