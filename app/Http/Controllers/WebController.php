<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\ArtistCategory;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\ProductionHouse;
use App\Models\Song;
use App\Models\TvShow;
use App\Models\HeroSlider;
use App\Models\HeroBanner;
use App\Models\PageView;
use Illuminate\Http\Request;

class WebController extends Controller
{
    //
    public function index()
    {
        $manual_sliders = HeroSlider::where('is_active', true)->orderBy('sort_order')->get()->map(function($slider) {
            return [
                'title' => $slider->title,
                'subtitle' => $slider->subtitle,
                'image' => $slider->image,
                'button_text' => $slider->button_text,
                'button_link' => $slider->button_link,
                'badge_link' => $slider->button_link,
                'type' => 'Featured',
                'rating' => null,
                'release_year' => null,
                'poster' => null,
                'badge' => null,
            ];
        });

        $media_banners = collect();
        
        $movies = Movie::where('show_on_banner', true)->get();
        foreach($movies as $movie) {
            $media_banners->push([
                'title' => preg_replace('/^\d+[\s.-]+/', '', $movie->title),
                'subtitle' => $movie->description,
                'image' => $movie->poster_image_landscape,
                'poster' => $movie->poster_image,
                'button_text' => 'View Details',
                'button_link' => route('movie.show', $movie->slug),
                'badge_link' => $movie->banner_link ?? route('movie.show', $movie->slug),
                'type' => 'Movie',
                'rating' => $movie->cg_chartbusters_ratings,
                'release_year' => $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('Y') : null,
                'badge' => $movie->banner_label,
            ]);
        }

        $songs = Song::where('show_on_banner', true)->get();
        foreach($songs as $song) {
            $media_banners->push([
                'title' => preg_replace('/^\d+[\s.-]+/', '', $song->title),
                'subtitle' => $song->description,
                'image' => $song->poster_image_landscape,
                'poster' => $song->poster_image,
                'button_text' => 'View Details',
                'button_link' => route('song.show', $song->slug),
                'badge_link' => $song->banner_link ?? route('song.show', $song->slug),
                'type' => 'Song',
                'rating' => $song->cg_chartbusters_ratings,
                'release_year' => $song->release_date ? \Carbon\Carbon::parse($song->release_date)->format('Y') : null,
                'badge' => $song->banner_label,
            ]);
        }

        $tvshows = TvShow::where('show_on_banner', true)->get();
        foreach($tvshows as $tvshow) {
            $media_banners->push([
                'title' => preg_replace('/^\d+[\s.-]+/', '', $tvshow->title),
                'subtitle' => $tvshow->description,
                'image' => $tvshow->poster_image_landscape,
                'poster' => $tvshow->poster_image,
                'button_text' => 'View Details',
                'button_link' => route('tv-show.show', $tvshow->slug),
                'badge_link' => $tvshow->banner_link ?? route('tv-show.show', $tvshow->slug),
                'type' => 'TV Show',
                'rating' => $tvshow->cg_chartbusters_ratings,
                'release_year' => $tvshow->release_date ? \Carbon\Carbon::parse($tvshow->release_date)->format('Y') : null,
                'badge' => $tvshow->banner_label,
            ]);
        }

        $hero_sliders = $manual_sliders->concat($media_banners)->filter(function($slider) {
            return !empty($slider['image']);
        });
        $hero_banners = HeroBanner::where('is_active', true)->orderBy('sort_order')->get();
        $banner_images = []; // Keep empty for backward compatibility if needed, but we'll use $hero_sliders primarily
        // dd($banner_images );
        $movies = Movie::orderByDesc('cg_chartbusters_ratings') // highest rating first
            ->take(10)                  // limit 10
            ->get(); 
        $songs = Song::orderByDesc('cg_chartbusters_ratings') // highest rating first
            ->take(10)                  // limit 10
            ->get();
        $tvshows = TvShow::orderByDesc('cg_chartbusters_ratings') // highest rating first
            ->take(10)                  // limit 10
            ->get();
        $artists = Artist::withCount('reviews')
            ->orderByDesc('cgcb_rating')
            ->take(10)
            ->get();
        return view('home', compact('movies', 'songs', 'tvshows', 'artists', 'banner_images', 'hero_banners', 'hero_sliders'));
    }

    public function dashboard()
    {
        $movies = Movie::all();
        $artists = Artist::all();
        return view('dashboard', compact('movies', 'artists'));
    }

    public function movies(Request $request)
    {
        $genre = $request->input('genre');

        $query = Movie::query();

        if ($genre) {
            $query->whereHas('genres', function($q) use ($genre) {
                $q->where('genres.id', $genre);
            });
        }

        $movies = $query
            ->with('genres')
            ->withCount('reviews')
            ->orderBy('release_date', 'desc')
            ->get();
        $genres = Genre::all()->where('for', 'Movies');

        return view('pages.movies.index', compact('movies', 'genres'));
    }

    public function movie($slug)
    {
        $movie = Movie::with(['artists', 'region', 'genres', 'productionHouse'])->where('slug', $slug)->firstOrFail();
        $movie->increment('views');
        $this->logPageView('movie', $movie->id);
        $reviews = $movie->reviews()->orderBy('created_at', 'asc')->paginate(15);
        return view('pages.movies.view', compact(['movie', 'reviews']));
    }


