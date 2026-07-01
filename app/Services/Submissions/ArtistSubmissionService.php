<?php

namespace App\Services\Submissions;

use App\Models\Artist;
use App\Models\ArtistSubmission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArtistSubmissionService
{
    public function publish(ArtistSubmission $submission, ?string $reviewNotes = null): Artist
    {
        if (! $submission->isPending()) {
            throw new \Exception("Submission #{$submission->id} is not pending (current status: {$submission->status}).");
        }

        return DB::transaction(function () use ($submission, $reviewNotes) {

            $data = $submission->only([
                'name', 'bio', 'bio_hi', 'bio_chh', 'cgcb_rating', 'category',
                'birth_date', 'photo', 'banner_image', 'city', 'hyperlinks_links',
                'is_release_year_only', 'founded_year', 'owner_name', 'active_since',
                'website_url', 'youtube_url', 'instagram_url', 'facebook_url', 'twitter_url',
                'is_featured', 'is_verified',
            ]);

            // Artist has no pivot relationships — direct create only
            $artist = Artist::create(array_merge($data, [
                'submission_id' => $submission->id,
            ]));

            $submission->update([
                'status'       => 'approved',
                'review_notes' => $reviewNotes ?? $submission->review_notes,
                'approved_by'  => auth()->id(),
                'approved_at'  => now(),
            ]);

            Log::info("ArtistSubmission #{$submission->id} approved → Artist #{$artist->id}");

            return $artist;
        });
    }

    public function reject(ArtistSubmission $submission, ?string $reviewNotes = null): ArtistSubmission
    {
        $submission->update([
            'status'       => 'rejected',
            'review_notes' => $reviewNotes ?? $submission->review_notes,
            'rejected_by'  => auth()->id(),
            'rejected_at'  => now(),
        ]);

        Log::info("ArtistSubmission #{$submission->id} rejected.");

        return $submission;
    }
}
