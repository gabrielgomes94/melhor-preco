<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Components;

use Illuminate\View\Component;

class Link extends Component
{
    public string $content;
    public string $disabled;
    public string $uri;

    public function __construct(string $uri, string $content, ?string $disabled = null)
    {
        $this->content = $content;
        $this->disabled = (isset($disabled) && $disabled == "true")
            ? "disabled"
            : "";
        $this->uri = $uri;
    }

    /**
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.app.pricing.price-list.link');
    }
}
