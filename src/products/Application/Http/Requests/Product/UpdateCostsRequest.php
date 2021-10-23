<?php

namespace Src\Products\Application\Http\Requests\Product;

use Src\Products\Domain\Data\Costs;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCostsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'purchasePrice' => 'nullable|numeric',
            'taxICMS' => 'nullable|numeric',
            'additionalCosts' => 'nullable|numeric',
        ];
    }
}