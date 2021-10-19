<?php

namespace Src\Prices\Calculator\Application\Services;

use Src\Prices\Calculator\Domain\Contracts\Services\SimulatePost;
use Src\Prices\Calculator\Domain\Price\ProductData\ProductData;
use Src\Prices\Calculator\Domain\Services\CalculatePrice;
use Src\Products\Domain\Post\Post;
use Src\Products\Domain\Product\Contracts\Repositories\Repository;
use Src\Products\Domain\Store\Factory as StoreFactory;
use Src\Products\Domain\Post\Factories\Factory as PostFactory;

class SimulatePostService implements SimulatePost
{
    private Repository $repository;
    private CalculatePrice $calculatePrice;

    public function __construct(Repository $repository, CalculatePrice $calculatePrice)
    {
        $this->repository = $repository;
        $this->calculatePrice = $calculatePrice;
    }

    public function calculate(string $productId, string $storeSlug, float $price, float $commission, array $options = []): Post
    {
        if (!$product = $this->repository->get($productId)) {
//            throw exception
        }

        $price = $this->calculatePrice->calculate(
            new ProductData($product->data()->getCosts(), $product->data()->getDimensions()),
            StoreFactory::make($storeSlug),
            $price,
            $commission,
            $options
        );

        $post = $product->data()->getPost($storeSlug);

        return PostFactory::updatePrice($post, $price, [
            'store' => $post->getStore()->getSlug(),
            'costs' => $product->data()->getCosts(),
            'dimensions' => $product->data()->getDimensions(),
            'value'
        ]);
    }

}
