<?php

namespace Src\Prices\Application\UseCases;

use Src\Marketplaces\Domain\Models\Contracts\Marketplace;
use Src\Math\Percentage;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Calculator\Application\Services\CalculatePrice;
use Src\Prices\Application\Services\Products\Update;
use Src\Prices\Domain\UseCases\Contracts\UpdatePrice as UpdatePriceInterface;
use Src\Products\Domain\Models\Post\Factories\Factory as PostFactory;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Repositories\Contracts\PostRepository;

class UpdatePrice implements UpdatePriceInterface
{
    private CalculatePrice $calculatePrice;
    private Update $updatePriceService;
    private PostRepository $postRepository;
    private PostFactory $postFactory;

    public function __construct(
        CalculatePrice $calculatePrice,
        Update $updatePriceService,
        PostRepository $postRepository,
        PostFactory $postFactory
    ) {
        $this->calculatePrice = $calculatePrice;
        $this->updatePriceService = $updatePriceService;
        $this->postRepository = $postRepository;
        $this->postFactory = $postFactory;
    }

    public function updatePrice(Product $product, Marketplace $marketplace, float $priceValue, ?float $commission = null): bool
    {
        $products = $this->getProducts($product);

        foreach ($products as $product) {
            $post = $this->postRepository->get($product, $marketplace);

            if (!$post) {
                return false;
            }

            $price = $this->calculatePrice->calculate(
                ProductData::fromModel($product),
                $marketplace,
                $priceValue,
                Percentage::fromFraction($commission ?? $this->getCommissionRate($post))
            );

            $post = $this->postFactory->updatePrice($product, $post, $price);
            $this->updatePriceService->execute($product->getSku(), $post);
        }

        return true;
    }

    /**
     * @return Product[]
     */
    private function getProducts(Product $product): array
    {
        $products[] = $product;

        foreach ($product->getVariations()->get() as $variation) {
            $products[] = $variation;
        }

        return $products;
    }

    protected function getCommissionRate(Post $post): float
    {
        return $post->getPrice()->getCommission()->getCommissionRate();
    }
}
