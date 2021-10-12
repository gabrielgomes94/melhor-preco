<?php

namespace Src\Prices\Domain\Price\Services;

use Src\Prices\Domain\Contracts\Services\Calculator\CalculateProduct as CalculateProductInterface;
use Src\Products\Domain\Entities\Product;

class CalculateProduct implements CalculateProductInterface
{
    private CalculatePrice $calculatePrice;

    public function __construct(CalculatePrice $calculatePrice)
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
