<?php

namespace App\Exports\B2W;

use Barrigudinha\Pricing\Data\Pricing;
use Barrigudinha\Pricing\Data\Product;
use Maatwebsite\Excel\Concerns\FromArray;

class PriceExport implements FromArray

{
    private Pricing $pricing;

    /** @var Product[] $products  */
    private array $products;

    public function __construct(array $products)
    {
        $this->products = $products;
    }

    public function array(): array
    {
        $firstRow = [
            'ID do Parceiro',
            'Cód Item Parceiro',
            'Preço de',
            'Preço por',
            'Marca'
        ];

        $prices = array_map(function($product) {
            return [
                '11927457000162',
                $product->getStoreSku('b2w'),
                $product->getPriceFromStore('b2w') * 1.1,
                $product->getPriceFromStore('b2w'),
                'LOJASAMERICANAS'
            ];
        }, $this->products);

        return array_merge([$firstRow], $prices);
    }
}
