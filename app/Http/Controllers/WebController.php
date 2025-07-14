<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Song;
use App\Models\TvShow;
use Illuminate\Http\Request;

class WebController extends Controller
{
    //
    public function index()
    {
        $banner_images = array_merge(
            Movie::where('show_on_banner', true)->get(['id','title','description','imdb_ratings','cg_chartbusters_ratings','release_date','poster_image', 'poster_image_landscape'])->toArray(),
            TVShow::where('show_on_banner', true)->get(['id','title','description','imdb_ratings','cg_chartbusters_ratings','release_date','poster_image', 'poster_image_landscape'])->toArray()
        );
        // dd($banner_images );
        $movies = Movie::all()->take(10);
        $songs = Song::all();
        $tvshows = TvShow::all()->take(10);
        $artists = Artist::all()->take(10);
        return view('home', compact('movies', 'songs', 'tvshows', 'artists','banner_images'));
    }
    
    public function dashboard(){
        $movies = Movie::all();
        $artists = Artist::all();
        return view('dashboard', compact('movies', 'artists'));   
    }

    public function movies(Request $request){
        $genre = $request->input('genre');
        
        $query = Movie::query();
        
        if($genre){
            $query->where('genre', $genre);
        }
        
        $movies = $query->get();
        $genres = Genre::all()->where('for','Movies');
        
        return view('pages.movies.index', compact('movies','genres'));   
    }

    public function movie($id){
        // $movie = Movie::findOrFail($id);
        $movie = Movie::with('artists')->find($id);
        $reviews = Movie::find($id)->reviews()->orderBy('created_at','asc')->paginate(15);
        return view('pages.movies.view', compact(['movie','reviews']));
    }


    public function tvShows(Request $request){
        $genre = $request->input('genre');
        $tvshows = TvShow::query();
        
        if($genre){
            $tvshows->where('genre', $genre);
        }
        
        $tvshows = $tvshows->get();
        $genres = Genre::all()->where('for','Tv Shows');
        return view('pages.tvshows.index', compact('tvshows','genres'));   
    }
    
    public function tvShow($id){
        $tvshow = TvShow::findOrFail($id);
        $reviews = TvShow::find($id)->reviews()->orderBy('created_at','asc')->paginate(15);
        return view('pages.tvshows.view', compact(['tvshow', 'reviews']));
    }


    public function songs(Request $request){
        $genre = $request->input('genre');
        $query = Song::query();
        
        if($genre){
            // dd($genre);
            $query->where('genre', $genre);  
        }
        
        $songs = $query->get();  // Use the query builder result instead of Song::all()
        $genres = Genre::all()->where('for','Songs');
        return view('pages.songs.index', compact('songs','genres'));   
    }

    public function song($id){
        $song = Song::findOrFail($id);
        $reviews = Song::find($id)->reviews()->orderBy('created_at','asc')->paginate(15);
        return view('pages.songs.view', compact(['song', 'reviews']));
    }


    
    public function artists(Request $request){
        $genre = $request->input('genre');
        $query = Artist::query();
        
        if($genre){
            $query->where('genre', $genre);  
        }
        
        $artists = $query->get();  // Use the query builder result instead of Artist::all()
        $genres = Genre::all()->where('for','Artists');
        return view('pages.artists.index', compact('artists','genres'));   
    }

    public function artist($id){
        $artists = Artist::findOrFail($id);
        return view('pages.artists.view', compact('artists'));   
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
