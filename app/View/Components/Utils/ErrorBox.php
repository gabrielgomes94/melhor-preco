<?php

namespace App\View\Components\Utils;

use Illuminate\View\Component;

class ErrorBox extends Component
{
    /**
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.template.error-box.error-box');
    }
}
