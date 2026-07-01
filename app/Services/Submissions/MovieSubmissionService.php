<?php

namespace App\Services\Submissions;

use App\Models\Movie;
use App\Models\MovieSubmission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MovieSubmissionService
{
    /**
     * Publish an approved submission into the movies production table.
     * Handles genre sync, artist pivot sync, and marks submission as approved.
     *
     * @throws \Exception if submission is not pending
     */
    public function publish(MovieSubmission $submission, ?string $reviewNotes = null): Movie
    {
        if (! $submission->isPending()) {
            throw new \Exception("Submission #{$submission->id} is not pending (current status: {$submission->status}).");
        }

        return DB::transaction(function () use ($submission, $reviewNotes) {

            // ── 1. Build production data array (exclude moderation + JSON relation fields) ──
            $data = $submission->only([
                'title', 'description', 'release_date', 'duration', 'director',
                'poster_image', 'poster_image_portrait', 'poster_image_landscape', 'poster_logo',
                'trailer_url', 'region_id', 'cbfc', 'cg_chartbusters_ratings',
                'cinematographer', 'dop', 'screen_play', 'writer_story_concept',
                'male_lead', 'female_lead', 'support_artists', 'production_banner',
                'producer', 'songs', 'singer_male', 'singer_female', 'lyrics',
                'composition', 'mix_master', 'music', 'recordists', 'audio_studio',
                'editor', 'video_studio', 'vfx', 'make_up', 'drone', 'others',
                'content_description', 'content_description_chh', 'hyperlinks_links',
                'is_release_year_only', 'show_on_banner', 'banner_label', 'banner_link',
                'production_house_id',
            ]);

            // ── 2. Create production record with submission reference ──
            $movie = Movie::create(array_merge($data, [
                'submission_id' => $submission->id,
            ]));

            // ── 3. Sync genres ──
            $genreIds = $submission->genre_ids ?? [];
            if (! empty($genreIds)) {
                $movie->genres()->sync($genreIds);
            }

            // ── 4. Sync artists pivot ──
            // artists_json format: [{ "artist_id": 1, "role": 2 }, ...]
            $artistEntries = $submission->artists_json ?? [];
            $artistData = [];
            foreach ($artistEntries as $entry) {
                $artistId = $entry['artist_id'] ?? null;
                $roleId   = $entry['role'] ?? null;
                if ($artistId && $roleId) {
                    if (! isset($artistData[$artistId])) {
                        $artistData[$artistId] = ['artist_category_ids' => []];
                    }
                    if (! in_array((int) $roleId, $artistData[$artistId]['artist_category_ids'])) {
                        $artistData[$artistId]['artist_category_ids'][] = (int) $roleId;
                    }
                }
            }
            if (! empty($artistData)) {
                $movie->artists()->sync($artistData);
            }

            // ── 5. Mark submission as approved ──
            $submission->update([
                'status'       => 'approved',
                'review_notes' => $reviewNotes ?? $submission->review_notes,
                'approved_by'  => auth()->id(),
                'approved_at'  => now(),
            ]);

            Log::info("MovieSubmission #{$submission->id} approved → Movie #{$movie->id}");

            return $movie;
        });
    }

    /**
     * Reject a submission.
     */
    public function reject(MovieSubmission $submission, ?string $reviewNotes = null): MovieSubmission
    {
        $submission->update([
            'status'       => 'rejected',
            'review_notes' => $reviewNotes ?? $submission->review_notes,
            'rejected_by'  => auth()->id(),
            'rejected_at'  => now(),
        ]);

        Log::info("MovieSubmission #{$submission->id} rejected.");

        return $submission;
    }
}
