<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Album;
use App\Models\Song;
use App\Models\TvShow;

class ReviewController extends Controller
{
    //Storing Movie Review
    public function storeMovieReview(Request $request){
        $request->validate([
            'review_text' => 'required|string',
            'rating' => 'nullable|integer|max:5',
        ]);

        $movie = Movie::findOrFail($request->movie_id);
        if(!auth()->check()){
            return redirect()->back()->with('error','You must be logged in to review a movie');
        }

        if($movie->reviews()->where('user_id', auth()->user()->id)->exists()){
            return redirect()->back()->with('error','You have already reviewed this movie');
        }
        $movie->reviews()->create([
            // 'user_id' => 1,
            'user_id' => auth()->user()->id,
            'movie_id' => $request->movie_id,
            'review_text' => $request->review_text,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success','Your Review added successfully');
    }
    //Storing TV Show Review
    public function storeTvShowReview(Request $request){
        $request->validate([
            'review_text' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $tvshow = TvShow::findOrFail($request->tvshow_id);
        if(!auth()->check()){
            return redirect()->back()->with('error','You must be logged in to review a TV Show');
        }

        if($tvshow->reviews()->where('user_id', auth()->user()->id)->exists()){
            return redirect()->back()->with('error','You have already reviewed this TV Show');
        }
        $tvshow->reviews()->create([
            'user_id' => auth()->user()->id,
            'tvshow_id' => $request->tvshow_id,
            'review_text' => $request->review_text,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success','Your Review added successfully');
    }

    //Storing Album Review
    public function storeAlbumReview(Request $request){
        $request->validate([
            'review_text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $album = Album::findOrFail($request->album_id);
        if(!auth()->check()){
            return redirect()->back()->with('error','You must be logged in to review an Album');
        }

        if($album->reviews()->where('user_id', auth()->user()->id)->exists()){
            return redirect()->back()->with('error','You have already reviewed this Album');
        }
        $album->reviews()->create([
            'user_id' => auth()->user()->id,
            'album_id' => $request->album_id,
            'review_text' => $request->review_text,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success','Your Review added successfully');
    }

    //Storing Song Review
    public function storeSongReview(Request $request){
        $request->validate([
            'review_text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $song = Song::findOrFail($request->song_id);
        if(!auth()->check()){
            return redirect()->back()->with('error','You must be logged in to review a Song');
        }

        if($song->reviews()->where('user_id', auth()->user()->id)->exists()){
            return redirect()->back()->with('error','You have already reviewed this Song');
        }
        $song->reviews()->create([
            'user_id' => auth()->user()->id,
            'song_id' => $request->song_id,
            'review_text' => $request->review_text,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success','Your Review added successfully');
    }

}
