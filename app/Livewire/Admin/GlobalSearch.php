<?php

namespace App\Livewire\Admin;

use App\Models\Movie;
use App\Models\Artist;
use App\Models\TvShow;
use App\Models\Song;
use App\Models\User;
use App\Models\Region;
use App\Models\Genre;
use Livewire\Component;

class GlobalSearch extends Component
{
    public $query = '';
    public $results = [];
    public $showResults = false;

    public function updatedQuery()
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            $this->showResults = false;
            return;
        }

        $this->results = [];

        // Search Content (Movies, TV Shows, Songs)
        $movies = Movie::where('title', 'like', '%' . $this->query . '%')
            ->take(3)
            ->get()
            ->map(fn($m) => [
                'title' => $m->title,
                'url' => route('admin.movies.edit', $m),
                'icon' => 'fas fa-film',
                'type' => 'Movie'
            ]);

        $tvshows = TvShow::where('title', 'like', '%' . $this->query . '%')
            ->take(3)
            ->get()
            ->map(fn($t) => [
                'title' => $t->title,
                'url' => route('admin.tvshows.edit', $t),
                'icon' => 'fas fa-tv',
                'type' => 'TV Show'
            ]);

        $songs = Song::where('title', 'like', '%' . $this->query . '%')
            ->take(3)
            ->get()
            ->map(fn($s) => [
                'title' => $s->title,
                'url' => route('admin.songs.edit', $s),
                'icon' => 'fas fa-music',
                'type' => 'Song'
            ]);

        $content = $movies->concat($tvshows)->concat($songs);
        if ($content->count() > 0) $this->results['Content'] = $content->toArray();

        // Search Artists
        $artists = Artist::where('name', 'like', '%' . $this->query . '%')
            ->take(5)
            ->get()
            ->map(fn($a) => [
                'title' => $a->name,
                'url' => route('admin.artists.edit', $a),
                'icon' => 'fas fa-microphone',
                'type' => 'Artist'
            ]);
        if ($artists->count() > 0) $this->results['Artists'] = $artists->toArray();

        // Search Users
        $users = User::where('name', 'like', '%' . $this->query . '%')
            ->orWhere('email', 'like', '%' . $this->query . '%')
            ->take(5)
            ->get()
            ->map(fn($u) => [
                'title' => $u->name,
                'subtitle' => $u->email,
                'url' => route('admin.user-management'),
                'icon' => 'fas fa-user',
                'type' => 'User'
            ]);
        if ($users->count() > 0) $this->results['Users'] = $users->toArray();

        // Search Settings (Regions & Genres)
        $regions = Region::where('name', 'like', '%' . $this->query . '%')
            ->take(3)
            ->get()
            ->map(fn($r) => [
                'title' => $r->name,
                'url' => route('admin.regions.index'),
                'icon' => 'fas fa-globe',
                'type' => 'Region'
            ]);
        
        $genres = Genre::where('name', 'like', '%' . $this->query . '%')
            ->take(3)
            ->get()
            ->map(fn($g) => [
                'title' => $g->name,
                'url' => route('admin.genres.index'),
                'icon' => 'fas fa-tags',
                'type' => 'Genre'
            ]);

        $settings = $regions->concat($genres);
        if ($settings->count() > 0) $this->results['Settings'] = $settings->toArray();

        $this->showResults = count($this->results) > 0;
    }

    public function clearSearch()
    {
        $this->query = '';
        $this->results = [];
        $this->showResults = false;
    }

    public function render()
    {
        return view('livewire.admin.global-search');
    }
}
