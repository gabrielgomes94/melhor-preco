<?php

namespace Src\Calculator\Presentation\Http\Transformers;

use Src\Math\Percentage;
use Src\Calculator\Presentation\Http\Requests\CalculatePriceRequest;
use Src\Calculator\Domain\Services\Contracts\CalculatorOptions;

class CalculatePriceTransformer
{
    public function transform(CalculatePriceRequest $request): array
    {
        $data = $request->validated();

        return [
            'productId' => $data['product'],
            'storeSlug' => $data['store'],
            'price' => (float) $data['desiredPrice'],
            'commission' => Percentage::fromPercentage((float) $data['commission']),
            'options' => [
                CalculatorOptions::DISCOUNT_RATE => Percentage::fromPercentage($data['discount'] ?? 0)
            ]
        ];
    }
}
