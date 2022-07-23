<?php

namespace Src\Prices\Domain\DataTransfer;

use Src\Math\Percentage;

class CalculatorForm
{
    public function __construct(
        public readonly float $desiredPrice,
        public readonly Percentage $commission,
        public readonly Percentage $discount,
        public readonly bool $ignoreFreeFreight = false,

    )
    {}
}
