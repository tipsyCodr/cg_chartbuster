<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSlug;

class TvShow extends Model
{
    use HasFactory, HasSlug;
    protected $table = 'tvshows';
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
        'poster_image_portrait',
        'poster_image_landscape',
        'show_on_banner',
        'banner_label',
        'banner_link',
        'is_release_year_only'
    ];

    protected $casts = [
        'release_date' => 'date',
    ];
    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'artist_tvshow', 'tvshow_id')
            ->using(ArtistMediaPivot::class)
            ->withPivot('artist_category_ids')
            ->withTimestamps();
    }
    public function albums()
    {
        return $this->belongsToMany(Album::class, 'tvshow_album');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'tvshow_id');
    }
    public function genre()
    {
        return $this->genres()->limit(1);
    }
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'tvshow_genre', 'tvshow_id', 'genre_id');
    }
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
