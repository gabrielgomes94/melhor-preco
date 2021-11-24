<?php

namespace Src\Prices\Calculator\Application\Http\Transformers;

use Src\Math\Percentage;
use Src\Prices\Calculator\Application\Http\Requests\CalculatePriceRequest;
use Src\Prices\Calculator\Domain\Services\Contracts\CalculatorOptions;

class CalculatePriceTransformer
{
    public function transform(CalculatePriceRequest $request): array
    {
        $data = $request->validated();

        return [
            'productId' => $data['product'],
            'storeSlug' => $data['store'],
            'price' => (float) $data['desiredPrice'],
            'commission' => Percentage::fromPercentage($data['commission']),
            'options' => [
                CalculatorOptions::DISCOUNT_RATE => Percentage::fromPercentage($data['discount'])
            ]
        ];
    }
}
