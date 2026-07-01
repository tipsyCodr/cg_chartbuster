<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SongSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title', 'description', 'release_date', 'duration', 'album', 'director',
        'poster_image', 'poster_image_portrait', 'poster_image_landscape',
        'trailer_url', 'region_id', 'cg_chartbusters_ratings',
        'support_artists', 'producer', 'singer_male', 'singer_female', 'lyrics',
        'composition', 'mix_master', 'music', 'recordists', 'audio_studio',
        'editor', 'video_studio', 'vfx', 'make_up', 'drone', 'others',
        'content_description', 'content_description_chh', 'hyperlinks_links',
        'is_release_year_only', 'show_on_banner', 'banner_label', 'banner_link',
        'production_house_id', 'genre_ids', 'artists_json',
        // Moderation
        'status', 'review_notes', 'approved_by', 'approved_at', 'rejected_by', 'rejected_at',
    ];

    protected $casts = [
        'genre_ids'            => 'array',
        'artists_json'         => 'array',
        'is_release_year_only' => 'boolean',
        'show_on_banner'       => 'boolean',
        'release_date'         => 'date',
        'approved_at'          => 'datetime',
        'rejected_at'          => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejecter()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function song()
    {
        return $this->hasOne(Song::class, 'submission_id');
    }

    public function isPending(): bool { return $this->status === 'pending'; }
    public function isApproved(): bool { return $this->status === 'approved'; }
    public function isRejected(): bool { return $this->status === 'rejected'; }
}
