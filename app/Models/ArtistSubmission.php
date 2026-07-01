<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name', 'bio', 'bio_hi', 'bio_chh', 'cgcb_rating', 'category',
        'birth_date', 'photo', 'banner_image', 'city', 'hyperlinks_links',
        'is_release_year_only', 'founded_year', 'owner_name', 'active_since',
        'website_url', 'youtube_url', 'instagram_url', 'facebook_url', 'twitter_url',
        'is_featured', 'is_verified',
        // Moderation
        'status', 'review_notes', 'approved_by', 'approved_at', 'rejected_by', 'rejected_at',
    ];

    protected $casts = [
        'category'             => 'array',
        'is_release_year_only' => 'boolean',
        'is_featured'          => 'boolean',
        'is_verified'          => 'boolean',
        'birth_date'           => 'date',
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

    public function artist()
    {
        return $this->hasOne(Artist::class, 'submission_id');
    }

    public function isPending(): bool { return $this->status === 'pending'; }
    public function isApproved(): bool { return $this->status === 'approved'; }
    public function isRejected(): bool { return $this->status === 'rejected'; }
}
