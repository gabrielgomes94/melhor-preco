<?php

namespace App\Repositories\Notifications\Options;

class Options implements \Barrigudinha\Notification\Repositories\Contracts\Options
{
    private ?string $filter;
    private string $main;
    private array $query;
    private string $path;
    private string $page;
    private bool $onlySolved;

    public function __construct(array $data)
    {
        $this->page = $data['page'];
        $this->path = $data['path'];
        $this->query = $data['query'] ?? [];
        $this->main = $data['main'] ?? '';

        $this->filter = $data['filter'];
        $this->onlySolved = $data['filter'] === 'solved';
    }

    public function filter(): ?string
    {
        return $this->filter;
    }

    public function main(): string
    {
        return $this->main;
    }

    public function onlySolved(): bool
    {
        return $this->onlySolved;
    }

    public function page(): ?int
    {
        return $this->page;
    }

    public function perPage(): ?int
    {
        return 5;
    }

    public function type(): string
    {
        // TODO: Implement type() method.
    }

    public function url(): string
    {
        return $this->path;
    }

    public function query(): array
    {
        return $this->query ?? [];
    }
}
