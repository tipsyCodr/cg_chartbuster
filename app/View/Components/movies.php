<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class movies extends Component
{
    public $movies;
    public $artists;

    /**
     * Create a new component instance.
     */
    public function __construct($movies,$artists)
    {
        //
        $this->movies = $movies;
        $this->artists = $artists;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.movies');
    }
}
