<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardBox extends Component
{
    public $title, $count, $icon;
    /**
     * Create a new component instance.
     */
    public function __construct($title, $count, $icon)
    {
       $this->title = $title;
        $this->count = $count;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard-box');
    }
}
