<?php

namespace App\Presenters\Store;

class Store
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
