<?php

namespace Src\Calculator\Application\Services;

use Src\Calculator\Domain\Services\Contracts\SimulatePost;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Calculator\Domain\Services\CalculatePrice;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product\Contracts\Post;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Models\Store\Factory as StoreFactory;
use Src\Products\Domain\Models\Post\Factories\Factory as PostFactory;

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

        $post = $product->getPost($data['storeSlug']);

        return PostFactory::updatePrice($product, $post, $price);
    }
}
