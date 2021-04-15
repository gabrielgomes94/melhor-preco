<?php

namespace App\Presenters\Pricing\Product;

use App\Models\Product as ProductModel;
use Barrigudinha\Pricing\Data\Product as PricingProduct;

class Product
{
    public string $name;
    public string $sku;
    public float $purchasePrice;
    public float $taxIPI;
    public float $taxICMS;
    public float $taxSimplesNacional;
    public float $additionalCosts;

    public function __construct(PricingProduct $product)
    {
//        dd($product);
        $this->name = $product->name();
        $this->sku = $product->sku();
        $this->purchasePrice = $product->purchasePrice();
//        $this->name = $product->name();
    }
}
