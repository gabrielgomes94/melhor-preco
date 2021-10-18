<?php

namespace Src\Products\Domain\Product\Contracts\Models\Data\Dimensions;

interface Dimensions
{
    public function depth(): float;

    public function height(): float;

    public function weight(): float;

    public function width(): float;

    public function sum(): float;

    public function cubicWeight(): float;
}
