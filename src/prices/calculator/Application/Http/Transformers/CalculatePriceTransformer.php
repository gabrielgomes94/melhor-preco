<?php

namespace Src\Prices\Calculator\Application\Http\Transformers;

use Src\Prices\Calculator\Application\Http\Requests\CalculatePriceRequest;
use Src\Prices\Calculator\Domain\Services\CalculatorOptions;
use Src\Prices\Calculator\Domain\Transformer\PercentageTransformer;

class CalculatePriceTransformer
{
    public function transform(CalculatePriceRequest $request): array
    {
        $data = $request->validated();

        return [
            'productId' => $data['product'],
            'storeSlug' => $data['store'],
            'price' => (float) $data['desiredPrice'],
            'commission' => (float) $data['commission'],
            'options' => [
                CalculatorOptions::DISCOUNT_RATE => $this->getDiscount($data)
            ]
        ];
    }

    private function getDiscount(array $data): float
    {
        return PercentageTransformer::toPercentage(
            (float) $data['discount'] ?? null
        );
    }
}
