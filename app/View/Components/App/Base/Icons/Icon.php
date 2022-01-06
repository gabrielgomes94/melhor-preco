<?php

namespace App\View\Components\App\Base\Icons;

use Illuminate\View\Component;
use function view;

class Icon  extends Component
{
    private string $icon;

    public function __construct(string $icon)
    {
        $this->icon = $icon;
    }

    public function render()
    {
        return view("components.app.base.icons.{$this->icon}");
    }
}
