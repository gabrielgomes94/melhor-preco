<?php

namespace Tests\Legacy\Data\Pricing;

use Barrigudinha\Pricing\Data\Product;

class ProductData
{
    public static function build(): Product
    {
        return new Product([
            'id' => '1231',
            'name' => 'Produto de Teste',
            'sku' => '1231',
            'purchase_price' =>  1000.0,
            'tax_icms' => 12.0,
            'additional_costs' => 0.0,
        ]);
    }
}
