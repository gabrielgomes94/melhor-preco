<?php

namespace Src\Marketplaces\Domain\Models\ValueObjects;

use Src\Math\Percentage;

class CategoryCommission
{
    public readonly Percentage $commission;
    public readonly string $categoryId;

    public function __construct(array $data)
    {
        $this->commission = Percentage::fromPercentage((float) $data['commission'] ?? 0.0);
        $this->categoryId = $data['categoryId'];
    }
}
