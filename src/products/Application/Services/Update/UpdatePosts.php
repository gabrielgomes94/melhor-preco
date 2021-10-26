<?php

namespace Src\Products\Application\Services\Update;

use Src\Prices\Calculator\Domain\Price\ProductData\ProductData;
use Src\Prices\Calculator\Domain\Services\CalculatePrice;
use Src\Prices\Price\Application\Services\Products\Update;
use Src\Products\Domain\Post\Factories\Factory;
use Src\Products\Domain\Store\Store;

class UpdatePosts
{
    private CalculatePrice $calculatePrice;
    private Update $updatePriceService;

    public function __construct(CalculatePrice $calculatePrice, Update $updatePriceService)
    {
        $this->calculatePrice = $calculatePrice;
        $this->updatePriceService = $updatePriceService;
    }

    public function updatePrice(ProductData $product, Store $store, float $priceValue): bool
    {
        $products = $this->getProducts($product);

        foreach ($products as $product) {
            if (!$post = $product->getPost($store->getSlug())) {
                return false;
            }

            $price = $this->calculatePrice->calculate(
                new ProductData($product->getCosts(), $product->getDimensions()),
                $store,
                $priceValue,
                $post->getPrice()->getCommission()->getCommissionRate()
            );

            $post = Factory::updatePrice($product, $post, $price);

            $this->updatePriceService->execute($product->getSku(), $post);
        }

        return true;
    }

    /**
     * @return ProductData[]
     */
    private function getProducts(ProductData $product): array
    {
        $products[] = $product;

        foreach ($product->getVariations()->get() as $variation) {
            $products[] = $variation;
        }

        return $products;
    }
}
