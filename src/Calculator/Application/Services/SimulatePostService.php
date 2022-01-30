<?php

namespace Src\Calculator\Application\Services;

use Src\Calculator\Domain\Services\Contracts\SimulatePost;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Products\Application\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Product\Contracts\Post;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Models\Post\Factories\Factory as PostFactory;

class SimulatePostService implements SimulatePost
{
    private CalculatePrice $calculatePrice;
    private MarketplaceRepository $marketplaceRepository;

    public function __construct(CalculatePrice $calculatePrice, MarketplaceRepository $marketplaceRepository)
    {
        $this->calculatePrice = $calculatePrice;
        $this->marketplaceRepository = $marketplaceRepository;
    }

    public function calculate(array $data): Post
    {
        if (!$product = Product::find($data['productId'])) {
            throw new ProductNotFoundException($data['productId']);
        }

        $marketplace = $this->marketplaceRepository->getBySlug($data['storeSlug']);

        $price = $this->calculatePrice->calculate(
            ProductData::fromModel($product),
            $marketplace,
            $data['price'],
            $data['commission'],
            $data['options']
        );

        $post = $product->getPost($data['storeSlug']);

        return PostFactory::updatePrice($product, $post, $price);
    }
}
