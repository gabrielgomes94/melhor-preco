<?php

namespace Src\Promotions\Infrastructure\Laravel\Presenters;

use Src\Math\MathPresenter;
use Src\Promotions\Domain\Models\Promotion;

class ShowPromotionPresenter
{
    public function present(Promotion $promotion): array
    {
        return [
            'name' => $promotion->getName(),
            'beginDate' => $promotion->getBeginDate(),
            'endDate' => $promotion->getEndDate(),
            'discount' => $promotion->getDiscount(),
            'uuid' => $promotion->getUuid(),
            'products' => $this->presentProducts(
                $promotion->getProducts()
            ),
        ];
    }

    private function presentProducts(array $products): array
    {
        return array_map(function(array $product) {
            return [
                'value' => MathPresenter::money($product['value']),
                'profit' => MathPresenter::money($product['profit']),
                'name' => $product['name'],
                'sku' => $product['sku'],
            ];
        }, $products);
    }
}