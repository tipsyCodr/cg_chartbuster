<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\ArtistCategory;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index()
    {   
        $category = ArtistCategory::all();
        $artists = Artist::latest()->paginate(10);
        return view('admin.artist.index', compact('artists', 'category'));
    }
    public function list()
    {   
        // return Artist::select('id', 'name')->get();
        $data = [
            'artists' => Artist::select('id', 'name')->get(),
            'categories' => ArtistCategory::select('id', 'name')->get()
        ];
        return response()->json($data);
    }
    public function create()
    {
        return view('admin.artist.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'photo' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'name' => 'required|max:255',
            'category' => 'nullable',
            'bio' => 'nullable',
            'birth_date' => 'nullable',
            'city' => 'nullable|max:255',
        ]);

        if ($request->hasFile('photo')) {
            try {
                $path = $request->photo->store('artists', 'public');
                $validatedData['photo'] = $path;
            } catch (\Exception $e) {
                \Log::error('Artist photo upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload artist photo. Please try again.');
            }
        }

        $artist = Artist::create($validatedData);

        return redirect()->route('admin.artists.index')
            ->with('success', 'Artist created successfully.');
    }

    public function edit(Artist $artist)
    {
        $category = ArtistCategory::all();
        return view('admin.artist.edit', compact('artist','category'));
    }

    public function update(Request $request, Artist $artist)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category' => 'nullable',
            'bio' => 'nullable',
            'genre' => 'nullable|max:255',
            'birth_date' => 'nullable',
            'city' => 'nullable|max:255',
        ]);

        if ($request->hasFile('photo')) {
            try {
                $path = $request->photo->store('artists', 'public');
                $validatedData['photo'] = $path;
            } catch (\Exception $e) {
                \Log::error('Artist photo upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload artist photo. Please try again.');
            }
        }

        $artist->update($validatedData);

        return redirect()->route('admin.artists.index')
            ->with('success', 'Artist updated successfully');
    }

    public function destroy(Artist $artist)
    {
        $artist->delete();

        return redirect()->route('admin.artists.index')
            ->with('success', 'Artist deleted successfully');
    }
}
