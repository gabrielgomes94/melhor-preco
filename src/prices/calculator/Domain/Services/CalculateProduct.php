<?php

namespace Src\Prices\Calculator\Domain\Services;

use Src\Prices\Calculator\Domain\Services\CalculatePrice;
use Src\Prices\Calculator\Domain\Contracts\Services\CalculateProduct as CalculateProductInterface;
use Src\Products\Domain\Entities\Product;

class CalculateProduct implements CalculateProductInterface
{
    private \Src\Prices\Calculator\Domain\Services\CalculatePrice $calculatePrice;

    public function __construct(\Src\Prices\Calculator\Domain\Services\CalculatePrice $calculatePrice)
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
