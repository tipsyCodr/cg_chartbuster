<?php

namespace App\Http\Controllers\Submit;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Region;
use App\Models\Artist;
use App\Models\ArtistCategory;
use App\Models\SongSubmission;
use Illuminate\Http\Request;

class SongSubmitController extends Controller
{
    private function normalizeReleaseDate(?string $value, bool $yearOnly): ?string
    {
        if (blank($value)) return null;
        $value = trim($value);
        if ($yearOnly && preg_match('/^\d{4}$/', $value)) {
            return $value . '-01-01';
        }
        return $value;
    }

    private function normalizeDuration(?string $value): string
    {
        if (blank($value)) return '00:00:00';
        return strlen($value) === 5 ? $value . ':00' : $value;
    }

    public function create()
    {
        $genres = Genre::where('for', 'Songs')->get();
        $regions = Region::all();
        $artists = Artist::orderBy('name')->get();
        $categories = ArtistCategory::all();

        $productionHouseCategory = ArtistCategory::where('slug', 'production-house')->first();
        $productionHouses = $productionHouseCategory
            ? Artist::whereJsonContains('category', (string) $productionHouseCategory->id)->orderBy('name')->get()
            : collect();

        return view('submissions.song.create', compact(
            'genres', 'regions', 'artists', 'categories', 'productionHouses'
        ));
    }

    public function store(Request $request)
    {
        $request->merge([
            'release_date' => $this->normalizeReleaseDate($request->input('release_date'), $request->boolean('is_release_year_only')),
            'duration'     => $this->normalizeDuration($request->input('duration')),
        ]);

        $validated = $request->validate([
            'title'                   => 'required|string|max:255',
            'description'             => 'nullable|string',
            'release_date'            => 'nullable|date',
            'duration'                => 'nullable|date_format:H:i:s',
            'genre_ids'               => 'nullable|array',
            'genre_ids.*'             => 'exists:genres,id',
            'album'                   => 'nullable|string|max:255',
            'trailer_url'             => 'nullable|string',
            'region_id'               => 'nullable|exists:regions,id',
            'cg_chartbusters_ratings' => 'nullable|numeric',
            'content_description'     => 'nullable|string',
            'content_description_chh' => 'nullable|string',
            'poster_image'            => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'poster_image_landscape'  => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'artists'                 => 'nullable|array',
            'artists.*.artist_id'     => 'nullable|exists:artists,id',
            'artists.*.role'          => 'nullable|exists:artist_category,id',
            'show_on_banner'          => 'nullable',
            'banner_label'            => 'nullable|string|max:255',
            'banner_link'             => 'nullable|string',
            'is_release_year_only'    => 'nullable|boolean',
            'production_house_id'     => 'nullable|exists:artists,id',
        ]);

        foreach (['poster_image' => 'submissions/posters', 'poster_image_landscape' => 'submissions/posters_landscape'] as $field => $folder) {
            if ($request->hasFile($field)) {
                try {
                    $validated[$field] = $request->file($field)->store($folder, 'public');
                } catch (\Exception $e) {
                    \Log::error("Submission {$field} upload failed: " . $e->getMessage());
                    return redirect()->back()->with('error', 'Failed to upload image. Please try again.');
                }
            }
        }

        $artistEntries = $validated['artists'] ?? [];
        $artistsJson = array_values(array_filter(
            array_map(fn($e) => (!empty($e['artist_id']) && !empty($e['role'])) ? $e : null, $artistEntries)
        ));

        $genreIds = $validated['genre_ids'] ?? [];

        unset($validated['artists'], $validated['genre_ids']);

        SongSubmission::create(array_merge($validated, [
            'user_id'      => auth()->id(),
            'status'       => 'pending',
            'genre_ids'    => $genreIds,
            'artists_json' => $artistsJson,
        ]));

        return redirect()->route('submit.song.create')
            ->with('success', 'Your song submission has been received and is pending admin review. Thank you!');
    }
}
