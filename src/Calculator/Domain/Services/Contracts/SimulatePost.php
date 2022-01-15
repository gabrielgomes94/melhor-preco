<?php

namespace Src\Calculator\Domain\Services\Contracts;

use Src\Products\Domain\Models\Product\Contracts\Post;

interface SimulatePost
{
    public function calculate(array $data): Post;
}
