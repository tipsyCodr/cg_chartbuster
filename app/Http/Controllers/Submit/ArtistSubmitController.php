<?php

namespace App\Http\Controllers\Submit;

use App\Http\Controllers\Controller;
use App\Models\ArtistCategory;
use App\Models\ArtistSubmission;
use Illuminate\Http\Request;

class ArtistSubmitController extends Controller
{
    private function normalizeReleaseDate(?string $value, bool $yearOnly): ?string
    {
        if (blank($value)) return null;
        $value = trim($value);
        if ($yearOnly && preg_match('/^\d{4}$/', $value)) {
            return $value . '-01-01';
        }
        return $value;
    }

    public function create()
    {
        $categories = ArtistCategory::all();
        return view('submissions.artist.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'birth_date'  => $this->normalizeReleaseDate($request->input('birth_date'), $request->boolean('is_release_year_only')),
            'is_featured' => $request->boolean('is_featured'),
            'is_verified' => $request->boolean('is_verified'),
        ]);

        $validated = $request->validate([
            'name'                 => 'required|max:255',
            'photo'                => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'category'             => 'nullable',
            'cgcb_rating'          => 'nullable',
            'bio'                  => 'nullable',
            'bio_hi'               => 'nullable',
            'bio_chh'              => 'nullable',
            'birth_date'           => 'nullable|date',
            'city'                 => 'nullable|max:255',
            'is_release_year_only' => 'nullable|boolean',
            'banner_image'         => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'founded_year'         => 'nullable|integer',
            'owner_name'           => 'nullable|string|max:255',
            'active_since'         => 'nullable|integer',
            'website_url'          => 'nullable|string|max:255',
            'youtube_url'          => 'nullable|string|max:255',
            'instagram_url'        => 'nullable|string|max:255',
            'facebook_url'         => 'nullable|string|max:255',
            'twitter_url'          => 'nullable|string|max:255',
            'is_featured'          => 'nullable|boolean',
            'is_verified'          => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            try {
                $validated['photo'] = $request->photo->store('submissions/artists', 'public');
            } catch (\Exception $e) {
                \Log::error('Submission artist photo upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload photo. Please try again.');
            }
        }

        if ($request->hasFile('banner_image')) {
            try {
                $validated['banner_image'] = $request->banner_image->store('submissions/artists/banners', 'public');
            } catch (\Exception $e) {
                \Log::error('Submission artist banner upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload banner. Please try again.');
            }
        }

        ArtistSubmission::create(array_merge($validated, [
            'user_id' => auth()->id(),
            'status'  => 'pending',
        ]));

        return redirect()->route('submit.artist.create')
            ->with('success', 'Your artist submission has been received and is pending admin review. Thank you!');
    }
}
