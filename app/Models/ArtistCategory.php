<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasSlug;

class ArtistCategory extends Model
{
    use HasFactory, HasSlug;
    protected $table = 'artist_category';
    protected $fillable = [
        'name',
        'slug'
    ];

    public function getSlugField(): string
    {
        return 'name';
    }
    public function artist(){
        return $this->belongsToMany(Artist::class);
    }

}
