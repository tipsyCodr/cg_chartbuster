<?php

use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\TvShowController;
use App\Http\Controllers\Admin\SongController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'index']);
Route::get('/home', [WebController::class, 'index'])->name('home');
//Movies
Route::get('/movies', [WebController::class, 'movies'])->name('movies');
Route::get('/movie/{id}', [WebController::class, 'movie'])->name('movie.show');

//Artists
Route::get('/artists', [WebController::class, 'artists'])->name('artists');
Route::get('/artist/{id}', [WebController::class, 'artist'])->name('artist.show');

//TV Shows
Route::get('/tv-shows', [WebController::class, 'tvShows'])->name('tv-shows');
Route::get('/tv-show/{id}', [WebController::class, 'tvShow'])->name('tv-show.show');

//Songs
Route::get('/songs', [WebController::class, 'songs'])->name('songs');
Route::get('/song/{id}', [WebController::class, 'song'])->name('song.show');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/user-management', [AdminController::class, 'userManagement'])->name('admin.user-management');
        Route::post('/toggle-user/{userId}', [AdminController::class, 'toggleUserStatus'])->name('admin.toggle-user');
        
        // Movies Admin Routes
        Route::resource('/movies', App\Http\Controllers\Admin\MovieController::class)->names([
            'index' => 'admin.movies.index',
            'create' => 'admin.movies.create',
            'store' => 'admin.movies.store',
            'show' => 'admin.movies.show',
            'edit' => 'admin.movies.edit',
            'update' => 'admin.movies.update',
            'destroy' => 'admin.movies.destroy'
        ]);

        Route::resource('albums', AlbumController::class)
            ->names('admin.albums')
            ->except(['show']);

        Route::resource('artists', ArtistController::class)
            ->names('admin.artists')
            ->except(['show']);

        Route::resource('/tvshows', TvShowController::class)->names([
            'index' => 'admin.tvshows.index',
            'create' => 'admin.tvshows.create',
            'store' => 'admin.tvshows.store',
            'show' => 'admin.tvshows.show',
            'edit' => 'admin.tvshows.edit',
            'update' => 'admin.tvshows.update',
            'destroy' => 'admin.tvshows.destroy'
        ]);
        Route::resource('/songs', controller: SongController::class)->names([
            'index' => 'admin.songs.index',
            'create' => 'admin.songs.create',
            'store' => 'admin.songs.store',
            'show' => 'admin.songs.show',
            'edit' => 'admin.songs.edit',
            'update' => 'admin.songs.update',
            'destroy' => 'admin.songs.destroy'
        ]);

    });
});

require __DIR__.'/auth.php';
