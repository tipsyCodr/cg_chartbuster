<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ArtistMediaPivot extends Pivot
{
    protected $casts = [
        'artist_category_ids' => 'array',
    ];

    /**
     * Ensure artist_category_ids is always an array.
     */
    public function getArtistCategoryIdsAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }
        
        return json_decode($value ?? '[]', true) ?: [];
    }

    /**
     * Get the category names for this pivot entry.
     */
    public function getCategoryNamesAttribute()
    {
        $ids = $this->artist_category_ids;
        
        if (empty($ids)) {
            return [];
        }
        
        // Ensure $ids is an array for whereIn
        $ids = is_array($ids) ? $ids : [$ids];
        
        return ArtistCategory::whereIn('id', $ids)->pluck('name')->toArray();
    }
}
