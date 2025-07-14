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
        return view('admin.movie.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(rules: [
            'title' => 'required|max:255',
            'description' => 'nullable',
            'release_date' => 'nullable|date',
            'genre' => 'nullable|string',
            'duration' => 'nullable|string',
            'director' => 'nullable|string',
            'trailer_url' => 'nullable|string',
            'region' => 'nullable|string',
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
            // 'content_description' => 'nullable|string',
            'hyperlinks_links' => 'nullable|string',
            'poster_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'poster_image_landscape' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'show_on_banner' => 'nullable',
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
        $movie = Movie::create($validatedData);

        // Prepare artist data for attachment
        $artistData = [];
        foreach ($artists as $artistEntry) {
            if (!empty($artistEntry['artist_id'])) {
                // Create a new entry for each artist-role combination
                $artistId = $artistEntry['artist_id'];
                $movie->artists()->attach($artistId, [
                    'artist_category_id' => $artistEntry['role'] ?? null,
                    'role' => $artistEntry['role'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        // Attach artists with their roles
        $movie->artists()->attach($artistData);


        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie created successfully.');
    }

    public function show(Movie $movie)
    {
        
        return view('admin.movie.show', compact('movie'));
    }

    public function edit(Movie $movie)
    {
        return view('admin.movie.edit', [
            'movie' => $movie,
            'genres' => Genre::where('for', 'Movies')->get(),
            'singer_male' => Artist::singerMale()->get(),
            'singer_female' => Artist::singerFemale()->get()
        ]);
    }


    public function update(Request $request, Movie $movie)
    {
        $validatedData = $request->validate(rules: [
            'title' => 'required|max:255',
            'description' => 'nullable',
            'release_date' => 'nullable|date',
            'genre' => 'nullable|string',
            'duration' => 'nullable|string',
            // 'director' => 'nullable|string',
            'poster_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'trailer_url' => 'nullable|string',
            'region' => 'nullable|string',
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
            // 'content_description' => 'nullable|string',
            'hyperlinks_links' => 'nullable|string',
            'poster_image_landscape' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'show_on_banner' => 'nullable',
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

        $artistData = [];
        foreach ($validatedData['artists'] ?? [] as $artistEntry) {
            if (!empty($artistEntry['artist_id'])) {
                // Instead of using artist_id as the key, we'll add each entry as a separate array item
                $artistData[] = [
                    'artist_id' => $artistEntry['artist_id'],
                    'artist_category_id' => $artistEntry['role'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Use syncWithoutDetaching and attach methods instead of sync
        $movie->artists()->detach();
        foreach ($artistData as $data) {
            $artist_id = $data['artist_id'];
            unset($data['artist_id']); // Remove artist_id from the pivot data
            $movie->artists()->attach($artist_id, $data);
        }
        
         // Update movie
         unset($validatedData['artists']);
        $movie->update($validatedData);

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
