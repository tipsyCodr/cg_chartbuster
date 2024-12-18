<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        $artists = Artist::latest()->get();
        $albums = Album::latest()->paginate(10);
        return view('admin.album.index', compact('albums', 'artists'));
    }

    public function create()
    {
        return view('admin.album.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'genre' => 'nullable|string',
            'release_date' => 'nullable|date',
            'artist_id' => 'nullable',
        ]);
        // Convert artist_id array to JSON
        $validatedData['artist_id'] = json_encode($request->input('artist_id', []));

        $album = Album::create($validatedData);

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album created successfully.');
    }

    public function edit(Album $album)
    {
        $artists = Artist::latest()->get();
        $artist_ids = $album->artist_id ? json_decode($album->artist_id) : [];
        $artist_names = [];
        foreach ($artist_ids as $id) {
            $artist = Artist::find($id);
            $artist_names[] = $artist->name;
        }
        // dd($artist_ids);
        return view('admin.album.edit', compact('album', 'artists', 'artist_names'));
    }

    public function update(Request $request, Album $album)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'release_year' => 'nullable|integer',
            'artist' => 'nullable|max:255',
        ]);

        $album->update($validatedData);

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album updated successfully');
    }

    public function destroy(Album $album)
    {
        $album->delete();

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album deleted successfully');
    }
}
