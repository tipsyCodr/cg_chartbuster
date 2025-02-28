<?php

use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\TvShowController;
use App\Http\Controllers\Admin\SongController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RegionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'index']);
Route::get('/home', [WebController::class, 'index'])->name('home');

//Region
Route::get('/regions', [RegionController::class, 'index'])->name('regions');
Route::get('/region/add/{name}', [RegionController::class, 'add'])->name('region.add');

//Movies
Route::get('/movies', [WebController::class, 'movies'])->name('movies');
Route::post('/movies', [WebController::class, 'movies'])->name('movies.query');
Route::get('/movie/{id}', [WebController::class, 'movie'])->name('movie.show');

//Artists
Route::get('/artists', [WebController::class, 'artists'])->name('artists');
Route::post('/artists', [WebController::class, 'artists'])->name('artists.query');
Route::get('/artist/{id}', [WebController::class, 'artist'])->name('artist.show');
Route::get('admin/artists/list', [ArtistController::class, 'list'])->name('admin.artists.list');

//TV Shows
Route::get('/tv-shows', [WebController::class, 'tvShows'])->name('tv-shows');
Route::post('/tv-shows', [WebController::class, 'tvShows'])->name('tv-shows.query');
Route::get('/tv-show/{id}', [WebController::class, 'tvShow'])->name('tv-show.show');

//Songs
Route::get('/songs', [WebController::class, 'songs'])->name('songs');
Route::post('/songs', [WebController::class, 'songs'])->name('songs.query');
Route::get('/song/{id}', [WebController::class, 'song'])->name('song.show');


//reviews
Route::post('/movie/review/store', [ReviewController::class, 'storeMovieReview'])->name('movies.reviews.store');
Route::post('/tv-show/review', [ReviewController::class, 'storeTvShowReview'])->name('tv-shows.reviews.store');
Route::post('/album/review', [ReviewController::class, 'storeAlbumReview'])->name('albums.reviews.store');
Route::post('/song/review', [ReviewController::class, 'storeSongReview'])->name('songs.reviews.store');


//Users
Route::get('/user/login', [UserController::class, 'index'])->name('user.login');
Route::get('/user/login/authenticate', [UserController::class, 'login'])->name('user.login.authenticate');

Route::post('/user/logout', [UserController::class, 'logout'])->name('user.logout');

Route::get('/user/register', [UserController::class, 'register'])->name('user.register');
Route::post('/user/register/store', [UserController::class, 'store'])->name('user.register.store');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin');
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

        Route::resource('/tvshows', App\Http\Controllers\Admin\TvShowController::class)->names([
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
