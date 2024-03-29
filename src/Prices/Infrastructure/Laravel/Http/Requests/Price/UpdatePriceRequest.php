<?php

namespace Src\Prices\Infrastructure\Laravel\Http\Requests\Price;

use Illuminate\Foundation\Http\FormRequest;

/** @todo: remove this class
 *  @deprecated
 **/
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
            'marketplaceSlug' => 'required',
            'value' => 'required|numeric',
        ];
    }
}
