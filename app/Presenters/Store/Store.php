<?php

namespace App\Presenters\Store;

class Store
{
    public string $name;
    public string $slug;

    public function __construct(string $name, string $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
    }
}
