<?php

namespace App\Presenters\Pricing\Product;

use Barrigudinha\Pricing\Data\Product as PricingProduct;

class Presenter
{
    public function singleProduct(PricingProduct $product): Product
    {
        return new Product($product);
    }

    public function prices(PricingProduct $product): array
    {
        foreach($product->prices() as $price) {
            $pricePresentation[] = new Price($price);
        }

        return $pricePresentation ?? [];
    }
}
