<?php

namespace Src\Products\Application\Services\Update;

use Src\Prices\Application\Services\UpdatePrice\Update;
use Src\Prices\Domain\Price\Services\CalculatePrice;
use Src\Products\Domain\Entities\Product;
use Src\Products\Domain\Data\Store;
use Barrigudinha\Utils\Helpers;

class UpdatePosts
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
     * @return \Src\Products\Domain\Entities\Product[]
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
