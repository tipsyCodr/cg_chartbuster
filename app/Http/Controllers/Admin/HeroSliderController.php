<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use App\Models\Movie;
use App\Models\Song;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSliderController extends Controller
{
    public function index()
    {
        $manual_sliders = HeroSlider::orderBy('sort_order')->get()->map(function($item) {
            $item->item_type = 'Manual';
            $item->edit_url = route('admin.hero-sliders.edit', $item);
            $item->display_title = $item->title;
            $item->display_image = $item->image;
            return $item;
        });

        $movies = Movie::where('show_on_banner', true)->get()->map(function($item) {
            $item->item_type = 'Movie';
            $item->edit_url = route('admin.movies.edit', $item) . '#promotions';
            $item->display_title = $item->title;
            $item->display_image = $item->poster_image_landscape;
            $item->is_active = true; // Banners are active if show_on_banner is true
            return $item;
        });

        $songs = Song::where('show_on_banner', true)->get()->map(function($item) {
            $item->item_type = 'Song';
            $item->edit_url = route('admin.songs.edit', $item) . '#promotions';
            $item->display_title = $item->title;
            $item->display_image = $item->poster_image_landscape;
            $item->is_active = true;
            return $item;
        });

        $tvshows = TvShow::where('show_on_banner', true)->get()->map(function($item) {
            $item->item_type = 'TV Show';
            $item->edit_url = route('admin.tvshows.edit', $item) . '#promotions';
            $item->display_title = $item->title;
            $item->display_image = $item->poster_image_landscape;
            $item->is_active = true;
            return $item;
        });

        $sliders = collect($manual_sliders)
            ->concat($movies)
            ->concat($songs)
            ->concat($tvshows);

        return view('admin.hero-sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.hero-sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'sort_order' => 'integer',
        ]);

        $path = $request->file('image')->store('hero-sliders', 'public');

        HeroSlider::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $path,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.hero-sliders.index')->with('success', 'Hero Slider created successfully.');
    }

    public function edit(HeroSlider $heroSlider)
    {
        return view('admin.hero-sliders.edit', compact('heroSlider'));
    }

    public function update(Request $request, HeroSlider $heroSlider)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'sort_order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            if ($heroSlider->image) {
                Storage::disk('public')->delete($heroSlider->image);
            }
            $path = $request->file('image')->store('hero-sliders', 'public');
            $heroSlider->image = $path;
        }

        $heroSlider->title = $request->title;
        $heroSlider->subtitle = $request->subtitle;
        $heroSlider->button_text = $request->button_text;
        $heroSlider->button_link = $request->button_link;
        $heroSlider->is_active = $request->has('is_active');
        $heroSlider->sort_order = $request->sort_order ?? 0;
        $heroSlider->save();

        return redirect()->route('admin.hero-sliders.index')->with('success', 'Hero Slider updated successfully.');
    }

    public function destroy(HeroSlider $heroSlider)
    {
        if ($heroSlider->image) {
            Storage::disk('public')->delete($heroSlider->image);
        }
        $heroSlider->delete();

        return redirect()->route('admin.hero-sliders.index')->with('success', 'Hero Slider deleted successfully.');
    }
}
