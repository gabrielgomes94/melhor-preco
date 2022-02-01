<?php

namespace Src\Calculator\Domain\Services\Contracts;

interface CalculatorOptions
{
    public const COMMISSION = 'commission';

    public const DISCOUNT_RATE = 'discountRate';

    public const IGNORE_FREIGHT = 'ignoreFreight';
}
