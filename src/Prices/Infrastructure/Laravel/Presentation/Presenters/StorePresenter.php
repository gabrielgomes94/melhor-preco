<?php

namespace Src\Prices\Infrastructure\Laravel\Presentation\Presenters;

class StorePresenter
{
    private string $name;
    private string $slug;

    public function __construct(string $name, string $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function slug(): string
    {
        return $this->slug;
    }
}
