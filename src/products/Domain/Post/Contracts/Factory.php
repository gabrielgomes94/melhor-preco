<?php


namespace Src\Products\Domain\Post\Contracts;


use Src\Prices\Calculator\Domain\Price\Price;
use Src\Products\Domain\Post\Post;
use Src\Products\Domain\Product\Models\Data\Costs\Costs;
use Src\Products\Domain\Product\Models\Data\Dimensions\Dimensions;

interface Factory
{
    public static function make(array $data): Post;

    public static function updatePrice(Post $post, Price $price, Costs $costs, Dimensions $dimensions): Post;
}
