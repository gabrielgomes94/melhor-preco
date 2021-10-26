<?php

namespace Src\Products\Domain\Product\Contracts\Models\Data;

interface Factory
{
    public static function make(array $data): Product;
}
