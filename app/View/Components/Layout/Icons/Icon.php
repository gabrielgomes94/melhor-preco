<?php

namespace App\View\Components\Layout\Icons;

use Illuminate\View\Component;

class Icon  extends Component
{
    private string $icon;

    public function __construct(string $icon)
    {
        $this->icon = $icon;
    }

    public function render()
    {
        return view("components.layout.icons.{$this->icon}");
    }
}
