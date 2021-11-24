<?php

namespace Src\Prices\Calculator\Application\Services;

use Src\Math\Percentage;
use Src\Prices\Calculator\Domain\Services\Contracts\SimulatePost;
use Src\Prices\Calculator\Domain\Models\Product\ProductData;
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

    public function calculate(array $data): Post
    {
        if (!$product = Product::find($data['productId'])) {
            throw new ProductNotFoundException($data['productId']);
        }

        $price = $this->calculatePrice->calculate(
            ProductData::fromModel($product),
            StoreFactory::make($data['storeSlug']),
            $data['price'],
            $data['commission'],
            $data['options']
        );

        $post = $product->data()->getPost($data['storeSlug']);

        return PostFactory::updatePrice($product->data(), $post, $price);
    }
}
