<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::resource('movies', MovieController::class);
Route::resource('artists', ArtistController::class);
Route::resource('albums', AlbumController::class);
