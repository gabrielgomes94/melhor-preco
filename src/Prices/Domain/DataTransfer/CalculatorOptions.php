<?php

namespace Src\Prices\Domain\DataTransfer;

use Src\Math\Percentage;

class CalculatorOptions
{
    public readonly ?Percentage $overridenCommission;
    public readonly Percentage $discountRate;
    public readonly bool $ignoreFreight;

    public function __construct(
        ?Percentage $discountRate = null,
        ?Percentage $overridenCommission = null,
        bool $ignoreFreight = false,
    )
    {
        $this->discountRate = $discountRate ?? Percentage::fromPercentage(0.0);
        $this->overridenCommission = $overridenCommission;
        $this->ignoreFreight = $ignoreFreight;
    }
}
