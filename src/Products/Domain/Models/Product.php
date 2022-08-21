<?php

namespace Src\Products\Domain\Models;

use Illuminate\Support\Collection;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Domain\Models\ValueObjects\Composition;
use Src\Products\Domain\Models\ValueObjects\Costs;
use Src\Products\Domain\Models\ValueObjects\Dimensions;
use Src\Products\Domain\Models\ValueObjects\Identifiers;
use Src\Products\Domain\Models\ValueObjects\Variations;
use Src\Users\Domain\Models\User;

interface Product
{
    public function getIdentifiers(): Identifiers;

    public function getBrand(): string;

    public function getComposition(): Composition;

    public function getCubicWeight(): float;

    public function getCategory(): ?Category;

    public function getCosts(): Costs;

    public function getDimensions(): Dimensions;

    public function getEan(): string;

    public function getImages(): array;

    public function getName(): string;

    public function getPrice(Marketplace $marketplace): ?Price;

    public function getPrices(): Collection;

    public function getQuantity(): float;

    public function getSku(): string;

    public function getVariations(): ?Variations;

    public function getUser(): User;

    public function hasCompositionProducts(): bool;

    public function hasVariations(): bool;

    public function isActive(): bool;

    public function isVariation(): bool;

    public function postedOnMarketplace(Marketplace $marketplace): bool;

    public function setCosts(Costs $costs): void;
}
