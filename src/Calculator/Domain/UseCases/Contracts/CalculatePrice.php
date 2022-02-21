<?php

namespace Src\Calculator\Domain\UseCases\Contracts;

use Src\Products\Domain\Models\Product\Contracts\Post;

interface CalculatePrice
{
    public function calculate(array $data): Post;
}
