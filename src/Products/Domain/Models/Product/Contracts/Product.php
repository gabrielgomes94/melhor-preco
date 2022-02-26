<?php

namespace Src\Products\Domain\Models\Product\Contracts;

use Src\Products\Domain\Models\Categories\Category;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Product\Data\Composition\Composition;
use Src\Products\Domain\Models\Product\Data\Costs\Costs;
use Src\Products\Domain\Models\Product\Data\Details\Details;
use Src\Products\Domain\Models\Product\Data\Dimensions\Dimensions;
use Src\Products\Domain\Models\Product\Data\Identifiers\Identifiers;
use Src\Products\Domain\Models\Product\Data\Variations\Variations;

interface Product
{
    public function getIdentifiers(): Identifiers;

    public function getComposition(): Composition;

    public function getCategory(): ?Category;

    public function getCosts(): Costs;

    public function getDetails(): Details;

    public function getDimensions(): Dimensions;

    public function getVariations(): ?Variations;

    public function hasCompositionProducts(): bool;

    public function hasVariations(): bool;

    public function isActive(): bool;
}
