<?php

namespace Src\Products\Infrastructure\Laravel\Repositories\Options;

use Src\Products\Domain\Models\Product\ValueObjects\Dimensions;

class Options
{
    private const INFINITE = 100000000000000000;
//    public array $extra;
//    public array $query;
//    protected string $path;
//    protected bool $kits;
//    protected ?int $page = null;
//    protected ?int $perPage = 40;
//    public ?float $minimumProfit;
//    public ?float $maximumProfit;
//    protected ?string $store;
//    protected ?string $marketplaceSlug;
//    protected ?string $sku;
//    private ?string $categoryId;
//    private ?string $userId;

    public function __construct(
        public readonly ?float $minimumProfit = null,
        public readonly ?float $maximumProfit = null,
        public readonly ?string $sku = null,
        public readonly ?string $categoryId = null,
        public readonly ?string $userId = null,
        public readonly ?int $page = null,
        public readonly ?int $perPage = 40,
        public readonly bool $filterKits = false,
        public ?string $marketplaceSlug = null
    )
    {
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
        return $this->filterKits;
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

//    public function url(): string
//    {
//        return $this->path;
//    }
//
//    public function query(): array
//    {
//        return $this->query;
//    }

    public function setStore(string $store): void
    {
        $this->store = $store;
    }

    public function getCategoryId(): ?string
    {
        return $this->categoryId;
    }

    public function hasCategories(): bool
    {
        return (bool) $this->categoryId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function hasSku(): bool
    {
        return (bool) $this->sku;
    }
}
