<?php


namespace Src\Prices\Calculator\Domain\Contracts\Services;


use Src\Products\Domain\Post\Post;

interface SimulatePost
{
    public function calculate(
        string $productId,
        string $storeSlug,
        float $price,
        float $commission,
        array $options = []
    ): Post;
}
