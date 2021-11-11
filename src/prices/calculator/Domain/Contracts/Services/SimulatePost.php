<?php

namespace Src\Prices\Calculator\Domain\Contracts\Services;

use Src\Products\Domain\Product\Contracts\Models\Post;

interface SimulatePost
{
    public function calculate(array $data): Post;
}
