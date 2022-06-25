<?php

namespace Src\Products\Infrastructure\Laravel\Repositories\Options;

use Src\Products\Domain\Models\Product\Data\Dimensions;

class Options
{
    private const INFINITE = 100000000000000000;
    public array $extra;
    public array $query;
    protected array $dimensions;
    protected bool $kits;
    protected string $path;
    protected ?int $page = null;
    protected ?int $perPage = 40;
    protected ?float $minimumProfit;
    protected ?float $maximumProfit;
    protected ?string $store;
    protected ?string $sku;
    private ?string $categoryId;

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
        $this->categoryId = $data['categoryId'] ?? null;

        // Gambeta: fix this
        $this->path = $data['path'] ?? '';
        $this->query = $data['query'] ?? [];

        $this->dimensions = $data['dimensions'] ?? [];
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

    public function hasDimensionsFilters(): bool
    {
        return !empty($this->dimensions);
    }

    public function getCategoryId(): ?string
    {
        return $this->categoryId;
    }

    public function getDimensions(): Dimensions
    {
        return new Dimensions(
            $this->dimensions['dimensions']['depth'],
            $this->dimensions['dimensions']['height'],
            $this->dimensions['dimensions']['width'],
            $this->dimensions['dimensions']['weight']
        );
    }

    public function hasCategories(): bool
    {
        return (bool) $this->categoryId;
    }
}
