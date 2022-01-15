<?php

namespace Src\Products\Application\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCostsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'purchasePrice' => 'nullable|numeric',
            'taxICMS' => 'nullable|numeric',
            'additionalCosts' => 'nullable|numeric',
        ];
    }
}
