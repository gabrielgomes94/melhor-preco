<?php

namespace Src\Prices\Calculator\Domain\Services\Contracts;

use Src\Products\Domain\Product\Contracts\Models\Post;

interface SimulatePost
{
    public function calculate(array $data): Post;
}
