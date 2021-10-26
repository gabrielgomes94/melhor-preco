<?php

namespace Src\Products\Domain\Contracts\Utils;

use App\Options\Contracts\Options as PaginatorOptions;
use Src\Products\Domain\Product\Models\Data\Dimensions\Dimensions;

interface Options extends PaginatorOptions
{
    public function hasDimensionsFilters(): bool;
    public function getDimensions(): Dimensions;

    public function hasPagination(): bool;
    public function hasProfitFilters(): bool;
    public function maximumProfit(): float;
    public function minimumProfit(): float;
    public function shouldFilterKits(): bool;
    public function sku(): ?string;
    public function store(): ?string;

}
