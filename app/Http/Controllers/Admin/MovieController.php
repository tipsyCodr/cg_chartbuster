<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::latest()->paginate(5);
        return view('admin.movie.index', compact('movies'));
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
            'poster_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
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
        $movie = Movie::create($validatedData);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie created successfully.');
    }

    public function show(Movie $movie)
    {
        return view('admin.movie.show', compact('movie'));
    }

    public function edit(Movie $movie)
    {
        return view('admin.movie.edit', compact('movie'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validatedData = $request->validate(rules: [
            'title' => 'required|max:255',
            'description' => 'nullable',
            'release_date' => 'nullable|date',
            'genre' => 'nullable|string',
            'duration' => 'nullable|string',
            'director' => 'nullable|string',
            'poster_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
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
