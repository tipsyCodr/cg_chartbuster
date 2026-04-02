<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\ArtistCategory;
use Illuminate\Http\Request;

class ArtistController extends Controller
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

    public function index()
    {
        $category = ArtistCategory::all()->map(function($cat) {
            $cat->setAttribute('artist_count', Artist::whereJsonContains('category', (string)$cat->id)->count());
            return $cat;
        });
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
        $categories = ArtistCategory::all();
        return view('admin.artist.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'birth_date' => $this->normalizeReleaseDate($request->input('birth_date'), $request->boolean('is_release_year_only')),
        ]);

        $validatedData = $request->validate([
            'photo' => 'required|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'name' => 'required|max:255',
            'category' => 'nullable',
            'cgcb_rating' => 'nullable',
            'bio' => 'nullable',
            'bio_hi' => 'nullable',
            'bio_chh' => 'nullable',
            'birth_date' => 'nullable|date',
            'city' => 'nullable|max:255',
            'is_release_year_only' => 'nullable|boolean',
        ]);
        // $validatedData['category'] = json_encode($validatedData['category']);
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
        $category = ArtistCategory::all()->map(function($cat) {
            $cat->setAttribute('artist_count', Artist::whereJsonContains('category', (string)$cat->id)->count());
            return $cat;
        });
        return view('admin.artist.edit', compact('artist', 'category'));
    }

    public function update(Request $request, Artist $artist)
    {
        $request->merge([
            'birth_date' => $this->normalizeReleaseDate($request->input('birth_date'), $request->boolean('is_release_year_only')),
        ]);

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category' => 'nullable',
            'bio' => 'nullable',
            'bio_hi' => 'nullable',
            'bio_chh' => 'nullable',
            'cgcb_rating' => 'nullable',
            'birth_date' => 'nullable|date',
            'city' => 'nullable|max:255',
            'is_release_year_only' => 'nullable|boolean',
        ]);

        // dd($validatedData);
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
