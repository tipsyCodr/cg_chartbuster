<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\ArtistCategory;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Song;
use App\Models\TvShow;
use App\Models\HeroBanner;
use Illuminate\Http\Request;

class WebController extends Controller
{
    //
    public function index()
    {
        $hero_banners = HeroBanner::where('is_active', true)->orderBy('sort_order')->get();
        $banner_images = array_merge(
            Movie::where('show_on_banner', true)
                ->get(['id', 'slug', 'title', 'description', 'imdb_ratings', 'cg_chartbusters_ratings', 'release_date', 'poster_image', 'poster_image_landscape', 'banner_label', 'banner_link'])
                ->map(fn($item) => array_merge($item->toArray(), ['type' => 'movie']))
                ->toArray(),
            Song::where('show_on_banner', true)
                ->get(['id', 'slug', 'title', 'description', 'imdb_ratings', 'cg_chartbusters_ratings', 'release_date', 'poster_image', 'poster_image_landscape', 'banner_label', 'banner_link'])
                ->map(fn($item) => array_merge($item->toArray(), ['type' => 'song']))
                ->toArray(),
            TvShow::where('show_on_banner', true)
                ->get(['id', 'slug', 'title', 'description', 'imdb_ratings', 'cg_chartbusters_ratings', 'release_date', 'poster_image', 'poster_image_landscape', 'banner_label', 'banner_link'])
                ->map(fn($item) => array_merge($item->toArray(), ['type' => 'tv_show']))
                ->toArray()
        );
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
        return view('home', compact('movies', 'songs', 'tvshows', 'artists', 'banner_images', 'hero_banners'));
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

        $movies = $query->orderBy('release_date', 'desc')->get();
        $genres = Genre::all()->where('for', 'Movies');

        return view('pages.movies.index', compact('movies', 'genres'));
    }

    public function movie($slug)
    {
        $movie = Movie::with(['artists', 'region', 'genres'])->where('slug', $slug)->firstOrFail();
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

        $tvshows = $tvshows->orderBy('release_date', 'desc')->get();
        $genres = Genre::all()->where('for', 'Tv Shows');
        return view('pages.tvshows.index', compact('tvshows', 'genres'));
    }

    public function tvShow($slug)
    {
        $tvshow = TvShow::with(['region', 'genres'])->where('slug', $slug)->firstOrFail();
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

        $songs = $query->orderBy('release_date', 'desc')->get();  // Use the query builder result instead of Song::all()
        $genres = Genre::all()->where('for', 'Songs');
        return view('pages.songs.index', compact('songs', 'genres'));
    }

    public function song($slug)
    {
        $song = Song::with(['region', 'genres'])->where('slug', $slug)->firstOrFail();
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
        $artists = Artist::with(['movies' => function ($query) {
            $query->orderBy('release_date', 'desc');
        }])->where('slug', $slug)->firstOrFail();
        $reviews = $artists->reviews()->orderBy('created_at', 'asc')->paginate(15);
        return view('pages.artists.view', compact(['artists', 'reviews']));
    }


    public function liveSearch(Request $request)
    {
        $query = $request->input('query');

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        return response()->json([
            'movies' => Movie::where('title', 'like', "%$query%")->limit(5)->get(),
            'tvshows' => TvShow::where('title', 'like', "%$query%")->limit(5)->get(),
            'songs' => Song::where('title', 'like', "%$query%")->limit(5)->get(),
            'artists' => Artist::where('name', 'like', "%$query%")->limit(5)->get(),
        ]);
    }

}
