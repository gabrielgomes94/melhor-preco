<?php

namespace Src\Prices\Calculator\Application\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\Prices\Calculator\Application\Rules\Store;

class CalculatePriceRequest extends FormRequest
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
            'desiredPrice' => 'numeric',
            'commission' => 'numeric',
            'discount' => 'numeric|nullable',
            'product' => 'string',
            'store' => [new Store()],
        ];
    }
}
