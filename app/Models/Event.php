<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'event_type',
        'event_mode',
        'venue',
        'city',
        'state',
        'organizer_name',
        'contact_email',
        'contact_phone',
        'description',
        'registration_link',
        'entry_fee',
        'poster',
        'start_datetime',
        'end_datetime',
        'registration_deadline',
        'approval_status',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'registration_deadline' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title) . '-' . Str::random(5);
            }
        });
    }

    /**
     * Relationship: Event belongs to a User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Computed Attribute: Dynamic Event Status.
     * Logic:
     * Upcoming: now < start
     * Live: now between start and end
     * Expired: now > end
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                $now = Carbon::now('Asia/Kolkata');
                
                if ($now->lt($this->start_datetime)) {
                    return 'Upcoming';
                }
                
                if ($now->between($this->start_datetime, $this->end_datetime)) {
                    return 'Live';
                }
                
                return 'Expired';
            }
        );
    }

    /**
     * Computed Attribute: Poster URL with fallback.
     */
    protected function posterUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->poster && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->poster)) {
                    return \Illuminate\Support\Facades\Storage::url($this->poster);
                }
                return 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=1280&auto=format&fit=crop';
            }
        );
    }

    /**
     * Scope: Only approved events.
     */
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }
}
