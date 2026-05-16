<?php

namespace App\Services;

use App\Models\ContentSubmission;
use App\Models\Movie;
use App\Models\Song;
use App\Models\TvShow;
use App\Models\Artist;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubmissionApprovalService
{
    public function approve(ContentSubmission $submission, array $data = [])
    {
        return DB::transaction(function () use ($submission, $data) {
            $submission->update([
                'moderation_status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'admin_notes' => $data['admin_notes'] ?? $submission->admin_notes,
            ]);

            return $this->transformToModule($submission);
        });
    }

    protected function transformToModule(ContentSubmission $submission)
    {
        switch ($submission->content_type) {
            case 'Movie':
                return Movie::create([
                    'title' => $submission->title,
                    'description' => $submission->description,
                    'poster_image' => $submission->media_file,
                    'duration' => '00:00:00',
                    // Add other defaults or map from payload_json if needed
                ]);
            case 'Song':
                return Song::create([
                    'title' => $submission->title,
                    'description' => $submission->description,
                    'poster_image' => $submission->media_file,
                ]);
            case 'TV Show':
                return TvShow::create([
                    'title' => $submission->title,
                    'description' => $submission->description,
                    'poster_image' => $submission->media_file,
                ]);
            case 'Artist':
                return Artist::create([
                    'name' => $submission->title,
                    'bio' => $submission->description,
                    'photo' => $submission->media_file,
                ]);
            case 'Event':
                return Event::create([
                    'title' => $submission->title,
                    'description' => $submission->description,
                    'poster_image' => $submission->media_file,
                ]);
            default:
                return null;
        }
    }

    public function reject(ContentSubmission $submission, array $data = [])
    {
        return $submission->update([
            'moderation_status' => 'rejected',
            'admin_notes' => $data['admin_notes'] ?? $submission->admin_notes,
        ]);
    }
}
