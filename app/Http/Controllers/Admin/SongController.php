<?php

namespace App\Http\Controllers\Admin;

use App\Models\Song;
use App\Models\Genre;
use App\Models\Artist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SongController extends Controller
{
    public function index()
    {
        $genres = Genre::where('for', 'Songs')->get();
        $songs = Song::latest()->paginate(5);
        $singer_male = Artist::singerMale()->get();
        $singer_female = Artist::singerFemale()->get();
        return view('admin.songs.index', compact('songs', 'genres', 'singer_male', 'singer_female'));
    }



    public function store(Request $request)
    {
        // Step 1: Validate input
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
            'production_banner' => 'nullable|string',
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
            'artists' => 'nullable|array',
            'artists.*.artist_id' => 'exists:artists,id',
            'artists.*.role' => 'exists:artist_category,id',
        ]);

        // Step 2: Handle file uploads
        $fileFields = [
            'poster_image' => 'posters',
            'poster_image_landscape' => 'posters_landscape',
        ];

        foreach ($fileFields as $field => $folder) {
            if ($request->hasFile($field)) {
                try {
                    $path = $request->file($field)->store($folder, 'public');
                    $validatedData[$field] = $path;
                } catch (\Exception $e) {
                    \Log::error(ucwords(str_replace('_', ' ', $field)) . ' upload failed: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Failed to upload ' . str_replace('_', ' ', $field) . '. Please try again.');
                }
            }
        }

        // Step 3: Store in DB within a transaction
        DB::beginTransaction();
        try {
            $artists = $validatedData['artists'] ?? [];
            unset($validatedData['artists']);

            $song = Song::create($validatedData);

            foreach ($artists as $artistEntry) {
                if (!empty($artistEntry['artist_id'])) {
                    $song->artists()->attach($artistEntry['artist_id'], [
                        'artist_category_id' => $artistEntry['role'] ?? null,
                        'role' => $artistEntry['role'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.songs.index')->with('success', 'Song created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Song creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create song. Please try again.');
        }
    }




    public function edit($id)
    {
        $songs = Song::findOrFail($id);
        $genres = Genre::where('for', 'Songs')->get();
        $singer_male = Artist::singerMale()->get();
        $singer_female = Artist::singerFemale()->get();
        return view('admin.songs.edit', compact('songs', 'genres', 'singer_male', 'singer_female'));
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
            'artists' => 'nullable|array',
            'artists.*.artist_id' => 'exists:artists,id',
            'artists.*.role' => 'exists:artist_category,id',
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
        $song->artists()->detach();
        foreach ($artistData as $data) {
            $artist_id = $data['artist_id'];
            unset($data['artist_id']); // Remove artist_id from the pivot data
            $song->artists()->attach($artist_id, $data);
        }


        $song->update($validatedData);

        return redirect()->route('admin.songs.index')->with('success', 'Song updated successfully.');
    }

    public function destroy(Song $song)
    {
        $song->delete();

        return redirect()->route('admin.songs.index')->with('success', 'Song deleted successfully.');
    }
}