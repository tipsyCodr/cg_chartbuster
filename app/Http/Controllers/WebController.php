<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Movie;
use App\Models\Song;
use App\Models\TvShow;
use Illuminate\Http\Request;

class WebController extends Controller
{
    //
    public function index()
    {
        $movies = Movie::all();
        $artists = Artist::all();

        return view('home', compact('movies', 'artists'));
    }
    public function dashboard(){
        $movies = Movie::all();
        $artists = Artist::all();

        return view('dashboard', compact('movies', 'artists'));   
    }
    public function movies(){
        $movies = Movie::all();

        return view('pages.movies.index', compact('movies'));   
    }

    public function movie($id){
        $movie = Movie::findOrFail($id);

        return view('pages.movies.view', compact('movie'));
    }
    public function artists(){
        $artists = Artist::all();
        return view('pages.artists.index', compact('artists'));   
    }
    public function artist($id){
        $artists = Artist::findOrFail($id);
        return view('pages.artists.view', compact('artists'));   
    }
    public function tvShows(){
        $tvshows = TvShow::all();

        return view('pages.tvshows.index', compact('tvshows'));   
    }

    public function tvShow($id){
        $tvshow = TvShow::findOrFail($id);

        return view('pages.tvshows.view', compact('tvshow'));
    }

    public function songs(){
        $songs = Song::all();
        return view('pages.songs.index', compact('songs'));   
    }

    public function song($id){
        $song = Song::findOrFail($id);
        return view('pages.songs.view', compact('song'));
    }
}
