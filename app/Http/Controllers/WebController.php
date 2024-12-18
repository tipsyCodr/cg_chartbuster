<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Movie;
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
}
