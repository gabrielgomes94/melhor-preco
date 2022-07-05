<?php

namespace Src\Marketplaces\Domain\DataTransfer;

use Src\Math\Percentage;

class CommissionValue
{
    public function __construct(
        public readonly Percentage $commission,
        public readonly ?string $categoryId = null
    )
    {}

    public function toArray(): array
    {
        return [
            'categoryId' => $this->categoryId,
            'commission' => $this->commission->get(),
        ];
    }
}
