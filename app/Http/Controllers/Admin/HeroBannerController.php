<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroBannerController extends Controller
{
    public function index()
    {
        $banners = HeroBanner::orderBy('sort_order')->get();
        return view('admin.hero-banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.hero-banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'link_url' => 'nullable|url',
            'sort_order' => 'integer',
        ]);

        $path = $request->file('image')->store('hero-banners', 'public');

        HeroBanner::create([
            'image_path' => $path,
            'link_url' => $request->link_url,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.hero-banners.index')->with('success', 'Hero Banner created successfully.');
    }

    public function edit(HeroBanner $heroBanner)
    {
        return view('admin.hero-banners.edit', compact('heroBanner'));
    }

    public function update(Request $request, HeroBanner $heroBanner)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'link_url' => 'nullable|url',
            'sort_order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($heroBanner->image_path);
            $path = $request->file('image')->store('hero-banners', 'public');
            $heroBanner->image_path = $path;
        }

        $heroBanner->link_url = $request->link_url;
        $heroBanner->is_active = $request->has('is_active');
        $heroBanner->sort_order = $request->sort_order ?? 0;
        $heroBanner->save();

        return redirect()->route('admin.hero-banners.index')->with('success', 'Hero Banner updated successfully.');
    }

    public function destroy(HeroBanner $heroBanner)
    {
        Storage::disk('public')->delete($heroBanner->image_path);
        $heroBanner->delete();

        return redirect()->route('admin.hero-banners.index')->with('success', 'Hero Banner deleted successfully.');
    }
}
