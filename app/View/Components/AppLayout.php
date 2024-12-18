<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public $movies;
    public $artists;

    /**
     * Create a new component instance.
     */
    public function __construct($movies=null,$artists=null)
    {
        //
        $this->movies = $movies;
        $this->artists = $artists;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
