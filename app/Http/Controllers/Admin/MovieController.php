<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Region;
use App\Models\Artist;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    private function normalizeReleaseDate(?string $value, bool $yearOnly): ?string
    {
        if (blank($value)) {
            return null;
        }

        $value = trim($value);

        if ($yearOnly && preg_match('/^\d{4}$/', $value)) {
            return $value . '-01-01';
        }

        return $value;
    }

    private function normalizeDuration(?string $value): string
    {
        if (blank($value)) {
            return '00:00:00';
        }

        return strlen($value) === 5 ? $value . ':00' : $value;
    }

    public function index()
    {
        $genres = Genre::where('for','Movies')->get();
        $movies = Movie::latest()->paginate(5);
        // dd($movies); // Before the table to see what's returned
        $regions = Region::all();
        $singer_male = Artist::singerMale()->get();
        $singer_female = Artist::singerFemale()->get();
        return view('admin.movie.index', compact('movies','genres','regions','singer_male','singer_female'));
    }

    public function create()
    {
        $genres = Genre::where('for', 'Movies')->get();
        $regions = Region::all();
        $artists = Artist::orderBy('name')->get();
        $categories = \App\Models\ArtistCategory::all();
        
        return view('admin.movie.create', compact('genres', 'regions', 'artists', 'categories'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'release_date' => $this->normalizeReleaseDate($request->input('release_date'), $request->boolean('is_release_year_only')),
            'duration' => $this->normalizeDuration($request->input('duration')),
        ]);

        $validatedData = $request->validate(rules: [
            'title' => 'required|max:255',
            'description' => 'nullable',
            'release_date' => 'nullable|date',
            'duration' => 'nullable|date_format:H:i:s',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'exists:genres,id',

            'director' => 'nullable|string',
            'trailer_url' => 'nullable|string',
            'region_id' => 'nullable|exists:regions,id',
            'cbfc' => 'nullable|string',
            'cg_chartbusters_ratings' => 'nullable|integer',
            'dop' => 'nullable|string',
            'poster_logo' => 'nullable|string',
            // 'imdb_ratings' => 'nullable|integer',
            // 'cinematographer' => 'nullable|string',
            // 'screen_play' => 'nullable|string',
            // 'writer_story_concept' => 'nullable|string',
            // 'male_lead' => 'nullable|string',
            // 'female_lead' => 'nullable|string',
            // 'support_artists' => 'nullable|string',
            // 'production_banner' => 'nullable|string',
            // 'producer' => 'nullable|string',
            // 'songs' => 'nullable|string',
            // 'singer_male' => 'nullable|string',
            // 'singer_female' => 'nullable|string',
            // 'lyrics' => 'nullable|string',
            // 'composition' => 'nullable|string',
            // 'mix_master' => 'nullable|string',
            // 'music' => 'nullable|string',
            // 'recordists' => 'nullable|string',
            // 'audio_studio' => 'nullable|string',
            // 'editor' => 'nullable|string',
            // 'video_studio' => 'nullable|string',
            // 'vfx' => 'nullable|string',
            // 'make_up' => 'nullable|string',
            // 'drone' => 'nullable|string',
            // 'others' => 'nullable|string',
            'content_description' => 'nullable|string',
            'content_description_chh' => 'nullable|string',
            'hyperlinks_links' => 'nullable|string',
            'poster_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'poster_image_landscape' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'show_on_banner' => 'nullable',
            'banner_label' => 'nullable|string|max:255',
            'banner_link' => 'nullable|url',
            'is_release_year_only' => 'nullable|boolean',
            'artists' => 'nullable|array',
            'artists.*.artist_id' => 'exists:artists,id',
            'artists.*.role' => 'exists:artist_category,id'  
            // Add more validation rules as needed
        ]);

        
        if ($request->hasFile('poster_image')) {
            try {
            $path = $request->poster_image->store('posters', 'public');
            $validatedData['poster_image'] = $path;
            } catch (\Exception $e) {
            \Log::error('Poster image upload failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to upload poster image. Please try again.');
            }
        }
        if ($request->hasFile('poster_image_landscape')) {
            try {
                $path = $request->poster_image_landscape->store('posters_landscape', 'public');
                $validatedData['poster_image_landscape'] = $path;
            } catch (\Exception $e) {
                \Log::error('Poster image Landscape upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload poster image. Please try again.');
            }
        }

         // Remove artists array from validated data
         $artists = $validatedData['artists'] ?? [];
         unset($validatedData['artists']);


        // Create the movie
        $genreIds = $validatedData['genre_ids'] ?? [];
        unset($validatedData['genre_ids']);

        $movie = Movie::create($validatedData);
        $movie->genres()->sync($genreIds);

        // Prepare artist data for attachment
        $artistData = [];
        $artists = $request->input('artists', []);
        foreach ($artists as $artistEntry) {
            if (!empty($artistEntry['artist_id'])) {
                $artistId = $artistEntry['artist_id'];
                $roleId = $artistEntry['role'] ?? null;
                
                if ($roleId) {
                    if (!isset($artistData[$artistId])) {
                        $artistData[$artistId] = ['artist_category_ids' => []];
                    }
                    if (!in_array($roleId, $artistData[$artistId]['artist_category_ids'])) {
                        $artistData[$artistId]['artist_category_ids'][] = (int)$roleId;
                    }
                }
            }
        }

        $movie->artists()->sync($artistData);


        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie created successfully.');
    }

    public function show(Movie $movie)
    {
        
        return view('admin.movie.show', compact('movie'));
    }

    public function edit(Movie $movie)
    {
        $genres = Genre::where('for', 'Movies')->get();
        $regions = Region::all();
        $artists = Artist::orderBy('name')->get();
        $categories = \App\Models\ArtistCategory::all();
        
        return view('admin.movie.edit', compact('movie', 'genres', 'regions', 'artists', 'categories'));
    }


    public function update(Request $request, Movie $movie)
    {
        $request->merge([
            'release_date' => $this->normalizeReleaseDate($request->input('release_date'), $request->boolean('is_release_year_only')),
            'duration' => $this->normalizeDuration($request->input('duration')),
        ]);

        $validatedData = $request->validate(rules: [
            'title' => 'required|max:255',
            'description' => 'nullable',
            'release_date' => 'nullable|date',
            'duration' => 'nullable|date_format:H:i:s',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'exists:genres,id',

            // 'director' => 'nullable|string',
            'poster_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'trailer_url' => 'nullable|string',
            'region_id' => 'nullable|exists:regions,id',
            'cbfc' => 'nullable|string',
            'cg_chartbusters_ratings' => 'nullable|integer',
            'poster_logo' => 'nullable|string',
            // 'imdb_ratings' => 'nullable|integer',
            // 'cinematographer' => 'nullable|string',
            // 'dop' => 'nullable|string',
            // 'screen_play' => 'nullable|string',
            // 'writer_story_concept' => 'nullable|string',
            // 'male_lead' => 'nullable|string',
            // 'female_lead' => 'nullable|string',
            // 'support_artists' => 'nullable|string',
            // 'production_banner' => 'nullable|string',
            // 'producer' => 'nullable|string',
            // 'songs' => 'nullable|string',
            // 'singer_male' => 'nullable|string',
            // 'singer_female' => 'nullable|string',
            // 'lyrics' => 'nullable|string',
            // 'composition' => 'nullable|string',
            // 'mix_master' => 'nullable|string',
            // 'music' => 'nullable|string',
            // 'recordists' => 'nullable|string',
            // 'audio_studio' => 'nullable|string',
            // 'editor' => 'nullable|string',
            // 'video_studio' => 'nullable|string',
            // 'vfx' => 'nullable|string',
            // 'make_up' => 'nullable|string',
            // 'drone' => 'nullable|string',
            // 'others' => 'nullable|string',
            'content_description' => 'nullable|string',
            'content_description_chh' => 'nullable|string',
            'hyperlinks_links' => 'nullable|string',
            'poster_image_landscape' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'show_on_banner' => 'nullable',
            'banner_label' => 'nullable|string|max:255',
            'banner_link' => 'nullable|url',
            'is_release_year_only' => 'nullable|boolean',
            'artists' => 'nullable|array',
            'artists.*.artist_id' => 'exists:artists,id',
            'artists.*.role' => 'exists:artist_category,id' 
            // Add more validation rules as needed
        ]);

        if ($request->hasFile('poster_image')) {
            try {
            $path = $request->poster_image->store('posters', 'public');
            $validatedData['poster_image'] = $path;
            } catch (\Exception $e) {
            \Log::error('Poster image upload failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to upload poster image. Please try again.');
            }
        }
        if ($request->hasFile('poster_image_landscape')) {
            try {
                $path = $request->poster_image_landscape->store('posters_landscape', 'public');
                $validatedData['poster_image_landscape'] = $path;
            } catch (\Exception $e) {
                \Log::error('Poster image Landscape upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload poster image. Please try again.');
            }
        }

        $artists = $request->input('artists', []);
        $artistData = [];
        foreach ($artists as $artistEntry) {
            if (!empty($artistEntry['artist_id'])) {
                $artistId = $artistEntry['artist_id'];
                $roleId = $artistEntry['role'] ?? null;
                
                if ($roleId) {
                    if (!isset($artistData[$artistId])) {
                        $artistData[$artistId] = ['artist_category_ids' => []];
                    }
                    if (!in_array($roleId, $artistData[$artistId]['artist_category_ids'])) {
                        $artistData[$artistId]['artist_category_ids'][] = (int)$roleId;
                    }
                }
            }
        }

        // Log raw input for debugging
        \Log::debug('Movie Artist Sync - Raw Input:', ['artists' => $request->input('artists')]);

        // Grouping logic (already correct, but let's double check it in logs)
        \Log::debug('Movie Artist Sync - Grouped Data:', ['artistData' => $artistData]);
        
        // Sync without manual json_encode to see if ArtistMediaPivot's $casts handles it
        // Actually, the pivot model cast ONLY works if Laravel is aware of it during sync.
        // It's safer to pass the array to sync() IF we trust Laravel, but let's try passing it as array first.
        $movie->artists()->sync($artistData);
        
         // Update movie
         $genreIds = $validatedData['genre_ids'] ?? [];
         unset($validatedData['genre_ids']);
         unset($validatedData['artists']);
         
         $movie->update($validatedData);
         
         $movie->genres()->sync($genreIds);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie updated successfully');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie deleted successfully');
    }
}
