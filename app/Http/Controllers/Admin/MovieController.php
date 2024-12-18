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
            'trailer_url' => 'nullable|url',
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
            'trailer_url' => 'nullable|url',
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
