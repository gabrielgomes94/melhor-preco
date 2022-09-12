<?php

namespace Src\Products\Infrastructure\Laravel\Repositories\Options;

use Src\Marketplaces\Domain\Models\Marketplace;

class Options
{
    private const INFINITE = 100000000000000000;

    public function __construct(
        public readonly ?float $minimumProfit = null,
        public readonly ?float $maximumProfit = null,
        public readonly ?string $sku = null,
        public readonly ?string $categoryId = null,
        public readonly ?int $page = null,
        public readonly ?int $perPage = 40,
        public readonly bool $filterKits = false,
        public ?string $userId = null,
        public ?Marketplace $marketplace = null
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

    public function getMarketplaceUuid(): string
    {
        return $this->marketplace?->getUuid() ?? '';
    }

    public function setMarketplace(Marketplace $marketplace): void
    {
        $this->marketplace = $marketplace;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }
}
