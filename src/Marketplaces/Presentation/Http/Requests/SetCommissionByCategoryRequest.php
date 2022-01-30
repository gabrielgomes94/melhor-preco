<?php

namespace Src\Marketplaces\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetCommissionByCategoryRequest extends FormRequest
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
            'commission' => 'array',
            'categoryName' => 'array',
            'categoryId' => 'array',
        ];
    }
}
