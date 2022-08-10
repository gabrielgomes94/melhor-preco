<?php

namespace Src\Users\Domain\Models\ValueObjects;

use Src\Math\Percentage;

class Taxes
{
    public function __construct(
        public readonly Percentage $simplesNacional,
        public readonly Percentage $icmsInnerState,
    )
    {}
}
