<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductionHouse;
use App\Models\ArtistCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductionHouseController extends Controller
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
        return view('admin.production-house.index');
    }

    public function create()
    {
        return view('admin.production-house.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'birth_date' => $this->normalizeReleaseDate($request->input('birth_date'), $request->boolean('is_release_year_only')),
            'is_featured' => $request->boolean('is_featured'),
            'is_verified' => $request->boolean('is_verified'),
        ]);

        $validatedData = $request->validate([
            'photo' => 'required|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'name' => 'required|max:255',
            'cgcb_rating' => 'nullable',
            'bio' => 'nullable',
            'bio_hi' => 'nullable',
            'bio_chh' => 'nullable',
            'birth_date' => 'nullable|date',
            'city' => 'nullable|max:255',
            'is_release_year_only' => 'nullable|boolean',
            'banner_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'founded_year' => 'nullable|integer',
            'owner_name' => 'nullable|string|max:255',
            'active_since' => 'nullable|integer',
            'website_url' => 'nullable|string|max:255',
            'youtube_url' => 'nullable|string|max:255',
            'instagram_url' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|string|max:255',
            'twitter_url' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
            'is_verified' => 'nullable|boolean',
        ]);

        // Automatically assign 'Production House' category
        $category = ArtistCategory::where('slug', 'production-house')->first();
        if ($category) {
            $validatedData['category'] = [(string) $category->id];
        }

        // Generate slug
        $validatedData['slug'] = Str::slug($validatedData['name']);

        if ($request->hasFile('photo')) {
            try {
                $path = $request->photo->store('artists', 'public');
                $validatedData['photo'] = $path;
            } catch (\Exception $e) {
                \Log::error('Production House photo upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload logo/photo. Please try again.');
            }
        }

        if ($request->hasFile('banner_image')) {
            try {
                $path = $request->banner_image->store('artists/banners', 'public');
                $validatedData['banner_image'] = $path;
            } catch (\Exception $e) {
                \Log::error('Production House banner upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload banner image. Please try again.');
            }
        }

        ProductionHouse::create($validatedData);

        return redirect()->route('admin.productionhouses.index')
            ->with('success', 'Production House created successfully.');
    }

    public function edit($id)
    {
        $productionHouse = ProductionHouse::findOrFail($id);
        return view('admin.production-house.edit', compact('productionHouse'));
    }

    public function update(Request $request, $id)
    {
        $productionHouse = ProductionHouse::findOrFail($id);

        $request->merge([
            'birth_date' => $this->normalizeReleaseDate($request->input('birth_date'), $request->boolean('is_release_year_only')),
            'is_featured' => $request->boolean('is_featured'),
            'is_verified' => $request->boolean('is_verified'),
        ]);

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'bio' => 'nullable',
            'bio_hi' => 'nullable',
            'bio_chh' => 'nullable',
            'cgcb_rating' => 'nullable',
            'birth_date' => 'nullable|date',
            'city' => 'nullable|max:255',
            'is_release_year_only' => 'nullable|boolean',
            'banner_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'founded_year' => 'nullable|integer',
            'owner_name' => 'nullable|string|max:255',
            'active_since' => 'nullable|integer',
            'website_url' => 'nullable|string|max:255',
            'youtube_url' => 'nullable|string|max:255',
            'instagram_url' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|string|max:255',
            'twitter_url' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
            'is_verified' => 'nullable|boolean',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);

        if ($request->hasFile('photo')) {
            try {
                $path = $request->photo->store('artists', 'public');
                $validatedData['photo'] = $path;
            } catch (\Exception $e) {
                \Log::error('Production House photo upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload photo. Please try again.');
            }
        }

        if ($request->hasFile('banner_image')) {
            try {
                $path = $request->banner_image->store('artists/banners', 'public');
                $validatedData['banner_image'] = $path;
            } catch (\Exception $e) {
                \Log::error('Production House banner upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload banner image. Please try again.');
            }
        }

        $productionHouse->update($validatedData);

        return redirect()->route('admin.productionhouses.index')
            ->with('success', 'Production House updated successfully');
    }

    public function destroy($id)
    {
        $productionHouse = ProductionHouse::findOrFail($id);
        $productionHouse->delete();

        return redirect()->route('admin.productionhouses.index')
            ->with('success', 'Production House deleted successfully');
    }
}
