<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    public $title;
    public $metaDescription;

    public function __construct($title = null, $metaDescription = null)
    {
        $this->title = $title;
        $this->metaDescription = $metaDescription;
    }

    public function render()
    {
        return view('layouts.app');
    }
}
