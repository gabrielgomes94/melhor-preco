<?php

namespace Src\Products\Domain\Contracts\Utils;

use Barrigudinha\Utils\Paginator\Contracts\Options as PaginatorOptions;

interface Options extends PaginatorOptions
{
    public function hasPagination(): bool;
    public function hasProfitFilters(): bool;
    public function maximumProfit(): float;
    public function minimumProfit(): float;
    public function shouldFilterKits(): bool;
    public function sku(): ?string;
    public function store(): ?string;

}
