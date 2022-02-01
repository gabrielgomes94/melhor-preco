<?php


namespace Src\Products\Domain\Models\Post\Contracts;


use Src\Calculator\Domain\Models\Price\Price;
use Src\Products\Domain\Models\Categories\Category;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Product\Data\Costs\Costs;
use Src\Products\Domain\Models\Product\Data\Dimensions\Dimensions;

interface Factory
{
    public function make(array $data): Post;
}
