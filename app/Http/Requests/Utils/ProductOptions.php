<?php

namespace App\Http\Requests\Utils;

use Src\Products\Domain\Contracts\Utils\Options as OptionsInterface;

class ProductOptions implements OptionsInterface
{
    private const INFINITE = 100000000000000000;
    public array $extra;
    public array $query;
    private bool $kits;
    private string $path;
    private ?int $page = null;
    private ?int $perPage = 40;
    private ?float $minimumProfit;
    private ?float $maximumProfit;
    private ?string $store;
    private ?string $sku;

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
        $this->sku = $data['sku'] ?? null;

        // Gambeta: fix this
        $this->path = $data['path'] ?? '';
        $this->query = $data['query'] ?? [];
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
        return $this->maximumProfit ?? self::INFINITE;
    }

    public function minimumProfit(): float
    {
        return $this->minimumProfit ?? (-1 * self::INFINITE);
    }

    public function shouldFilterKits(): bool
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

    public function sku(): ?string
    {
        return $this->sku;
    }

    public function store(): ?string
    {
        return $this->store;
    }

    public function url(): string
    {
        return $this->path;
    }

    public function query(): array
    {
        return $this->query;
    }

    public function setStore(string $store): void
    {
        $this->store = $store;
    }
}
