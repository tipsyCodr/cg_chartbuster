<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Albums extends Component
{
    public $artists;
    public $movies;

    /**
     * Create a new component instance.
     */
    public function __construct($artists=null, $movies=null)
    {
        $this->artists = $artists;
        $this->movies = $movies;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.albums');
    }
}
