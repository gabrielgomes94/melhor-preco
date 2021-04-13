<?php

namespace App\Presenters\Pricing\Show;

use App\Models\Pricing as PricingModel;
use App\Models\Product as ProductModel;

class Pricing
{
    public string $id;

    public string $name;

    /**
     * @var Product[]
     */
    public array $products;

    /**
     * @var string
     */
    public array $stores;

    public function __construct(PricingModel $pricing)
    {
        $this->id = $pricing->id;
        $this->name = $pricing->name;
        $this->products = $this->setProducts($pricing);
        $this->stores = $this->setStores($pricing);
    }

    private function setProducts(PricingModel $pricing): array
    {
        $products = array_map(function(ProductModel $product) use ($pricing){
            return new Product($product, $pricing->stores);
        }, $pricing->products->all());

        $products = array_filter($products, function(Product $product){
            return $product->isValid();
        });

        return $products;
    }

    private function setStores(PricingModel $pricing): array
    {
        return array_map(function($store){
            return config('stores.' . $store . '.name');
        }, $pricing?->stores ?? []);
    }
}
