<?php

namespace App\Models;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasSlug;

class Movie extends Model
{

    use HasFactory, HasSlug;
    protected $fillable = [
        'views',
        'slug',
        'title',
        'description',
        'release_date',
        'genre_id',
        'duration',
        'director',
        'poster_image',
        'trailer_url',
        'region_id',
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
        'content_description_chh',
        'hyperlinks_links',
        'is_release_year_only',
        'poster_image_portrait',
        'poster_image_landscape',
        'show_on_banner',
        'banner_label',
        'banner_link',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    public function maleSingerArtist()
    {
        return $this->belongsTo(Artist::class, 'singer_male');
    }

    public function femaleSingerArtist()
    {
        return $this->belongsTo(Artist::class, 'singer_female');
    }
    public function artists()
    {
        return $this->belongsToMany(Artist::class)
            ->using(ArtistMediaPivot::class)
            ->withPivot('artist_category_ids')
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
    public function genre()
    {
        return $this->genres()->limit(1);
    }
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genre', 'movie_id', 'genre_id');
    }
    public function directorRelation()
    {
        return $this->belongsTo(Artist::class, 'director');
    }
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
