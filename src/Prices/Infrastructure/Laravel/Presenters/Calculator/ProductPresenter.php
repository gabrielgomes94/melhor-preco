<?php

namespace Src\Prices\Infrastructure\Laravel\Presenters\Calculator;

use Src\Marketplaces\Domain\Models\Marketplace;
use Src\Math\Transformers\NumberTransformer;
use Src\Products\Infrastructure\Laravel\Models\Product\Product;

class ProductPresenter
{
    public function present(Marketplace $marketplace, Product $product): array
    {
        return [
            'id' => $product->getSku(),
            'header' => $this->getProductHeader($product),
            'currentPrice' => NumberTransformer::toMoney($product->getPrice($marketplace)->getValue()),
        ];
    }

    private function getProductHeader(Product $product): string
    {
        return $product->getSku() . ' - ' . $product->getName();
    }
}
