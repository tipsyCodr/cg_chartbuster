<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventUploadService
{
    /**
     * Upload event poster to public storage.
     */
    public function uploadPoster(UploadedFile $file): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('events', $filename, 'public');
        
        return $path;
    }

    /**
     * Delete event poster from storage.
     */
    public function deletePoster(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Get full URL for poster.
     */
    public function getPosterUrl(?string $path): string
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }

        return 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=1280&auto=format&fit=crop';
    }
}
