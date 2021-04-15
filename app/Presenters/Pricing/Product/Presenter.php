<?php

namespace App\Presenters\Pricing\Product;

use Barrigudinha\Pricing\Data\Product as PricingProduct;

class Presenter
{
    public function single(PricingProduct $product): Product
    {
        return new Product($product);
    }
}
