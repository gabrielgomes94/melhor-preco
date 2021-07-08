<?php

namespace App\Services\Product;

use Barrigudinha\Product\Data\UpdateCosts;
use Barrigudinha\Product\Product;
use Barrigudinha\Product\Services\Contracts\Update as UpdateInterface;

class Update implements UpdateInterface
{
    public function updateCosts(Product $product, UpdateCosts $costs): Product
    {
        $product->setAdditionalCosts($costs->additionalCosts());
        $product->setPurchasePrice($costs->purchasePrice());
        $product->setTaxICMS($costs->taxICMS());

        return $product;
    }
}
