<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Represents the top navigation bar component in the application.
 * 
 * This component is responsible for rendering the top bar navigation,
 * which typically includes elements like logo, menu items, user profile,
 * and other navigation-related controls.
 * 
 * @category   Navigation
 * @package    App\View\Components
 * @subpackage Components
 * @author     Hemant Kumar <itshemant566@gmail.com>
 * @license    MIT License
 */
class TopBar extends Component
{

    /**
     * Render the top bar component.
     *
     * @return View|Closure|string The rendered view for the top navigation bar
     */
    public function render(): View|Closure|string
    {
        return view('components.navigation.top-bar');
    }

}
