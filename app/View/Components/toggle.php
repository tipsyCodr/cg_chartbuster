<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class toggle extends Component
{
    /**
     * The initial state of the toggle.
     *
     * @var bool
     */
    public bool $initialState;
    public string $name;
    public string $label;
    public string $id;

    /**
     * Create a new component instance.
     *
     * @param  bool  $initialState
     */
    public function __construct(bool $initialState = false, string $name = '', string $label = '', string $id = '')
    {
        $this->initialState = $initialState;
        $this->name = $name;
        $this->label = $label;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.toggle');
    }
}
