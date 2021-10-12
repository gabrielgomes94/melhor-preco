<?php

namespace Integrations\Bling\Products\Responses\Data;

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

    public function count(): int
    {
        return count($this->products);
    }

    public function toArray(): array
    {
        return $this->products;
    }
}
