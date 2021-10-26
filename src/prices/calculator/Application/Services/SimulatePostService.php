<?php

namespace Src\Prices\Calculator\Application\Services;

use Src\Prices\Calculator\Domain\Contracts\Services\SimulatePost;
use Src\Prices\Calculator\Domain\Price\ProductData\ProductData;
use Src\Prices\Calculator\Domain\Services\CalculatePrice;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Product\Contracts\Models\Post;
use Src\Products\Domain\Product\Models\Product;
use Src\Products\Domain\Store\Factory as StoreFactory;
use Src\Products\Domain\Post\Factories\Factory as PostFactory;

class SimulatePostService implements SimulatePost
{
    private CalculatePrice $calculatePrice;

    public function __construct(CalculatePrice $calculatePrice)
    {
        $this->calculatePrice = $calculatePrice;
    }

    public function calculate(
        string $productId,
        string $storeSlug,
        float $price,
        float $commission,
        array $options = []
    ): Post {
        if (!$product = Product::find($productId)) {
            throw new ProductNotFoundException($productId);
        }

        $price = $this->calculatePrice->calculate(
            new ProductData($product->data()->getCosts(), $product->data()->getDimensions()),
            StoreFactory::make($storeSlug),
            $price,
            $commission,
            $options
        );

        $post = $product->data()->getPost($storeSlug);

        return PostFactory::updatePrice($product->data(), $post, $price);
    }

}
