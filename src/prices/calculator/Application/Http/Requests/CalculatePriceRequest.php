<?php

namespace Src\Prices\Calculator\Application\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Prices\Calculator\Application\Rules\Store;

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
            'commission' => 'numeric',
            'discount' => 'numeric|nullable',
            'product' => 'string',
            'store' => [new Store()],
        ];
    }
}
