<?php

namespace Barrigudinha\Product\Services;

use Barrigudinha\Product\Data\Costs;
use Barrigudinha\Product\Product;

class Update
{
    public function updateCosts(Product $product, array $data): Product
    {
        $costs = new Costs(
            purchasePrice: $data['purchasePrice'] ?? $product->costs()->purchasePrice(),
            additionalCosts: $data['additionalCosts'] ?? $product->costs()->additionalCosts(),
            taxICMS: $data['taxICMS'] ?? $product->costs()->taxICMS(),
        );

        $product->setCosts($costs);

        // To Do: calcular lucro com os preços atualizados

        return $product;
    }
}
