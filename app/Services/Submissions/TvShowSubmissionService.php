<?php

namespace App\Services\Submissions;

use App\Models\TvShow;
use App\Models\TvShowSubmission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TvShowSubmissionService
{
    public function publish(TvShowSubmission $submission, ?string $reviewNotes = null): TvShow
    {
        if (! $submission->isPending()) {
            throw new \Exception("Submission #{$submission->id} is not pending (current status: {$submission->status}).");
        }

        return DB::transaction(function () use ($submission, $reviewNotes) {

            $data = $submission->only([
                'title', 'description', 'release_date', 'director',
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

            $tvShow = TvShow::create(array_merge($data, [
                'submission_id' => $submission->id,
            ]));

            // Sync genres
            $genreIds = $submission->genre_ids ?? [];
            if (! empty($genreIds)) {
                $tvShow->genres()->sync($genreIds);
            }

            // Sync artists pivot
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
                $tvShow->artists()->sync($artistData);
            }

            $submission->update([
                'status'       => 'approved',
                'review_notes' => $reviewNotes ?? $submission->review_notes,
                'approved_by'  => auth()->id(),
                'approved_at'  => now(),
            ]);

            Log::info("TvShowSubmission #{$submission->id} approved → TvShow #{$tvShow->id}");

            return $tvShow;
        });
    }

    public function reject(TvShowSubmission $submission, ?string $reviewNotes = null): TvShowSubmission
    {
        $submission->update([
            'status'       => 'rejected',
            'review_notes' => $reviewNotes ?? $submission->review_notes,
            'rejected_by'  => auth()->id(),
            'rejected_at'  => now(),
        ]);

        Log::info("TvShowSubmission #{$submission->id} rejected.");

        return $submission;
    }
}
