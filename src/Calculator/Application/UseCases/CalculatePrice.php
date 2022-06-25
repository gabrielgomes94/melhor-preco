<?php

namespace Src\Calculator\Application\UseCases;

use Src\Calculator\Application\Services\CalculatePrice as CalculatePriceService;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Calculator\Domain\UseCases\Contracts\CalculatePrice as CalculatePriceInterface;
use Src\Marketplaces\Domain\Repositories\MarketplaceRepository;
use Src\Products\Domain\Exceptions\ProductNotFoundException;
use Src\Products\Domain\Models\Post\Factories\Factory as PostFactory;
use Src\Products\Domain\Models\Post\Contracts\Post;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;
use Src\Products\Domain\Repositories\Contracts\PostRepository;
use Src\Products\Domain\Repositories\Contracts\ProductRepository;

class CalculatePrice implements CalculatePriceInterface
{
    public function __construct(
        private MarketplaceRepository $marketplaceRepository,
        private ProductRepository $productRepository,
        private PostFactory $postFactory,
        private PostRepository $postRepository,
        private CalculatePriceService $calculatePrice
    ) {
    }

    public function calculate(array $data): Post
    {
        $product = $this->getProduct($data['productId']);
        $marketplace = $this->getMarketplace($data['storeSlug']);

        $price = $this->calculatePrice->calculate(
            ProductData::fromModel($product),
            $marketplace,
            $data['price'],
            $data['commission'],
            $data['options']
        );

        $post = $this->postRepository->getByMarketplaceSlug($product, $data['storeSlug']);

        return $this->postFactory->updatePrice($post, $price);
    }

    private function getProduct(string $productSku): Product
    {
        $product = $this->productRepository->get($productSku);

        if (!$product) {
            throw new ProductNotFoundException($productSku);
        }

        return $product;
    }

    private function getMarketplace(string $marketplaceSlug)
    {
        return $this->marketplaceRepository->getBySlug($marketplaceSlug);
    }
}
