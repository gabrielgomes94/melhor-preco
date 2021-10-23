<?php

namespace Src\Prices\Price\Application\Http\Requests\Price;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePriceRequest extends FormRequest
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
            'profit' => 'required|numeric',
            'storeSlug' => 'required',
            'value' => 'required|numeric',
        ];
    }
}
