<?php

namespace Src\Prices\Domain\DataTransfer;

class MassCalculatorForm
{
    public function __construct(
        public readonly float $value,
        public readonly MassCalculationTypes $calculationType,
        public readonly ?string $category = null,
    )
    {}
}
