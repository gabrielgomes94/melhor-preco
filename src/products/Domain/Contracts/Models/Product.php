<?php

namespace Src\Products\Domain\Contracts\Models;

use Src\Products\Domain\Data\Compositions\Composition;
use Src\Products\Domain\Data\Costs;
use Src\Products\Domain\Data\Dimensions;

interface Product
{
    public function brand(): string;

    public function compositionProducts(): array;

    public function composition(): Composition;

    public function costs(): Costs;

    public function images(): array;

    public function isActive(): bool;

    public function name(): string;

    public function dimensions(): Dimensions;

    public function erpId(): ?string;

    public function hasVariations(): bool;

    public function sku(): string;

    public function stores(): array;

}
