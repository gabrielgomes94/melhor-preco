<?php

namespace Src\Products\Domain\Models\Product;

use Illuminate\Support\Collection;
use Src\Marketplaces\Infrastructure\Laravel\Models\Marketplace;
use Src\Prices\Infrastructure\Laravel\Models\Price;
use Src\Products\Infrastructure\Laravel\Models\Categories\Category;
use Src\Products\Domain\Models\Product\ValueObjects\Composition;
use Src\Products\Domain\Models\Product\ValueObjects\Costs;
use Src\Products\Domain\Models\Product\ValueObjects\Details;
use Src\Products\Domain\Models\Product\ValueObjects\Dimensions;
use Src\Products\Domain\Models\Product\ValueObjects\Identifiers;
use Src\Products\Domain\Models\Product\ValueObjects\Variations\Variations;
use Src\Users\Domain\Entities\User;

interface Product
{
    public function getIdentifiers(): Identifiers;

    public function getComposition(): Composition;

    public function getCategory(): ?Category;

    public function getCosts(): Costs;

    public function getDetails(): Details;

    public function getPrice(Marketplace $marketplace): ?Price;

    public function getPrices(): Collection;

    public function getDimensions(): Dimensions;

    public function getVariations(): ?Variations;

    public function hasCompositionProducts(): bool;

    public function hasVariations(): bool;

    public function isActive(): bool;

    public function postedOnMarketplace(Marketplace $marketplace): bool;

    public function getImages(): array;

    public function getUser(): User;
}
