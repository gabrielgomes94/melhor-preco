<?php

namespace App\Repositories\Product\Options;

class Options
{
    private ?int $page = null;
    private ?int $perPage = null;
    private ?float $minimumProfit;
    private ?float $maximumProfit;
    private bool $kits;
    private ?string $store;

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

    public function store(): ?string
    {
        return $this->store;
    }
}
