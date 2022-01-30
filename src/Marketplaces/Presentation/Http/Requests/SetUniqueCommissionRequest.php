<?php

namespace Src\Marketplaces\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetUniqueCommissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'commission' => 'numeric',
        ];
    }
}
