<?php

namespace Src\Prices\Domain\DataTransfer;

class MassCalculatorForm
{
    public function __construct(
        public readonly float $markup,
        public readonly ?string $category = null,
    )
    {}
}
