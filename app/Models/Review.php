<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'movie_id',
        'tvshow_id',
        'album_id',
        'song_id',
        'review_text',
        'rating',

    ];
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function movie(){
        return $this->belongsTo(Movie::class);
    }
    public function tvshow(){
        return $this->belongsTo(TvShow::class);
    }
    public function album(){
        return $this->belongsTo(Album::class);
    }
    public function song(){
        return $this->belongsTo(Song::class);
    }
}
