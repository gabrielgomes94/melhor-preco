<?php

namespace Src\Costs\Infrastructure\Laravel\Http\Requests;

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
