<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSlug;

class Song extends Model
{
    use HasFactory, HasSlug;
    protected $fillable = [
        'slug',
        'title',
        'description',
        'release_date',
        'genre_id',
        'duration',
        'director',
        'album',
        'poster_image',
        'trailer_url',
        'region_id',
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
        'show_on_banner',
        'banner_label',
        'banner_link',
        'others',
        'content_description',
        'content_description_chh',
        'hyperlinks_links',
        'poster_image_portrait',
        'poster_image_landscape',
        'is_release_year_only'
    ];
    protected $casts = [
        'release_date' => 'date',
    ];
    public function album()
    {
        return $this->belongsTo(Album::class);
    }
    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'artist_song', 'song_id')
            ->using(ArtistMediaPivot::class)
            ->withPivot('artist_category_ids')
            ->withTimestamps();
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function genre()
    {
        return $this->genres()->limit(1);
    }
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'song_genre', 'song_id', 'genre_id');
    }
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
