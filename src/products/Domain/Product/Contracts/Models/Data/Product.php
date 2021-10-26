<?php

namespace Src\Products\Domain\Product\Contracts\Models\Data;

use Src\Products\Domain\Product\Contracts\Models\Data\Composition\Composition;
use Src\Products\Domain\Product\Contracts\Models\Data\Costs\Costs;
use Src\Products\Domain\Product\Contracts\Models\Data\Details\Details;
use Src\Products\Domain\Product\Contracts\Models\Data\Dimensions\Dimensions;
use Src\Products\Domain\Product\Contracts\Models\Data\Identifiers\Identifiers;
use Src\Products\Domain\Store\Contracts\Store;
use Src\Products\Domain\Product\Contracts\Models\Data\Variations\Variations;
use Src\Products\Domain\Product\Contracts\Models\Post;

interface Product
{
    public function getIdentifiers(): Identifiers;

    public function getComposition(): Composition;

    public function getCosts(): Costs;

    public function getDetails(): Details;

    public function getDimensions(): Dimensions;

    public function getPost(string $storeSlug): ?Post;

    public function getPosts(): array;

    public function getStore(string $storeSlug): ?Store;

    public function getStores(): array;

    public function getVariations(): ?Variations;

    public function hasCompositionProducts(): bool;

    public function hasVariations(): bool;

    public function isActive(): bool;
}
