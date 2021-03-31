<?php

namespace App\Presenters\Pricing\Data;

use App\Models\PriceCampaign;

class DetailedPricing
{
    public string $name;

    /**
     * @var Product[]
     */
    public array $products;

    /**
     * @var string
     */
    public array $stores;

    public static function createFromModel(PriceCampaign $pricing): self
    {
        $presentationPricing = new DetailedPricing();
        $presentationPricing->name = $pricing->name;
        $presentationPricing->products = self::setProducts($pricing);
        $presentationPricing->stores = self::setStores($pricing);

        return $presentationPricing;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'products' => array_map(function($product){
                return $product->toArray();
            }, $this->products),
            'stores' => $this->stores,
        ];
    }

    private static function setProducts(PriceCampaign $pricing): array
    {
        return array_map(function($product){
            return new Product(
                sku: $product['sku'],
                prices: $product['prices'],
            );
        }, $pricing->products);
    }

    private static function setStores(PriceCampaign $pricing): array
    {
        return array_map(function($store){
            return $store['name'];
        }, $pricing->stores);
    }
}
