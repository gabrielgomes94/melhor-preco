<?php

namespace Src\Prices\Calculator\Domain\Services\V1;

use Src\Prices\Calculator\Domain\Services\V1;
use Src\Prices\Calculator\Domain\Services\V1\CalculatePrice;
use Src\Prices\Calculator\Domain\Contracts\Services\V1\CalculateProduct as CalculateProductInterface;
use Src\Products\Domain\Entities\Product;

class CalculateProduct implements CalculateProductInterface
{
    private V1\CalculatePrice $calculatePrice;

    public function __construct(V1\CalculatePrice $calculatePrice)
    {
        $this->calculatePrice = $calculatePrice;
    }

    public function recalculate(Product $product): Product
    {
        foreach ($product->posts() as $post) {
            $price = $this->calculatePrice->recalculate($product, $post->store());
            $post->setPrice($price->get(), $price->profit());

            $posts[] = $post;
        }

        $product->setPosts($posts ?? []);

        return $product;
    }
}
