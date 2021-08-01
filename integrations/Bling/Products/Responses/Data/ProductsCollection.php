<?php

namespace Integrations\Bling\Products\Responses\Data;

use Integrations\Bling\Products\Responses\Data\Product as ProductData;

class ProductsCollection
{
    /**
     * @var Product[]
     */
    private array $products = [];

    public function addProducts(array $products): void
    {
        foreach ($products as $product) {
            if ($product instanceof Product) {
                $this->products[] = $product;
            }
        }
    }

    public function addStores(array $stores): void
    {
        foreach ($this->products as $product) {
            foreach ($stores as $productStore) {
                if ($productStore->sku() === $product->sku()) {
                    $product->addStore($productStore->getStore());
                }
            }
        }
    }

    public function toArray(): array
    {
        return $this->products;
    }
}
