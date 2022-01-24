<?php

namespace Src\Prices\Application\UseCases;

use Src\Math\Percentage;
use Src\Calculator\Domain\Models\Product\ProductData;
use Src\Calculator\Application\Services\CalculatePrice;
use Src\Prices\Application\Services\Products\Update;
use Src\Prices\Domain\UseCases\Contracts\UpdatePrice as UpdatePriceInterface;
use Src\Products\Domain\Models\Post\Factories\Factory;
use Src\Products\Domain\Models\Post\Post;
use Src\Products\Domain\Models\Product\Product;
use Src\Products\Domain\Models\Store\Store;

class UpdatePrice implements UpdatePriceInterface
{
    private CalculatePrice $calculatePrice;
    private Update $updatePriceService;

    public function __construct(CalculatePrice $calculatePrice, Update $updatePriceService)
    {
        $this->calculatePrice = $calculatePrice;
        $this->updatePriceService = $updatePriceService;
    }

    public function updatePrice(Product $product, Store $store, float $priceValue): bool
    {
        $products = $this->getProducts($product);

        foreach ($products as $product) {
            if (!$post = $product->getPost($store->getSlug())) {
                return false;
            }

            $price = $this->calculatePrice->calculate(
                ProductData::fromModel($product),
                $store,
                $priceValue,
                Percentage::fromFraction($this->getCommissionRate($post))
            );

            $post = Factory::updatePrice($product, $post, $price);
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
