<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content_type',
        'title',
        'description',
        'media_file',
        'external_link',
        'category',
        'tags',
        'payload_json',
        'terms_accepted',
        'moderation_status',
        'admin_notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'payload_json' => 'array',
        'terms_accepted' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
