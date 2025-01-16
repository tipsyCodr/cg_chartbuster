<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistCategory extends Model
{
    use HasFactory;
    protected $table = 'artist_category';
    protected $fillable = [
        'name'
    ];
    public function artist(){
        return $this->belongsToMany(Artist::class);
    }

}
