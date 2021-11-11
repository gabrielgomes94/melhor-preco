<?php

namespace Src\Prices\Calculator\Domain\Services;

interface CalculatorOptions
{
    public const DISCOUNT_RATE = 'discountRate';
    public const IGNORE_FREIGHT = 'ignoreFreight';
}
