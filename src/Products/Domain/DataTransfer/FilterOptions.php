<?php

namespace Src\Products\Domain\DataTransfer;

use Carbon\Carbon;

class FilterOptions
{
    public function __construct(
        public readonly ?string $sku = null,
        public readonly ?string $category = null,
        public readonly ?int $page = null,
        public readonly ?int $perPage = null,
        public readonly ?Carbon $beginDate = null,
        public readonly ?Carbon $endDate = null,
    ) {
    }


    public function hasCategory(): bool
    {
        return (bool) $this->category;
    }

    public function hasSku(): bool
    {
        return (bool) $this->sku;
    }
}
