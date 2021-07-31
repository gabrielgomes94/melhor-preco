<?php

namespace App\Services\Product\Update;

use App\Services\Pricing\UpdatePrice as UpdatePriceService;
use Barrigudinha\Pricing\Price\Services\CalculatePrice;
use Barrigudinha\Product\Product;
use Barrigudinha\Product\Store;
use Barrigudinha\Utils\Helpers;

class UpdatePosts
{
    private CalculatePrice $calculatePrice;
    private UpdatePriceService $updatePriceService;

    public function __construct(CalculatePrice $calculatePrice, UpdatePriceService $updatePriceService)
    {
        $this->calculatePrice = $calculatePrice;
        $this->updatePriceService = $updatePriceService;
    }

    public function updatePrice(Product $product, Store $store, float $priceValue): bool
    {
        $priceValue = Helpers::floatToMoney($priceValue);
        $products = $this->getProducts($product);

        foreach ($products as $product) {
            if (!$post = $product->getPost($store->slug())) {
                return false;
            }

            $price = $this->calculatePrice->calculate($product, $store, $priceValue);
            $post->setPrice($price->get(), $price->profit());
            $this->updatePriceService->execute($product->sku(), $post);
        }

        return true;
    }

    /**
     * @return Product[]
     */
    private function getProducts(Product $product): array
    {
        $products[] = $product;

        foreach ($product->variations()->get() as $variation) {
            $products[] = $variation;
        }

        return $products;
    }
}
