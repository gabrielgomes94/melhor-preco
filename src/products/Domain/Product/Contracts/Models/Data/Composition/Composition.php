<?php

namespace Src\Products\Domain\Product\Contracts\Models\Data\Composition;

use Src\Products\Domain\Product\Models\Data\Costs\Costs;

interface Composition
{
    public function hasCompositions(): bool;

    public function getSkus(): array;

    public function costs(): Costs;
}
