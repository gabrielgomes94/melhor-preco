<?php

namespace Src\Calculator\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Calculator\Domain\Services\Contracts\CalculatorOptions;
use Src\Calculator\Presentation\Rules\Store;
use Src\Math\Percentage;

class CalculatePriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'desiredPrice' => 'numeric',
            'commission' => 'string',
            'discount' => 'numeric|nullable',
            'product' => 'string',
            'store' => 'in:b2w,magalu,mercado-livre,mercado-shops,olist,shopee',
            'freeFreight' => 'boolean',
        ];
    }

    public function hasFreeFreight(): bool
    {
        return $this->input('freeFreight') ?? false;
    }

    public function transform(): array
    {
        $data = $this->all();

        return [
            'productId' => $data['product'],
            'storeSlug' => $data['store'],
            'price' => (float) $data['desiredPrice'],
            'commission' => Percentage::fromPercentage((float) $data['commission']),
            'options' => [
                CalculatorOptions::DISCOUNT_RATE => Percentage::fromPercentage($data['discount'] ?? 0),
                CalculatorOptions::FREE_FREIGHT => $this->hasFreeFreight(),
            ]
        ];
    }
}
