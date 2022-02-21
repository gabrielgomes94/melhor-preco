<?php

namespace Src\Calculator\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Calculator\Presentation\Rules\Store;

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
}
