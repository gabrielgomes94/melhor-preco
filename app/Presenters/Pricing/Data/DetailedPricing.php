<?php

namespace App\Presenters\Pricing\Data;

use App\Models\PriceCampaign;
use App\Models\Pricing;

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

    public static function createFromModel(Pricing $pricing): self
    {
        $presentationPricing = new DetailedPricing();

        $presentationPricing->id = $pricing->id;
        $presentationPricing->name = $pricing->name;
        $presentationPricing->products = self::setProducts($pricing);
////        $presentationPricing->stores = self::setStores($pricing);

        return $presentationPricing;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'products' => array_map(function(Product $product){
                return $product->toArray();
            }, $this->products),
//            'stores' => $this->stores,
        ];
    }

    private static function setProducts(Pricing $pricing): array
    {
        return array_map(function( $product){
            return new Product(
                id: $product['id'],
                sku: $product['sku'],
                name: $product['name'],
                prices: []
//                prices: $product['prices'],
            );
        }, $pricing->products->toArray());
    }
//
//    private static function setStores(Pricing $pricing): array
//    {
//        return array_map(function($store){
//            return $store['name'];
//        }, $pricing?->stores ?? []);
//    }
}
