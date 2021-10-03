<?php

namespace Src\Notifications\Infrastructure\Repositories;

use Src\Notifications\Domain\Contracts\Repository\Options as OptionsInterface;

class Options implements OptionsInterface
{
    private ?string $filter;
    private string $main;
    private array $query;
    private string $type;
    private string $path;
    private string $page;
    private bool $onlySolved;

    public function __construct(array $data)
    {
        $this->page = $data['page'];
        $this->path = $data['path'];
        $this->query = $data['query'] ?? [];
        $this->main = $data['main'] ?? '';
        $this->type = $data['type'] ?? '';

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
        return $this->type;
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
