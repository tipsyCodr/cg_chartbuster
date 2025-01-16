<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TvShow;
use Illuminate\Http\Request;


class TvShowController extends Controller
{
    //
    public function index()
    {
        // Code to list all TV shows
        $tvShows = TvShow::latest()->paginate(5);
        return view('admin.tvshows.index', compact('tvShows'));
        
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
            'poster_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'trailer_url' => 'nullable|url',
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
            'production_banner' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
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
            'poster_logo' => 'nullable|string',
            'vfx' => 'nullable|string',
            'make_up' => 'nullable|string',
            'drone' => 'nullable|string',
            'others' => 'nullable|string',
            'content_description' => 'nullable|string',
            'hyperlinks_links' => 'nullable|string',
            'poster_image_landscape' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            // Add more validation rules as needed
        ]);

        // dd($validatedData);
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
        if ($request->hasFile('production_banner')) {
            try {
                $path = $request->production_banner->store('banner', 'public');
                $validatedData['production_banner'] = $path;
            } catch (\Exception $e) {
                \Log::error('Production Banner upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload poster image. Please try again.');
            }
        }
        if ($request->hasFile('poster_logo')) {
            try {
                $path = $request->poster_logo->store('poster_logo', 'public');
                $validatedData['poster_logo'] = $path;
            } catch (\Exception $e) {
                \Log::error('Production Banner upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload poster image. Please try again.');
            }
        }

        // Create the movie
        $tvShow = TvShow::create($validatedData);

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
        return view('admin.tvshows.edit', compact('tvshows'));
    }

    public function update(Request $request, TvShow $tvShow)
    {
        // Code to update a specific TV show
        $validatedData = $request->validate(rules: [
            'title' => 'required|max:255',
            'description' => 'nullable',
            'release_date' => 'nullable|date',
            'genre' => 'nullable|string',
            'duration' => 'nullable|string',
            'director' => 'nullable|string',
            'poster_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'trailer_url' => 'nullable|url',
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
            'production_banner' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
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
            'poster_logo' => 'nullable|string',
            'vfx' => 'nullable|string',
            'make_up' => 'nullable|string',
            'drone' => 'nullable|string',
            'others' => 'nullable|string',
            'content_description' => 'nullable|string',
            'hyperlinks_links' => 'nullable|string',
            'poster_image_landscape' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
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
        if ($request->hasFile('production_banner')) {
            try {
                $path = $request->production_banner->store('banner', 'public');
                $validatedData['production_banner'] = $path;
            } catch (\Exception $e) {
                \Log::error('Production Banner upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload poster image. Please try again.');
            }
        }
        if ($request->hasFile('poster_logo')) {
            try {
                $path = $request->poster_logo->store('poster_logo', 'public');
                $validatedData['poster_logo'] = $path;
            } catch (\Exception $e) {
                \Log::error('Production Banner upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload poster image. Please try again.');
            }
        }
        
        $tvShow->update($validatedData);

        return redirect()->route('admin.tvshows.index')
            ->with('success', 'TV Show updated successfully');
    }

    public function destroy(TvShow $tvshow)
    {
        $tvshow->delete();

        return redirect()->route('admin.tvshows.index')
            ->with('success', 'TV Show deleted successfully');
    }
}
