<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Models\Genre;
use Illuminate\Http\Request;

class SongController extends Controller{
    //
public function index()
{
    $genres = Genre::where('for','Songs')->get();
    $songs = Song::latest()->paginate(5);
    return view('admin.songs.index', compact('songs','genres'));
}


public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'release_date' => 'nullable|date',
        'genre' => 'nullable|string|max:255',
        'duration' => 'nullable|string|max:255',
        'director' => 'nullable|string|max:255',
        'album' => 'nullable|string|max:255',
        'poster_logo' => 'nullable|string',
        'trailer_url' => 'nullable|string',
        'region' => 'nullable|string|max:255',
        'cg_chartbusters_ratings' => 'nullable|numeric',
        'imdb_ratings' => 'nullable|numeric',
        'poster_logo' => 'nullable|string',
        'production_banner' => 'nullable|string',
        'artists' => 'nullable|string|max:255',
        'support_artists' => 'nullable|string|max:255',
        'producer' => 'nullable|string|max:255',
        'singer_male' => 'nullable|string|max:255',
        'singer_female' => 'nullable|string|max:255',
        'lyrics' => 'nullable|string|max:255',
        'composition' => 'nullable|string|max:255',
        'mix_master' => 'nullable|string|max:255',
        'music' => 'nullable|string|max:255',
        'recordists' => 'nullable|string|max:255',
        'audio_studio' => 'nullable|string|max:255',
        'editor' => 'nullable|string|max:255',
        'video_studio' => 'nullable|string|max:255',
        'vfx' => 'nullable|string|max:255',
        'make_up' => 'nullable|string|max:255',
        'drone' => 'nullable|string|max:255',
        'others' => 'nullable|string|max:255',
        'content_description' => 'nullable|string',
        'hyperlinks_links' => 'nullable|string',
        'poster_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
        'poster_image_landscape' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
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
    
    Song::create($validatedData);

    return redirect()->route('admin.songs.index')->with('success', 'Song created successfully.');
}



public function edit($id)
{
    $songs = Song::findOrFail($id);
    $genres = Genre::where('for','Songs')->get();
    return view('admin.songs.edit', compact('songs','genres'));
}

public function update(Request $request, Song $song)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'release_date' => 'nullable|date',
        'genre' => 'nullable|string|max:255',
        'duration' => 'nullable|string|max:255',
        'director' => 'nullable|string|max:255',
        'album' => 'nullable|string|max:255',
        'poster_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
        'trailer_url' => 'nullable|string',
        'region' => 'nullable|string|max:255',
        'cg_chartbusters_ratings' => 'nullable|numeric',
        'imdb_ratings' => 'nullable|numeric',
        'artists' => 'nullable|string|max:255',
        'support_artists' => 'nullable|string|max:255',
        'producer' => 'nullable|string|max:255',
        'poster_logo' => 'nullable|string',
        'production_banner' => 'nullable|string',
        'singer_male' => 'nullable|string|max:255',
        'singer_female' => 'nullable|string|max:255',
        'lyrics' => 'nullable|string|max:255',
        'composition' => 'nullable|string|max:255',
        'mix_master' => 'nullable|string|max:255',
        'music' => 'nullable|string|max:255',
        'recordists' => 'nullable|string|max:255',
        'audio_studio' => 'nullable|string|max:255',
        'editor' => 'nullable|string|max:255',
        'video_studio' => 'nullable|string|max:255',
        'vfx' => 'nullable|string|max:255',
        'make_up' => 'nullable|string|max:255',
        'drone' => 'nullable|string|max:255',
        'others' => 'nullable|string|max:255',
        'content_description' => 'nullable|string',
        'hyperlinks_links' => 'nullable|string',
        'poster_image_portrait' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
        'poster_image_landscape' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
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
    // if ($request->hasFile('production_banner')) {
    //     try {
    //         $path = $request->production_banner->store('banner', 'public');
    //         $validatedData['production_banner'] = $path;
    //     } catch (\Exception $e) {
    //         \Log::error('Production Banner upload failed: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'Failed to upload poster image. Please try again.');
    //     }
    // }
    // if ($request->hasFile('poster_logo')) {
    //     try {
    //         $path = $request->poster_logo->store('poster_logo', 'public');
    //         $validatedData['poster_logo'] = $path;
    //     } catch (\Exception $e) {
    //         \Log::error('Production Banner upload failed: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'Failed to upload poster image. Please try again.');
    //     }
    // }
    
    $song->update($validatedData);

    return redirect()->route('admin.songs.index')->with('success', 'Song updated successfully.');
}

public function destroy(Song $song)
{
    $song->delete();

    return redirect()->route('admin.songs.index')->with('success', 'Song deleted successfully.');
}
}