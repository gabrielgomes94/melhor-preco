<?php

namespace Src\Prices\Infrastructure\Repositories\Options;

use Src\Products\Domain\Contracts\Repositories\Options as OptionsInterface;

class Options implements OptionsInterface
{
    private ?int $page = null;
    private ?int $perPage = 40;
    private ?float $minimumProfit;
    private ?float $maximumProfit;
    private bool $kits;
    private ?string $store;
    private ?string $searchSku;
    public array $extra;

    public function __construct(array $data)
    {
        $this->minimumProfit = isset($data['minimumProfit'])
            ? (float) $data['minimumProfit']
            : null;

        $this->maximumProfit = isset($data['maximumProfit'])
            ? (float) $data['maximumProfit']
            : null;

        $this->kits = (bool) ($data['filterKits'] ?? false);

        $this->page = $data['page'] ?? null;
        $this->store = $data['store'] ?? null;
        $this->searchSku = $data['sku'] ?? null;

        // Gambeta: fix this
        $this->extra = [
            'path' => $data['path'],
            'query' => $data['query'],
        ];
    }

    public function hasPagination(): bool
    {
        return (bool) $this->page;
    }

    public function hasProfitFilters(): bool
    {
        return isset($this->maximumProfit) || isset($this->minimumProfit);
    }

    public function maximumProfit(): float
    {
        return $this->maximumProfit ?? 100000000000000000;
    }

    public function minimumProfit(): float
    {
        return $this->minimumProfit ?? -100000000000000000;
    }

    public function filterKits(): bool
    {
        return $this->kits;
    }

    public function page(): ?int
    {
        return $this->page;
    }

    public function perPage(): ?int
    {
        return $this->perPage;
    }

    public function searchSku(): ?string
    {
        return $this->searchSku;
    }

    public function store(): ?string
    {
        return $this->store;
    }

    public function url(): string
    {
        return $this->extra['path'];
    }

    public function query(): array
    {
        return $this->extra['query'];
    }
}