    public function tvShows(Request $request)
    {
        $genre = $request->input('genre');
        $tvshows = TvShow::query();

        if ($genre) {
            $tvshows->whereHas('genres', function($q) use ($genre) {
                $q->where('genres.id', $genre);
            });
        }

        $tvshows = $tvshows
            ->with('genres')
            ->withCount('reviews')
            ->orderBy('release_date', 'desc')
            ->get();
        $genres = Genre::all()->where('for', 'Tv Shows');
        return view('pages.tvshows.index', compact('tvshows', 'genres'));
    }

    public function tvShow($slug)
    {
        $tvshow = TvShow::with(['region', 'genres', 'productionHouse'])->where('slug', $slug)->firstOrFail();
        $tvshow->increment('views');
        $this->logPageView('tv_show', $tvshow->id);
        $reviews = $tvshow->reviews()->orderBy('created_at', 'asc')->paginate(15);
        return view('pages.tvshows.view', compact(['tvshow', 'reviews']));
    }


    public function songs(Request $request)
    {
        $genre = $request->input('genre');
        $query = Song::query();

        if ($genre) {
            $query->whereHas('genres', function($q) use ($genre) {
                $q->where('genres.id', $genre);
            });
        }

        $songs = $query
            ->with('genres')
            ->withCount('reviews')
            ->orderBy('release_date', 'desc')
            ->get();
        $genres = Genre::all()->where('for', 'Songs');
        return view('pages.songs.index', compact('songs', 'genres'));
    }

    public function song($slug)
    {
        $song = Song::with(['region', 'genres', 'productionHouse'])->where('slug', $slug)->firstOrFail();
        $song->increment('views');
        $this->logPageView('song', $song->id);
        $reviews = $song->reviews()->orderBy('created_at', 'asc')->paginate(15);
        return view('pages.songs.view', compact(['song', 'reviews']));
    }

    public function artists(Request $request)
    {
        $categoryInput = $request->input('category');
        $query = Artist::query();

        if ($categoryInput) {
            if (is_numeric($categoryInput)) {
                $category = ArtistCategory::find($categoryInput);
            } else {
                $category = ArtistCategory::where('slug', $categoryInput)->first();
            }

            if ($category) {
                $query->whereJsonContains('category', (string) $category->id);
            }
        }

        $artists = $query->get();
        $categories = ArtistCategory::all()->map(function($cat) {
            $cat->setAttribute('artist_count', Artist::whereJsonContains('category', (string)$cat->id)->count());
            return $cat;
        });

        return view('pages.artists.index', compact('artists', 'categories', 'categoryInput'));
    }

    public function artist($slug)
    {
        $artists = Artist::with([
            'movies' => function ($query) {
                $query->orderBy('release_date', 'desc');
            },
            'songs' => function ($query) {
                $query->orderBy('release_date', 'desc');
            },
            'tvshows' => function ($query) {
                $query->orderBy('release_date', 'desc');
            }
        ])->where('slug', $slug)->firstOrFail();
        $artists->increment('views');
        $this->logPageView('artist', $artists->id);
        $reviews = $artists->reviews()->orderBy('created_at', 'asc')->paginate(15);
        return view('pages.artists.view', compact(['artists', 'reviews']));
    }


    public function liveSearch(Request $request)
    {
        $query = $request->input('query');

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $productionHouseCategory = \App\Models\ArtistCategory::where('slug', 'production-house')->first();
        $phCategoryId = $productionHouseCategory ? (string) $productionHouseCategory->id : '-1';

        $productionHouses = Artist::whereJsonContains('category', $phCategoryId)
            ->where('name', 'like', "%$query%")
            ->limit(5)
            ->get();

        $artists = Artist::whereJsonDoesntContain('category', $phCategoryId)
            ->where('name', 'like', "%$query%")
            ->limit(5)
            ->get();

        return response()->json([
            'movies' => Movie::where('title', 'like', "%$query%")->limit(5)->get(),
            'tvshows' => TvShow::where('title', 'like', "%$query%")->limit(5)->get(),
            'songs' => Song::where('title', 'like', "%$query%")->limit(5)->get(),
            'artists' => $artists,
            'production_houses' => $productionHouses,
        ]);
    }

    public function productionHouses()
    {
        $productionHouses = ProductionHouse::withCount(['producedMovies', 'producedSongs', 'producedTvShows'])
            ->orderBy('name')
            ->get();

        return view('pages.production-house.index', compact('productionHouses'));
    }

    public function productionHouse($slug)
    {
        $productionHouse = ProductionHouse::where('slug', $slug)->firstOrFail();

        $productionHouse->increment('views');
        $this->logPageView('production_house', $productionHouse->id);

        $movies  = $productionHouse->producedMovies()->orderBy('release_date', 'desc')->get();
        $songs   = $productionHouse->producedSongs()->orderBy('release_date', 'desc')->get();
        $tvShows = $productionHouse->producedTvShows()->orderBy('release_date', 'desc')->get();

        $reviews = $productionHouse->reviews()->orderBy('created_at', 'asc')->paginate(15);

        $recommended = ProductionHouse::where('id', '!=', $productionHouse->id)
            ->limit(4)
            ->get();

        return view('pages.production-house.view', compact('productionHouse', 'movies', 'songs', 'tvShows', 'reviews', 'recommended'));
    }

    private function logPageView($type, $id)
    {
        PageView::create([
            'user_id' => auth()->id(),
            'page_type' => $type,
            'content_id' => $id,
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);
    }

}
