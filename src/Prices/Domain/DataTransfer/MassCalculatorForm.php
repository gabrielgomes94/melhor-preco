<?php

namespace Src\Prices\Domain\DataTransfer;

class MassCalculatorForm
{
    public function __construct(
        public readonly float $value,
        public readonly string $calculationType,
        public readonly ?string $category = null,
    )
    {}
}
