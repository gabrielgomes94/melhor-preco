<?php

namespace App\Presenters\Pricing\Product;

use Barrigudinha\Product\Product as ProductData;
use Barrigudinha\Pricing\Data\Tax;

class Product
{
    public string $id;
    public string $name;
    public string $sku;
    public float $purchasePrice;
//    public float $taxIPI;
    public float $taxICMS;
//    public float $taxSimplesNacional;
    public float $additionalCosts;
    public array $prices;

    public function __construct(ProductData $product)
    {
        $this->id = $product->sku();
        $this->name = $product->name();
        $this->sku = $product->sku();
        $this->purchasePrice = $product->costs()->purchasePrice();
//        $this->taxIPI = (float) $product?->tax(Tax::IPI)?->rate;
        $this->taxICMS = (float) $product->costs()->taxICMS();
//        $this->taxSimplesNacional = (float) $product?->tax(Tax::SIMPLES_NACIONAL)?->rate;
        $this->additionalCosts = $product->costs()->additionalCosts();
    }
}
