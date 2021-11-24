<?php


namespace Src\Products\Domain\Post\Contracts;


use Src\Prices\Calculator\Domain\Models\Price\Price;
use Src\Products\Domain\Post\Post;
use Src\Products\Domain\Product\Models\Data\Costs\Costs;
use Src\Products\Domain\Product\Models\Data\Dimensions\Dimensions;

interface Factory
{
    public function make(array $data): Post;

    public function updatePrice(Post $post, Price $price, Costs $costs, Dimensions $dimensions): Post;
}
