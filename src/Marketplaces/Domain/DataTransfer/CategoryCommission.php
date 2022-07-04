<?php

namespace Src\Marketplaces\Domain\DataTransfer;

use Src\Math\Percentage;

class CategoryCommission
{
    public function __construct(
        public readonly Percentage $commission,
        public readonly string $categoryId
    )
    {}
}
