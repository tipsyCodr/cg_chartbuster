<?php

use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\TvShowController;
use App\Http\Controllers\Admin\SongController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\LegalController;
use Illuminate\Support\Facades\Route;

//Frontend Routes
//Home
Route::get('/', [WebController::class, 'index']);
Route::get('/home', [WebController::class, 'index'])->name('home');

//Movies Frontend
Route::get('/movies', [WebController::class, 'movies'])->name('movies');
Route::post('/movies', [WebController::class, 'movies'])->name('movies.query');
Route::get('/movie/{slug}', [WebController::class, 'movie'])->name('movie.show');

//Artists Frontend
Route::get('/artists', [WebController::class, 'artists'])->name('artists');
Route::post('/artists', [WebController::class, 'artists'])->name('artists.query');
Route::get('/artist/{slug}', [WebController::class, 'artist'])->name('artist.show');
Route::get('admin/artists/list', [ArtistController::class, 'list'])->name('admin.artists.list');

//TV Shows Frontend
Route::get('/tv-shows', [WebController::class, 'tvShows'])->name('tv-shows');
Route::post('/tv-shows', [WebController::class, 'tvShows'])->name('tv-shows.query');
Route::get('/tv-show/{slug}', [WebController::class, 'tvShow'])->name('tv-show.show');

//Songs Frontend
Route::get('/songs', [WebController::class, 'songs'])->name('songs');
Route::post('/songs', [WebController::class, 'songs'])->name('songs.query');
Route::get('/song/{slug}', [WebController::class, 'song'])->name('song.show');

// Articles Frontend
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Legal Pages
Route::get('/privacy-policy', [LegalController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-and-conditions', [LegalController::class, 'termsAndConditions'])->name('terms-and-conditions');
Route::get('/cookie-policy', [LegalController::class, 'cookiePolicy'])->name('cookie-policy');
Route::get('/copyright-policy', [LegalController::class, 'copyrightPolicy'])->name('copyright-policy');
Route::get('/community-guidelines', [LegalController::class, 'communityGuidelines'])->name('community-guidelines');
Route::get('/content-moderation-policy', [LegalController::class, 'contentModeration'])->name('content-moderation-policy');
Route::get('/disclaimer', [LegalController::class, 'disclaimer'])->name('disclaimer');


//reviews Frontend
Route::post('/movie/review/store', [ReviewController::class, 'storeMovieReview'])->name('movies.reviews.store');
Route::post('/tv-show/review', [ReviewController::class, 'storeTvShowReview'])->name('tv-shows.reviews.store');
Route::post('/album/review', [ReviewController::class, 'storeAlbumReview'])->name('albums.reviews.store');
Route::post('/song/review', [ReviewController::class, 'storeSongReview'])->name('songs.reviews.store');
Route::post('/artist/review', [ReviewController::class, 'storeArtistReview'])->name('artists.reviews.store');


//Unauthenticated Users Activity 
Route::get('/user/login', [UserController::class, 'index'])->name('user.login');
Route::get('/user/login/authenticate', [UserController::class, 'login'])->name('user.login.authenticate');
Route::post('/user/logout', [UserController::class, 'logout'])->name('user.logout');
Route::get('/user/register', [UserController::class, 'register'])->name('user.register');
Route::post('/user/register/store', [UserController::class, 'store'])->name('user.register.store');


//Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/api/admin/stats', [AdminController::class, 'stats'])->name('admin.stats');
    Route::prefix('admin')->group(function () {
        // Admin Dashboard  
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin');
        Route::get('/user-management', [AdminController::class, 'userManagement'])->name('admin.user-management');
        Route::post('/user-management/store', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::post('/user-management/update/{userId}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::get('/user-management/export', [AdminController::class, 'exportUsers'])->name('admin.users.export');
        Route::post('/user-management/bulk-action', [AdminController::class, 'bulkAction'])->name('admin.users.bulk-action');
        Route::post('/toggle-user/{userId}', [AdminController::class, 'toggleUserStatus'])->name('admin.toggle-user');

        // Resources Movies, Tv Shows, Songs, Albums, Artists, Genres, Regions
        Route::resource('/regions', App\Http\Controllers\Admin\Settings\RegionController::class)->names([
            'index' => 'admin.regions.index',
            'create' => 'admin.regions.create',
            'store' => 'admin.regions.store',
            'show' => 'admin.regions.show',
            'edit' => 'admin.regions.edit',
            'update' => 'admin.regions.update',
            'destroy' => 'admin.regions.destroy'
        ]);
        Route::resource('/genres', App\Http\Controllers\Admin\Settings\GenreController::class)->names([
            'index' => 'admin.genres.index',
            'create' => 'admin.genres.create',
            'store' => 'admin.genres.store',
            'show' => 'admin.genres.show',
            'edit' => 'admin.genres.edit',
            'update' => 'admin.genres.update',
            'destroy' => 'admin.genres.destroy'
        ]);
        Route::resource('/movies', App\Http\Controllers\Admin\MovieController::class)->names([
            'index' => 'admin.movies.index',
            'create' => 'admin.movies.create',
            'store' => 'admin.movies.store',
            'show' => 'admin.movies.show',
            'edit' => 'admin.movies.edit',
            'update' => 'admin.movies.update',
            'destroy' => 'admin.movies.destroy'
        ]);
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
        Route::resource('albums', AlbumController::class)
            ->names('admin.albums')
            ->except(['show']);
        Route::resource('artists', ArtistController::class)
            ->names('admin.artists')
            ->except(['show']);
        Route::resource('hero-banners', App\Http\Controllers\Admin\HeroBannerController::class)
            ->names('admin.hero-banners')
            ->except(['show']);
        Route::resource('articles', App\Http\Controllers\Admin\ArticleController::class)
            ->names('admin.articles')
            ->except(['show']);
        Route::post('article-categories', [\App\Http\Controllers\Admin\ArticleCategoryController::class, 'store'])->name('admin.article-categories.store');

        // Moderation Routes
        Route::prefix('moderation')->group(function () {
            Route::post('review/{id}/approve', [\App\Http\Controllers\Admin\ModerationController::class, 'approveReview'])->name('admin.moderation.review.approve');
            Route::post('review/{id}/reject', [\App\Http\Controllers\Admin\ModerationController::class, 'rejectReview'])->name('admin.moderation.review.reject');
            Route::delete('review/{id}', [\App\Http\Controllers\Admin\ModerationController::class, 'deleteReview'])->name('admin.moderation.review.delete');
            Route::post('report/{id}/status', [\App\Http\Controllers\Admin\ModerationController::class, 'updateReportStatus'])->name('admin.moderation.report.status');
        });
    });
});

// APIs Routes for Fetching Data
//Live Search API
Route::get('/live-search', [WebController::class, 'liveSearch'])->name('live.search');

//Region API
Route::get('/regions', [RegionController::class, 'index'])->name('regions');
Route::get('/region/add/{name}', [RegionController::class, 'add'])->name('region.add');


// Locale Switcher
Route::get('set-locale/{lang}', [App\Http\Controllers\LanguageController::class, 'setLocale'])->name('set-locale');

require __DIR__ . '/auth.php';
