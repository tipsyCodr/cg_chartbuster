<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TvShow;
use App\Models\Genre;
use App\Models\Artist;
use Illuminate\Http\Request;


class TvShowController extends Controller
{
    //
    public function index()
    {
        // Code to list all TV shows
        $tvShows = TvShow::latest()->paginate(5);
        $genres = Genre::where('for','Tv Shows')->get();
        $singer_male = Artist::singerMale()->get();
        $singer_female = Artist::singerFemale()->get();
        return view('admin.tvshows.index', compact('tvShows', 'genres', 'singer_male', 'singer_female'));
        
    }

    public function create()
    {
        // Code to show form to create a new TV show
    }

    public function store(Request $request, TvShow $tvShow )
    {
        // Code to save a new TV show
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
            'imdb_ratings' => 'nullable|integer',
            'cinematographer' => 'nullable|string',
            'dop' => 'nullable|string',
            'screen_play' => 'nullable|string',
            'writer_story_concept' => 'nullable|string',
            'male_lead' => 'nullable|string',
            'female_lead' => 'nullable|string',
            'support_artists' => 'nullable|string',
            'poster_logo' => 'nullable|string',
            'production_banner' => 'nullable|string',
            'producer' => 'nullable|string',
            'songs' => 'nullable|string',
            'singer_male' => 'nullable|string',
            'singer_female' => 'nullable|string',
            'lyrics' => 'nullable|string',
            'composition' => 'nullable|string',
            'mix_master' => 'nullable|string',
            'music' => 'nullable|string',
            'recordists' => 'nullable|string',
            'audio_studio' => 'nullable|string',
            'editor' => 'nullable|string',
            'video_studio' => 'nullable|string',
            'vfx' => 'nullable|string',
            'make_up' => 'nullable|string',
            'drone' => 'nullable|string',
            'others' => 'nullable|string',
            'content_description' => 'nullable|string',
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
        $tvShow = TvShow::create($validatedData);


         // Prepare artist data for attachment
         $artistData = [];
         foreach ($artists as $artistEntry) {
             if (!empty($artistEntry['artist_id'])) {
                 // Create a new entry for each artist-role combination
                 $artistId = $artistEntry['artist_id'];
                 $tvShow->artists()->attach($artistId, [
                     'artist_category_id' => $artistEntry['role'] ?? null,
                     'role' => $artistEntry['role'] ?? null,
                     'created_at' => now(),
                     'updated_at' => now(),
                 ]);
             }
         }
   

    
        return redirect()->route('admin.tvshows.index')
            ->with('success', 'TV Show created successfully.');
    }

    public function show($id)
    {
        // Code to display a specific TV show
    }

    public function edit($id)
    {
        // Code to show form to edit a TV show
        $tvshows = TvShow::findOrFail($id);
        $genres = Genre::where('for','Tv Shows')->get();
        $singer_male = Artist::singerMale()->get();
        $singer_female = Artist::singerFemale()->get();

        return view('admin.tvshows.edit', compact('tvshows', 'genres', 'singer_male', 'singer_female'));
    }

    public function update(Request $request, TvShow $tvShow)
    {
     
        // Explicitly fetch the model to ensure it's fully loaded and avoid potential route model binding issues
        $tvShow = TvShow::findOrFail($request->route('tvshow'));
        
       
        $validatedData = $request->validate([
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
            'imdb_ratings' => 'nullable|integer',
            'cinematographer' => 'nullable|string',
            'dop' => 'nullable|string',
            'screen_play' => 'nullable|string',
            'writer_story_concept' => 'nullable|string',
            'male_lead' => 'nullable|string',
            'female_lead' => 'nullable|string',
            'support_artists' => 'nullable|string',
            'poster_logo' => 'nullable|string',
            'production_banner' => 'nullable|string',
            'producer' => 'nullable|string',
            'songs' => 'nullable|string',
            'singer_male' => 'nullable|string',
            'singer_female' => 'nullable|string',
            'lyrics' => 'nullable|string',
            'composition' => 'nullable|string',
            'mix_master' => 'nullable|string',
            'music' => 'nullable|string',
            'recordists' => 'nullable|string',
            'audio_studio' => 'nullable|string',
            'editor' => 'nullable|string',
            'video_studio' => 'nullable|string',
            'vfx' => 'nullable|string',
            'make_up' => 'nullable|string',
            'drone' => 'nullable|string',
            'others' => 'nullable|string',
            'content_description' => 'nullable|string',
            'hyperlinks_links' => 'nullable|string',
            'poster_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'poster_image_landscape' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'show_on_banner' => 'nullable',
            'artists' => 'nullable|array',
            'artists.*.artist_id' => 'exists:artists,id',
            'artists.*.role' => 'exists:artist_category,id',
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
            $tvShow->artists()->detach();
            foreach ($artistData as $data) {
                $artist_id = $data['artist_id'];
                unset($data['artist_id']); // Remove artist_id from the pivot data
                $tvShow->artists()->attach($artist_id, $data);
            }

        try {
            // Explicitly convert show_on_banner to boolean
            $validatedData['show_on_banner'] = filter_var($validatedData['show_on_banner'], FILTER_VALIDATE_BOOLEAN);
            
            
            $updateResult = $tvShow->update($validatedData);
            \Log::info('Update Result:', ['success' => $updateResult, 'tvShow' => $tvShow->toArray()]);
            
            if (!$updateResult) {
                \Log::error('Update Failed: No changes detected or update unsuccessful', [
                    'validatedData' => $validatedData,
                    'currentModelData' => $tvShow->getAttributes(),
                    'originalModelData' => $tvShow->getOriginal()
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('TV Show Update Failed: ' . $e->getMessage(), [
                'exception' => [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ],
                'validatedData' => $validatedData
            ]);
            return redirect()->back()->with('error', 'Failed to update TV Show. ' . $e->getMessage());
        }

        return redirect()->route('admin.tvshows.index')
            ->with('success', 'TV Show updated successfully.');
    }

    public function destroy(TvShow $tvshow)
    {
        $tvshow->delete();

        return redirect()->route('admin.tvshows.index')
            ->with('success', 'TV Show deleted successfully');
    }
}
