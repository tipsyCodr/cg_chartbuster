<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'page_type',
        'content_id',
        'ip_address',
        'created_at'
    ];

    public $timestamps = false; // Using manual created_at timestamp in migration

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
